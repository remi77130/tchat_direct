<?php
// Connexion à la base de données
$servername = "localhost";
$username = "admin"; // Nom d'utilisateur par défaut de XAMPP
$password = "JGsb18as5jgwqZj5"; // Mot de passe par défaut de XAMPP (généralement vide)
$dbname = "messagerie";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}?>