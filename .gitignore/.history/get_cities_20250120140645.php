<?php
require 'connect_bdd.php';
// Récupérer le département via une requête AJAX
if (isset($_GET['department'])) {
    $department = htmlspecialchars($_GET['department']);
    $stmt = $pdo->prepare("SELECT name FROM cities WHERE LEFT(zip_code, 2) = :department");
    $stmt->execute(['department' => $department]);

    // Récupérer les résultats
    $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cities);
}
?>
