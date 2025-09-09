<?php
/****************************************************
 * signup_process.php — traitement d'inscription
 * - Validation serveur
 * - Upload avatar + thumb 256x256
 * - CSRF (si présent dans le form)
 * - Session + redirection vers chat.php
 * - Optionnel : insertion PDO si config.php existe
 ****************************************************/

declare(strict_types=1);
mb_internal_encoding('UTF-8');
session_start();

// ---------- Utilitaires ----------
function fail(string $msg, int $code=400): void {
    http_response_code($code);
    $safe = htmlspecialchars($msg, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    echo "<!doctype html><meta charset='utf-8'><title>Erreur</title>
          <style>body{font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial;padding:24px;background:#0b0f17;color:#e7eaf0}
          .card{max-width:680px;margin:auto;background:#111827cc;border:1px solid #2b3443;border-radius:14px;padding:24px}
          a{color:#22d3ee}</style>
          <div class='card'><h1>Oops</h1><p>$safe</p>
          <p><a href='javascript:history.back()'>&larr; Retour</a></p></div>";
    exit;
}

function has_gd(): bool {
    return extension_loaded('gd') || extension_loaded('gd2');
}

/**
 * Crée une miniature carrée JPEG 256x256 depuis $src (temp file upload)
 * Retourne le chemin public (ex: uploads/avatars/ava_xxx.jpg)
 */
function make_avatar_thumb(string $src, string $destDir='uploads/avatars'): ?string {
    if (!is_file($src)) return null;
    if (!is_dir($destDir) && !mkdir($destDir, 0755, true)) return null;

    // Détection MIME
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($src) ?: '';
    $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
    if (!in_array($mime, $allowed, true)) return null;

    // Si GD absent, on sauvegarde brut (sans thumb)
    if (!has_gd()) {
        $name = 'ava_'.bin2hex(random_bytes(8));
        $ext  = match($mime){ 'image/png'=>'.png','image/gif'=>'.gif','image/webp'=>'.webp', default => '.jpg' };
        $dest = rtrim($destDir,'/').'/'.$name.$ext;
        if (!move_uploaded_file($src, $dest)) return null;
        return $dest;
    }

    // Lecture
    switch ($mime) {
        case 'image/jpeg': $img = imagecreatefromjpeg($src); break;
        case 'image/png' : $img = imagecreatefrompng($src);  break;
        case 'image/gif' : $img = imagecreatefromgif($src);  break;
        case 'image/webp': $img = imagecreatefromwebp($src); break;
        default: $img = null;
    }
    if (!$img) return null;

    $w = imagesx($img); $h = imagesy($img);
    if ($w <= 0 || $h <= 0) { imagedestroy($img); return null; }

    // Crop centré + resize 256
    $side = min($w, $h);
    $srcX = intdiv(max($w - $side, 0), 2);
    $srcY = intdiv(max($h - $side, 0), 2);
    $thumb = imagecreatetruecolor(256, 256);
    imagecopyresampled($thumb, $img, 0, 0, $srcX, $srcY, 256, 256, $side, $side);

    $name = 'ava_'.bin2hex(random_bytes(8)).'.jpg';
    $dest = rtrim($destDir,'/').'/'.$name;
    imagejpeg($thumb, $dest, 85);
    imagedestroy($img);
    imagedestroy($thumb);

    return $dest;
}

/** Normalise le genre vers 'male'|'female' */
function normalize_gender(?string $raw): ?string {
    if ($raw === null) return null;
    $g = mb_strtolower(trim($raw), 'UTF-8');
    $g = strtr($g, ['à'=>'a','â'=>'a','ä'=>'a','é'=>'e','è'=>'e','ê'=>'e','ë'=>'e','î'=>'i','ï'=>'i','ô'=>'o','ö'=>'o','ù'=>'u','û'=>'u','ü'=>'u','ç'=>'c']);
    $map = [
        'male'=>'male','m'=>'male','homme'=>'male','masculin'=>'male','man'=>'male',
        'female'=>'female','f'=>'female','femme'=>'female','feminin'=>'female','woman'=>'female'
    ];
    return $map[$g] ?? null;
}

/** Récupère $_POST string trim */
function post_str(string $key): string {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : '';
}

// ---------- Méthode ----------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail('Méthode non autorisée.', 405);
}

// ---------- CSRF (optionnel si présent) ----------
if (isset($_POST['csrf']) || isset($_SESSION['csrf'])) {
    $tokenSession = (string)($_SESSION['csrf'] ?? '');
    $tokenPost    = (string)($_POST['csrf'] ?? '');
    if ($tokenSession === '' || $tokenPost === '' || !hash_equals($tokenSession, $tokenPost)) {
        fail('Requête invalide (CSRF).');
    }
}

// ---------- Validation champs ----------
$username = post_str('username');            // pattern: [A-Za-z0-9_]{3,12}
$ageStr   = post_str('age');
$zip      = post_str('zip_code');            // 5 chiffres
$ville    = post_str('ville_users');         // texte non vide
$gender   = normalize_gender($_POST['gender'] ?? ($_POST['sexe'] ?? null));

if (!preg_match('/^[A-Za-z0-9_]{3,12}$/', $username)) {
    fail('Pseudo invalide. Utilise 3 à 12 caractères alphanumériques ou underscore.');
}

$age = (int)$ageStr;
if ($age < 18 || $age > 99) {
    fail('Âge invalide. Il doit être compris entre 18 et 99 ans.');
}

if (!preg_match('/^\d{5}$/', $zip)) {
    fail('Code postal invalide. Il doit comporter 5 chiffres.');
}

if ($ville === '') {
    fail('Ville manquante. Sélectionne une ville.');
}

if ($gender === null || !in_array($gender, ['male','female'], true)) {
    fail('Genre invalide.');
}

// ---------- Upload avatar ----------
$avatarPath = 'uploads/avatar_default.jpg'; // défaut
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
        // on ignore l’avatar si erreur upload ; on garde l’avatar par défaut
    } else {
        $size = (int)($_FILES['avatar']['size'] ?? 0);
        if ($size > 2*1024*1024) {
            // > 2 Mo : on ignore et on garde le défaut (tu peux fail() si tu veux bloquer)
        } else {
            $thumb = make_avatar_thumb($_FILES['avatar']['tmp_name']);
            if ($thumb) $avatarPath = $thumb;
        }
    }
}

// ---------- Session utilisateur ----------
$_SESSION['user'] = [
    'username' => $username,
    'age'      => $age,
    'zip'      => $zip,
    'ville'    => $ville,
    'gender'   => $gender,                        // male|female
    'gender_label' => $gender === 'male' ? 'Homme' : 'Femme',
    'avatar'   => $avatarPath,
    'created_at' => date('c'),
];

// ---------- (Optionnel) Sauvegarde BDD si config.php présent ----------
if (file_exists(__DIR__.'/config.php')) {
    require __DIR__.'/config.php';
    // Attendu dans config.php :
    //   define('DB_DSN', 'mysql:host=localhost;dbname=tondb;charset=utf8mb4');
    //   define('DB_USER', 'user');
    //   define('DB_PASS', 'pass');
    try {
        $pdo = new PDO(DB_DSN, DB_USER ?? null, DB_PASS ?? null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        // Table simple d’exemple (adapte à ton schéma si tu en as déjà un)
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(32) NOT NULL,
                age TINYINT UNSIGNED NOT NULL,
                gender ENUM('male','female') NOT NULL,
                zip_code CHAR(5) NOT NULL,
                ville VARCHAR(100) NOT NULL,
                avatar_path VARCHAR(255) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY uniq_username (username)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $stmt = $pdo->prepare("
            INSERT INTO users (username, age, gender, zip_code, ville, avatar_path)
            VALUES (:u, :a, :g, :z, :v, :p)
            ON DUPLICATE KEY UPDATE
                age=VALUES(age), gender=VALUES(gender), zip_code=VALUES(zip_code),
                ville=VALUES(ville), avatar_path=VALUES(avatar_path)
        ");
        $stmt->execute([
            ':u' => $username,
            ':a' => $age,
            ':g' => $gender,
            ':z' => $zip,
            ':v' => $ville,
            ':p' => $avatarPath,
        ]);
    } catch (Throwable $e) {
        // On n’interrompt pas l’inscription si la BDD échoue ; on peut logger si besoin
        // error_log('DB error: '.$e->getMessage());
    }
}

// ---------- Redirection ----------
header('Location: chat.php');
exit;
