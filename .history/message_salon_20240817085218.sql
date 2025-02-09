CREATE TABLE salon_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    salon_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (salon_id) REFERENCES salon(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
/* Cette table stockera l'ID du salon, l'ID de l'utilisateur qui a envoyé le message, le contenu du message et la date/heure d'envoi.