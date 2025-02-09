<?php
session_start();
require 'connect_bdd.php';

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
    <script>
        const socket = io.connect('http://localhost:3000');

        const salonId = <?= json_encode($salon_id) ?>;
        const userId = <?= json_encode($_SESSION['user_id']) ?>;

        socket.emit('join salon', salonId);

        // Récupérer les anciens messages du salon
        $.ajax({
            url: 'fetch_salon_messages.php',
            method: 'GET',
            data: { salon_id: salonId },
            dataType: 'json',
            success: function(data) {
                data.forEach(function(msg) {
                    $('#chat-messages').append('<p><strong>' + msg.username + ':</strong> ' + msg.message + '</p>');
                });
            }
        });

        // Envoi de nouveaux messages
        $('#chat-form').submit(function(e) {
            e.preventDefault();
            const message = $('#chat-input').val();
            if (message) {
                socket.emit('salon message', { salon_id: salonId, user_id: userId, message: message });
                $('#chat-input').val('');
            }
        });

        // Réception des messages en temps réel
        socket.on('salon message', function(data) {
            $('#chat-messages').append('<p><strong>' + data.username + ':</strong> ' + data.message + '</p>');
        });
    </script>
</body>
</html>
