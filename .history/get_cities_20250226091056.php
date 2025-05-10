<?php
header('Content-Type: application/json; charset=utf-8');

// Activation de l'affichage des erreurs (débogage)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inclusion de ton fichier de connexion existant
include 'connect_bdd.php';

$zip_code = isset($_POST['zip_code']) ? htmlspecialchars($_POST['zip_code']) : '';

$stmt = $conn->prepare('SELECT name_city FROM cities WHERE zip_code = ?');
$stmt->bind_param('s', $zip_code);

if (!$stmt->execute()) {
    echo json_encode(['error' => 'Erreur SQL : ' . $stmt->error]);
    exit;
}

$result = $stmt->get_result();
$cities = [];
while ($row = $result->fetch_assoc()) {
    $cities[] = $row['name_city'];
}

echo json_encode($cities);
?>
