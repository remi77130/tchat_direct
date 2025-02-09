<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie en Temps Réel</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="user-table-container">
        <h3>Liste des Utilisateurs</h3>
        <table id="users-table">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Pseudo</th>
                    <th>Âge</th>
                    <th>Département</th>
                    <th>Genre</th>
                </tr>
            </thead>
            <tbody>
                <!-- Les utilisateurs seront insérés ici par AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Fenêtre de discussion privée -->
    <div id="private-chat-window" style="display: none;">
        <div id="private-chat-header">
            <span id="chat-with">Discussion avec :</span>
            <button id="close-chat">X</button>
        </div>
        <div id="private-chat-messages"></div>
        <form id="private-message-form">
            <input type="text" id="private-message-input" placeholder="Votre message..." autocomplete="off">
            <button type="submit">Envoyer</button>
        </form>
    </div>

    <script>
        // Fonction pour récupérer les utilisateurs et mettre à jour le tableau
        function fetchUsers() {
            $.ajax({
                url: 'fetch_users.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var tbody = $('#users-table tbody');
                    tbody.empty(); // Vide le tableau avant de le remplir
                    data.forEach(function(user) {
                        tbody.append(`
                            <tr data-username="${user.username}">
                                <td><img src="uploads/${user.avatar}" alt="Avatar" width="50"></td>
                                <td>${user.username}</td>
                                <td>${user.age}</td>
                                <td>${user.department}</td>
                                <td>${user.gender}</td>
                            </tr>
                        `);
                    });

                    // Ajout d'un gestionnaire d'événement pour ouvrir une discussion privée
                    $('#users-table tbody tr').click(function() {
                        var username = $(this).data('username');
                        openPrivateChat(username);
                    });
                }
            });
        }

        // Appeler fetchUsers toutes les 60 secondes
        setInterval(fetchUsers, 60000);

        // Appeler fetchUsers au chargement initial
        fetchUsers();

        // Fonction pour ouvrir une fenêtre de discussion privée
        function openPrivateChat(username) {
            $('#chat-with').text('Discussion avec : ' + username);
            $('#private-chat-window').show();

            // Envoyer des messages privés via Socket.io
            $('#private-message-form').submit(function(e) {
                e.preventDefault();
                var message = $('#private-message-input').val();
                if (message) {
                    socket.emit('private message', { recipient: username, message: message });
                    $('#private-chat-messages').append('<p><strong>Vous:</strong> ' + message + '</p>');
                    $('#private-message-input').val('');
                }
            });
        }

        // Fermer la fenêtre de discussion privée
        $('#close-chat').click(function() {
            $('#private-chat-window').hide();
            $('#private-chat-messages').empty();
        });

        // Initialiser la connexion Socket.io
        const socket = io.connect('http://localhost:3000');

        // Gérer les messages privés reçus
        socket.on('private message', function(data) {
            $('#private-chat-messages').append('<p><strong>' + data.sender + ':</strong> ' + data.message + '</p>');
        });
    </script>
</body>
</html>
