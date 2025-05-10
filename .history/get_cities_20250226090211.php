<?php
header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Connexion à ta base de données (vérifie bien les identifiants)
    $pdo = new PDO('mysql:host=localhost;dbname=tchat_direct;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Connexion échouée : ' . $e->getMessage()]);
    exit;
}

$zip_code = isset($_POST['zip_code']) ? htmlspecialchars($_POST['zip_code']) : '';

try {
    $stmt = $pdo->prepare('SELECT name_city FROM cities WHERE zip_code = :zip_code');
    $stmt->execute(['zip_code' => $zip_code]);

    $cities = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($cities);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur SQL : ' . $e->getMessage()]);
    exit;
}
?>
