<?php
require 'connect_bdd.php';
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et sécurisation des données POST
  // signup_process.php (début)
$pseudo = $_POST['username'] ?? '';
$age    = (int)($_POST['age'] ?? 0);
$cp     = $_POST['zip_code'] ?? '';
$gender = $_POST['gender'] ?? ''; // male|female

if (!preg_match('/^[A-Za-z0-9_]{3,12}$/', $pseudo)) exit('Pseudo invalide.');
if ($age < 18 || $age > 99) exit('Âge invalide.');
if (!preg_match('/^\d{5}$/', $cp)) exit('Code postal invalide.');
if (!in_array($gender, ['male','female'], true)) exit('Genre invalide.');



    // Validation des données
    if (strlen($username) < 3 || strlen($username) > 120) {
        die("Ton pseudo doit contenir entre 3 et 120 caractères.");
    }

    $age = filter_var($age, FILTER_VALIDATE_INT);
    if ($age === false || $age < 15 || $age > 89) {
        die("Âge invalide.");
    }

    if (!in_array($gender, ['male', 'female', 'other'])) {
        die("Genre invalide.");
    }

    // Générer un pseudo unique
    $original_username = $username;
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    if ($stmt === false) {
        error_log("Erreur de préparation de la requête : " . $conn->error);
        echo "Une erreur interne est survenue. Veuillez réessayer plus tard.";
        exit;
    }

    $username_taken = true;
    $i = 1;  // Variable pour incrémenter le pseudo en cas de doublon

    // Boucle tant que le pseudo est déjà pris
    while ($username_taken) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Si le pseudo est déjà pris, on ajoute un nombre à la fin
            $username = $original_username . $i;
            $i++;
        } else {
            $username_taken = false;
        }
    }
    $stmt->close();

    // Gestion de l'upload de l'avatar (défaut si aucun fichier n'a été téléchargé)
    $avatarDestination = 'uploads/avatar_default.jpg'; // Image par défaut
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {

        $avatar = $_FILES['avatar'];
        $avatarName = $avatar['name'];
        $avatarTmpName = $avatar['tmp_name'];
        $avatarSize = $avatar['size'];
        $avatarError = $avatar['error'];
        $avatarType = $avatar['type'];

        $check = getimagesize($avatarTmpName);
        if ($check === false) {
            die("Le fichier n'est pas une image valide.");
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $avatarExt = strtolower(pathinfo($avatarName, PATHINFO_EXTENSION));

        if (!in_array($avatarExt, $allowed)) {
            die("Extension de fichier non autorisée. Les extensions autorisées sont : jpg, jpeg, png, gif.");
        }

        if ($avatarError !== 0) {
            die("Erreur lors du téléchargement du fichier.");
        }

        if ($avatarSize > 5000000) { // Limite de taille de 5MB
            die("Le fichier est trop volumineux.");
        }

        // Nouveau nom de fichier unique pour l'avatar
        $avatarNewName = uniqid('', true) . "." . $avatarExt;
        $avatarDestination = 'uploads/' . $avatarNewName;

        // Déplacement du fichier téléchargé vers le dossier cible
        if (!move_uploaded_file($avatarTmpName, __DIR__.'/'.$avatarDestination)) {
            error_log("Erreur lors du déplacement du fichier: " . error_get_last()['message']);
            die("Erreur lors du téléchargement de l'avatar.");
        }
    }

    // Préparation de la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO users (username, avatar, age, gender, zip_code, ville_users) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        error_log("Erreur de préparation de la requête : " . $conn->error);
        die("Une erreur interne est survenue. Veuillez réessayer plus tard.");
    }

    // Liaison des paramètres
    $stmt->bind_param("ssisss", $username, $avatarDestination, $age, $gender, $zip_code, $ville);

    if ($stmt->execute()) {
        // Enregistrement de l'utilisateur dans la session
        $id = $conn->insert_id;
        $myuser = [
            'id'          => $id,
            'username'    => $username,
            'avatar'      => $avatarDestination,
            'age'         => $age,
            'gender'      => $gender,
            'zip_code'    => $zip_code,
            'ville_users' => $ville,
        ];
        $_SESSION['user'] = $myuser;

        header("Location: chat.php");
        exit();
    } else {
        error_log("Erreur lors de l'exécution de la requête : " . $stmt->error);
        die("Une erreur est survenue lors de l'inscription.");
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Méthode de requête non autorisée.";
}
?>
