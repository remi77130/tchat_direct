<?php
require 'connect_bdd.php';
    
if (isset($_GET['department'])) { // On récupère le numéro de département envoyé
    $departmentId = $_GET['department'];

    // Requête pour récupérer les villes (zip_code) associées à l'ID du département
    $stmt = $conn->prepare("SELECT zip_code FROM french_cities WHERE id = ? ORDER BY zip_code ASC");
    $stmt->bind_param("i", $departmentId); // 'i' pour un entier
    $stmt->execute();
    $result = $stmt->get_result();

    $cities = [];
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }

    // Retourne la liste des villes au format JSON
    header('Content-Type: application/json');
    echo json_encode($cities);

    $stmt->close();
}

$conn->close();
?>
