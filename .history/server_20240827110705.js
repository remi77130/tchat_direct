const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Servir les fichiers statiques (HTML, CSS, JS)
app.use(express.static('salon'));

// Quand un utilisateur se connecte
io.on('connection', (socket) => {
    console.log('Un utilisateur s\'est connecté');

    // Ecouter les messages envoyés par l'utilisateur
    socket.on('chat message', (msg) => {
        io.emit('chat message', msg); // Répéter le message à tous les utilisateurs connectés
    });

    // Quand un utilisateur se déconnecte
    socket.on('disconnect', () => {
        console.log('Un utilisateur s\'est déconnecté');
    });
});

// Démarrer le serveur
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Serveur démarré sur le port ${PORT}`);
});
