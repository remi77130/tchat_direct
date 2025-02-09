const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const mysql = require('mysql'); // Utiliser MySQL pour interagir avec la base de données

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Connexion à la base de données MySQL
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'messagerie'
});

db.connect(err => {
    if (err) throw err;
    console.log('Connecté à la base de données MySQL');
});

io.on('connection', (socket) => {
    console.log('Nouvel utilisateur connecté');

    // Événement pour enregistrer un utilisateur
    socket.on('registerUser', (username) => {
        socket.username = username;
        console.log(`${username} s'est connecté.`);
    });

    // Événement pour gérer la déconnexion ou fermeture de la page
    socket.on('disconnect', () => {
        if (socket.username) {
            console.log(`${socket.username} s'est déconnecté.`);
            
            // Supprimer l'utilisateur de la base de données
            const query = "DELETE FROM users WHERE username = ?";
            db.query(query, [socket.username], (err, result) => {
                if (err) throw err;
                console.log(`Utilisateur ${socket.username} supprimé de la base de données`);
                
                // Informer les autres clients de supprimer l'utilisateur de l'interface
                io.emit('removeUserRow', socket.username);
            });
        }
    });

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => console.log(`Serveur démarré sur le port ${PORT}`));
