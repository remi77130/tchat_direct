<?php

//Formulaire pour changer la couleur du pseudo

session_start();
include 'connect_bdd.php'; // Connexion à la base de données

if (!isset($_SESSION['user'])) {
    die("Vous devez être connecté pour modifier votre pseudo.");
}

// Récupérer la couleur actuelle
$sql = "SELECT pseudo_color FROM users WHERE id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres</title>
</head>
<body>
    <h2>Personnalisation du Pseudo</h2>
    <form action="save_pseudo_color.php" method="POST">
        <label>Choisissez votre couleur :</label>
        <input type="color" name="pseudo_color" value="<?= htmlspecialchars($user['pseudo_color']) ?>">
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
