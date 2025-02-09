const express = require('express');
const http = require('http');
const socketIo = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Servir les fichiers statiques
app.use(express.static(''));

// Socket.io Connection
io.on('connection', (socket) => {
    console.log('Un utilisateur s\'est connecté.(server.js)');

    // Gérer les événements ici

    socket.on('disconnect', () => {
        console.log('Un utilisateur s\'est déconnecté.(server.js)');
    });
});

// Démarrer le serveur
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => console.log(`Serveur démarré sur le port ${PORT}`));
