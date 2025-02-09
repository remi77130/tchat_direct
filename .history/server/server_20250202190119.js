const express = require("express");
const http = require("http");
const { Server } = require("socket.io");
const cors = require("cors");

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
    cors: { origin: "*" } // Autorise les connexions depuis d'autres domaines
});

app.use(cors());

app.get("/", (req, res) => {
    res.send("Serveur Node.js + Socket.io en ligne !");
});

// Gérer les connexions des utilisateurs au chat
io.on("connection", (socket) => {
    console.log("Un utilisateur s'est connecté");

    socket.on("message", (data) => {
        console.log("Message reçu :", data);
        io.emit("message", data); // Diffusion du message
    });

    socket.on("disconnect", () => {
        console.log("Un utilisateur s'est déconnecté");
    });
});

server.listen(3000, () => {
    console.log("Serveur en écoute sur le port 3000");
});
