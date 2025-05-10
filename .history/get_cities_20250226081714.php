<?php
require 'connect_bdd.php';

header('Content-Type: application/json; charset=utf-8');

// Connexion à ta base de données
$pdo = new PDO('mysql:host=localhost;dbname=ta_base;charset=utf8', 'user', 'mot_de_passe');

// Récupération sécurisée du code postal
$zip_code = isset($_POST['zip_code']) ? htmlspecialchars($_POST['zip_code']) : '';

// Requête préparée pour éviter les injections SQL
$stmt = $pdo->prepare('SELECT city_name FROM cities_fr WHERE zip_code = :zip_code');
$stmt->execute(['zip_code' => $zip_code]);

// Renvoi du résultat en JSON
echo json_encode($stmt->fetchAll(PDO::FETCH_COLUMN));
?>
