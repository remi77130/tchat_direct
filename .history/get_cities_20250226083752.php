<?php
require 'connect_bdd.php';

header('Content-Type: application/json; charset=utf-8');


// Récupération sécurisée du code postal
$zip_code = isset($_POST['zip_code']) ? htmlspecialchars($_POST['zip_code']) : '';

// Requête préparée pour éviter les injections SQL
$stmt = $pdo->prepare('SELECT name_city FROM cities  WHERE zip_code = :zip_code');
$stmt->execute(['zip_code' => $zip_code]);

// Renvoi du résultat en JSON
echo json_encode($stmt->fetchAll(PDO::FETCH_COLUMN));
?>
