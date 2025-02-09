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
