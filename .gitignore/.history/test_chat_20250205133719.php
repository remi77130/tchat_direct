<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: index.php"); // Redirige vers l'accueil si aucun pseudo
    exit();
}

$user = $_SESSION['myuser']; // Récupérer le pseudo
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Temps Réel</title>
    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
</head>
<body>
    <h1>Chat en temps réel</h1>
    
    <input type="text" id="message" placeholder="Tapez un message">
    <button onclick="envoyerMessage()">Envoyer</button>
    
    <div id="messages"></div>

    <script>
        // Connexion au serveur Node.js + Socket.io
        const socket = io("http://localhost:3000");

        // Réception des messages en temps réel
        socket.on("message", (data) => {
            let div = document.createElement("div");
            div.textContent = data;
            document.getElementById("messages").appendChild(div);
        });

        // Envoi des messages
        function envoyerMessage() {
            let message = document.getElementById("message").value;
            socket.emit("message", message);
            document.getElementById("message").value = ""; // Vide le champ après envoi
        }
    </script>
</body>
</html>
