<?php
require 'connect_bdd.php';

// Affichage des erreurs PHP (important pour déboguer)
ini_set('display_errors', 1);
error_reporting(E_ALL);


header('Content-Type: application/json; charset=utf-8');


// Récupération sécurisée du code postal envoyé par AJAX
$zip_code = isset($_POST['zip_code']) ? htmlspecialchars($_POST['zip_code']) : '';

// Préparation et exécution de la requête SQL
$stmt = $pdo->prepare('SELECT name_city FROM cities WHERE zip_code = :zip_code');
$stmt->execute(['zip_code' => $zip_code]);

// Récupération et renvoi du résultat en JSON
echo json_encode($stmt->fetchAll(PDO::FETCH_COLUMN));
?>
