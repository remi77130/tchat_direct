CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    salon_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT,
    image_url VARCHAR(255),
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (salon_id) REFERENCES salons(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
