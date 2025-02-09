<?php
session_start();
require 'connect_bdd.php';

// Créons une page salon_chat.php qui affichera les messages du salon en temps réel 
// et permettra d'envoyer de nouveaux messages.


if (!isset($_GET['salon_id'])) {
    die('Salon non spécifié.');
}

$salon_id = $_GET['salon_id'];

// Récupérer les informations du salon
$sql = "SELECT name FROM salon WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $salon_id);
$stmt->execute();
$stmt->bind_result($salon_name);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon: <?= htmlspecialchars($salon_name) ?></title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Salon: <?= htmlspecialchars($salon_name) ?></h2>
    <div id="chat-messages"></div>

    <form id="chat-form">
        <input type="text" id="chat-input" placeholder="Tapez votre message..." autocomplete="off">
        <button type="submit">Envoyer</button>
    </form>

    <script src="/socket.io/socket.io.js"></script>
    <script src="fonction/function.js"></script>
</body>
</html>
