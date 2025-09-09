<?php
declare(strict_types=1);
session_start();
require_once 'connect_bdd.php'; // $conn = new mysqli(...);

/* ------------------------------
   Config présence
------------------------------- */
$TTL_MIN = 2; // utilisateur considéré "en ligne" s'il a pingé dans les 2 dernières minutes

/* ------------------------------
   Helpers
------------------------------- */
function json_out($data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function db_ok($conn): bool { return $conn && $conn->connect_errno === 0; }

/* ------------------------------
   Ping + liste via AJAX
------------------------------- */
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    if (!db_ok($conn)) json_out(['error' => 'Erreur de connexion BDD'], 500);

    // 1) PING: si utilisateur en session, maj last_activity
    if (!empty($_SESSION['user']['username'])) {
        $username = $_SESSION['user']['username'];
        if ($stmt = $conn->prepare("UPDATE users SET last_activity = NOW() WHERE username = ?")) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->close();
        }
    }

    // 2) LISTE: seuil since
    $since = date('Y-m-d H:i:s', time() - $TTL_MIN * 60);
    if ($stmt = $conn->prepare("
        SELECT username, zip_code, age, ville_users, avatar, last_activity
        FROM users
        WHERE last_activity >= ?
        ORDER BY last_activity DESC
    ")) {
        $stmt->bind_param("s", $since);
        $stmt->execute();
        $res = $stmt->get_result();
        $users = [];
        while ($row = $res->fetch_assoc()) {
            // Optionnel: avatar par défaut si vide
            if (empty($row['avatar'])) $row['avatar'] = 'uploads/avatar_default.jpg';
            $users[] = $row;
        }
        $stmt->close();
        json_out($users);
    } else {
        json_out(['error' => 'Erreur SQL: '.$conn->error], 500);
    }
}

/* ------------------------------
   Requête classique: rendu HTML
------------------------------- */
if (!db_ok($conn)) {
    die("Erreur de connexion à la base de données");
}

// Mise à jour d'activité au chargement si connecté
if (!empty($_SESSION['user']['username'])) {
    $username = $_SESSION['user']['username'];
    if ($stmt = $conn->prepare("UPDATE users SET last_activity = NOW() WHERE username = ?")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
    }
}

// Liste initiale
$since = date('Y-m-d H:i:s', time() - $TTL_MIN * 60);
$users = [];
if ($stmt = $conn->prepare("
    SELECT username, zip_code, age, ville_users, avatar, last_activity
    FROM users
    WHERE last_activity >= ?
    ORDER BY last_activity DESC
")) {
    $stmt->bind_param("s", $since);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        if (empty($row['avatar'])) $row['avatar'] = 'uploads/avatar_default.jpg';
        $users[] = $row;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat en ligne</title>
  <link rel="stylesheet" href="style/salon.css">
  <style>
    /* Habillage léger si besoin */
    .wrap{max-width:980px;margin:20px auto;padding:0 12px}
    .user{display:flex;gap:12px;align-items:center;margin-bottom:10px}
    .container_avatar_user{width:84px;height:84px;border-radius:10px;overflow:hidden;border:1px solid #2b3443}
    .container_avatar_user img.avatar_user{width:100%;height:100%;object-fit:cover;display:block}
    .info_user p{margin:0}
  </style>
</head>
<body>
<section class="wrap">
  <h2>Utilisateurs en ligne</h2>
  <div id="user-list">
    <?php foreach ($users as $user): ?>
      <div class="user">
        <div class="container_avatar_user">
          <img class="avatar_user" src="<?= e($user['avatar']) ?>"
               alt="Avatar de <?= e($user['username']) ?>">
        </div>
        <div class="info_user">
          <p><?= e($user['username']) ?> - <?= e($user['zip_code']) ?> - <?= (int)$user['age'] ?> ans (<?= e($user['ville_users']) ?>)</p>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if (empty($users)): ?>
      <p>Aucun utilisateur en ligne pour l’instant.</p>
    <?php endif; ?>
  </div>
</section>

<script>
/* Construction DOM safe (pas d'innerHTML texte brut) */
function elt(tag, cls, text){
  const n = document.createElement(tag);
  if (cls) n.className = cls;
  if (text !== undefined) n.textContent = text;
  return n;
}

function renderUsers(users){
  const box = document.getElementById('user-list');
  if (!box) return;
  box.innerHTML = ''; // ok, on repart propre

  if (!Array.isArray(users) || !users.length){
    box.appendChild(elt('p', null, 'Aucun utilisateur en ligne pour l’instant.'));
    return;
  }
  users.forEach(u=>{
    const line = elt('div','user');

    const avatarWrap = elt('div','container_avatar_user');
    const img = new Image();
    img.className = 'avatar_user';
    img.src = u.avatar || 'uploads/avatar_default.jpg';
    img.alt = 'Avatar de '+ (u.username || '');
    avatarWrap.appendChild(img);

    const info = elt('div','info_user');
    const p = elt('p', null,
      (u.username||'') + ' - ' + (u.zip_code||'') + ' - ' + (u.age||'') + ' ans (' + (u.ville_users||'') + ')'
    );
    info.appendChild(p);

    line.appendChild(avatarWrap);
    line.appendChild(info);
    box.appendChild(line);
  });
}

async function refreshUsers(){
  try{
    const r = await fetch('chat.php?ajax=1', {cache: 'no-store', credentials: 'same-origin'});
    const j = await r.json();
    if (Array.isArray(j)) renderUsers(j);
  }catch(e){ /* console.warn(e); */ }
}

/* Intervalle raisonnable pour éviter de charger le serveur */
setInterval(refreshUsers, 5000); // 5 s suffit largement
refreshUsers(); // premier chargement
</script>
</body>
</html>
