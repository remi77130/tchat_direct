<?php


// Ce fichier récupérera les salons créés pour les afficher sur la page.

// Inclure le fichier de connexion à la base de données
require 'connect_bdd.php';

// Requête pour récupérer les salons actifs
$sql = "SELECT name, creator_username FROM salon WHERE active_until > NOW() ORDER BY created_at DESC";
$result = $conn->query($sql);

$salons = [];
?>
