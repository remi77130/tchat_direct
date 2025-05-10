<?php
require 'connect_bdd.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Récupération et sécurisation des données POST
$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
$age      = isset($_POST['age']) ? (int) $_POST['age'] : 0;
$gender   = isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : '';
$zip_code = isset($_POST['zip_code']) ? htmlspecialchars($_POST['zip_code']) : '';
// Ici, on utilise "ville_users" comme nom de variable pour la ville
$ville = isset($_POST['ville_users']) ? htmlspecialchars($_POST['ville_users']) : '';

    // Validation des données
    if (strlen($pseudo) < 3 || strlen($pseudo) > 120) {
        die("Ton pseudo doit contenir entre 3 et 12 caractères.");
    }

    $age = filter_var($age, FILTER_VALIDATE_INT);
    if  ($age === false || $age < 15 || $age > 89) {
        die("Âge invalide.");
    }

    if (!in_array($gender, ['male', 'female', 'other'])) {
        die("Genre invalide.");
    }


   // Générer un pseudo unique
   $original_pseudo = $pseudo;
   $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
   if ($stmt === false) {
       error_log("Erreur de préparation de la requête : " . $conn->error);
       echo "Une erreur interne est survenue. Veuillez réessayer plus tard.";
       exit;
   }

   $pseudo_taken = true;
   $i = 1;  // Variable pour incrémenter le pseudo en cas de doublon

   // Boucle tant que le pseudo est déjà pris
   while ($pseudo_taken) {
       $stmt->bind_param("s", $pseudo);
       $stmt->execute();
       $stmt->store_result();

       if ($stmt->num_rows > 0) {
           // Si le pseudo est déjà pris, on ajoute un nombre à la fin
           $pseudo = $original_pseudo . $i;
           $i++;
       } else {
           $pseudo_taken = false;
       }
   }
   $stmt->close();

    // Gestion de l'upload de l'avatar defaut si aucun fichier n'a été téléchargé
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

        // Déplacement du fichier téléchargé vers le dossier cible.  Si l'appel à move_uploaded_file() échoue, l'avatar ne sera pas sauvegardé et l'image par défaut sera utilisée.
		ini_set('display_errors', 1);error_reporting(E_ALL);
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
    // Liaison des paramètres (utilise les variables cohérentes)
$stmt->bind_param("ssisss", $username, $avatar, $age, $gender, $zip_code, $ville);

if ($stmt->execute()) {
    // Enregistrement de l'utilisateur dans la session
    $id = $conn->insert_id;
    $myuser = [
        'id'         => $id,
        'username'   => $username,
        'avatar'     => $avatar,
        'age'        => $age,
        'gender'     => $gender,
        'zip_code'   => $zip_code,
        'ville_users'=> $ville,
    ];
    $_SESSION['user'] = $myuser;

    header("Location: chat.php");
    exit();
} else {
    error_log("Erreur lors de l'exécution de la requête : " . $stmt->error);
    die("Une erreur est survenue lors de l'inscription.");

$conn->close();
?>
