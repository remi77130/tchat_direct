io.on('connection', (socket) => {
    console.log('Un utilisateur s\'est connecté');

    // Recevoir le nom d'utilisateur lors de la connexion
    socket.on('register user', (username) => {
        socket.username = username;
    });

    // Envoi de message privé
    socket.on('private message', (data) => {
        const { recipient, message } = data;
        io.to(recipient).emit('chat message', `${socket.username}: ${message}`);
    });

    // Gestion des messages publics
    socket.on('chat message', (msg) => {
        io.emit('chat message', msg);
    });

    // Lorsque l'utilisateur se déconnecte
    socket.on('disconnect', () => {
        console.log('Un utilisateur s\'est déconnecté');
    });
});




////            gestion des salons   ///            ////            gestion des salons   ///



io.on('connection', (socket) => {
    console.log('Un utilisateur est connecté.');

    // Gestion de l'entrée dans un salon
    socket.on('join salon', (salonId) => {
        socket.join(salonId);
        console.log(`Utilisateur a rejoint le salon ${salonId}`);
    });

    // Gestion des messages dans un salon
    socket.on('salon message', (data) => {
        const { salon_id, user_id, message } = data;

        // Diffuser le message à tous les membres du salon
        io.to(salon_id).emit('salon message', data);

        // Enregistrer le message dans la base de données
        const sql = "INSERT INTO salon_messages (salon_id, user_id, message) VALUES (?, ?, ?)";
        const params = [salon_id, user_id, message];
        db.run(sql, params, (err) => {
            if (err) {
                console.error('Erreur lors de l\'enregistrement du message :', err.message);
            }
        });
    });

    socket.on('disconnect', () => {
        console.log('Un utilisateur s\'est déconnecté.');
    });
});


socket.emit('privateMessage', { to: recipientId, message: msg });
socket.on('privateMessage', ({ to, message }) => {
    io.to(to).emit('chatMessage', message);
});




// Connexion au serveur Socket.io               // Connexion au serveur Socket.io

const socket = io();

// Gestion de l'envoi de messages
document.getElementById('send-button').addEventListener('click', () => {
    const message = document.getElementById('chat-input').value;
    if (message.trim() !== '') {
        socket.emit('chatMessage', message);
        document.getElementById('chat-input').value = '';
    }
});

// Affichage des messages reçus
socket.on('chatMessage', (msg) => {
    const messageContainer = document.createElement('div');
    messageContainer.textContent = msg;
    document.getElementById('chat-messages').appendChild(messageContainer);
});

// Ouvrir la fenêtre de messagerie lorsqu'on clique sur un utilisateur
document.querySelectorAll('#users-table tr').forEach(row => {
    row.addEventListener('click', () => {
        document.getElementById('chat-window').style.display = 'block';
    });
});
