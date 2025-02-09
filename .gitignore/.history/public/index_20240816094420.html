<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie en Temps Réel</title>
    <style>
        /* Styles de base pour la messagerie */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        #chat-container { max-width: 800px; margin: 0 auto; padding: 20px; }
        #messages { list-style-type: none; margin: 0; padding: 0; }
        #messages li { padding: 8px; margin-bottom: 10px; background-color: #fff; border-radius: 5px; }
        #message-form { display: flex; }
        #message-form input { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        #message-form button { padding: 10px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        #users { margin-top: 20px; }
        #users ul { list-style-type: none; margin: 0; padding: 0; }
        #users li { padding: 8px; margin-bottom: 10px; background-color: #fff; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div id="chat-container">
        <div id="users">
            <h3>Utilisateurs</h3>
            <ul id="user-list">
                <!-- La liste des utilisateurs sera insérée ici -->
            </ul>
        </div>
        <ul id="messages"></ul>
        <form id="message-form" action="">
            <input id="message-input" autocomplete="off" placeholder="Tapez votre message ici..." />
            <button type="submit">Envoyer</button>
        </form>
    </div>

    <!-- Inclusion de Socket.io -->
    <script src="/socket.io/socket.io.js"></script>
    <script>
        const socket = io();

        // Ecouter les messages du serveur
        socket.on('chat message', function(msg){
            const item = document.createElement('li');
            item.textContent = msg;
            document.getElementById('messages').appendChild(item);
            window.scrollTo(0, document.body.scrollHeight);
        });

        // Envoyer un message au serveur
        document.getElementById('message-form').addEventListener('submit', function(e){
            e.preventDefault();
            const input = document.getElementById('message-input');
            if(input.value) {
                socket.emit('chat message', input.value);
                input.value = '';
            }
        });

        // Exemple de gestion des utilisateurs (remplacer par une vraie liste d'utilisateurs)
        const users = ['Alice', 'Bob', 'Charlie'];
        const userList = document.getElementById('user-list');
        users.forEach(user => {
            const li = document.createElement('li');
            li.textContent = user;
            li.onclick = () => {
                // Code pour ouvrir une fenêtre de discussion avec l'utilisateur sélectionné
                alert(`Discuter avec ${user}`);
            };
            userList.appendChild(li);
        });
    </script>
</body>
</html>
