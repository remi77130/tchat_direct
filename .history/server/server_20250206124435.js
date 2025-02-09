const express = require("express");
const http = require("http");
const { Server } = require("socket.io");
const cors = require("cors");

// Initialisation de l'application Express et des modules nécessaires
const app = express();
const server = http.createServer(app);
const io = new Server(server, {
    cors: { origin: "*" } // Autorise toutes les origines (AJAX/Socket.io)
});

// Middleware CORS
app.use(cors());

// Route principale pour tester le serveur
app.get("/", (req, res) => {
    res.send("Serveur Node.js avec Socket.io est opérationnel !");
});

// Gestion des connexions Socket.io
io.on("connection", (socket) => {
    console.log("Un utilisateur s'est connecté");

    socket.on("message", (data) => {
        console.log("Message reçu :", data);
        io.emit("message", data); // Diffuse le message à tous les utilisateurs connectés
    });

    socket.on("disconnect", () => {
        console.log("Un utilisateur s'est déconnecté");
    });
});

// Démarrage du serveur sur le port 3000
server.listen(3000, () => {
    console.log("Serveur en écoute sur http://localhost:3000");
});
