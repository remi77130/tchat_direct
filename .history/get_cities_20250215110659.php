<?php
require 'connect_bdd.php';

// getCities.php

header('Content-Type: application/json');

// Paramètre du code postal
$zip = isset($_GET['zip']) ? trim($_GET['zip']) : '';

if ($zip === '') {
    echo json_encode([]);
    exit;
}



// Sécurisation de l'entrée
$zip = $conn->real_escape_string($zip);

// Requête pour récupérer les villes dont le code postal correspond ou contient le code saisi
$sql = "SELECT name_city FROM cities WHERE zip_code LIKE '%$zip%'";
$result = $conn->query($sql);

$cities = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }
}

$conn->close();
echo json_encode($cities);
?>
