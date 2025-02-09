// server.js

const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const path = require('path');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Dossier public pour les fichiers statiques
app.use(express.static(path.join(__dirname, 'public')));

io.on('connection', (socket) => {
    console.log('Un utilisateur est connecté');

    // Écouter les messages envoyés par le client
    socket.on('chatMessage', (msg) => {
        io.emit('chatMessage', msg);  // Diffuser le message à tous les utilisateurs
    });

    // Gérer les messages privés
    socket.on('privateMessage', ({ to, message }) => {
        socket.to(to).emit('chatMessage', message);  // Envoyer le message privé
    });

    // Écouter la déconnexion
    socket.on('disconnect', () => {
        console.log('Un utilisateur est déconnecté');
    });
});

server.listen(3000, () => {
    console.log('Serveur démarré sur http://localhost:3000');
});
