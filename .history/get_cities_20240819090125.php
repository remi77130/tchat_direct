<?php
require 'connect_bdd.php';

if (isset($_GET['department'])) { // Le paramètre 'department' correspond à l'ID du département
    $departmentId = $_GET['department'];

    // Requête pour récupérer les villes associées au département sélectionné
    $stmt = $conn->prepare("SELECT zip_code FROM french_cities WHERE id = ? ORDER BY label ASC");
    $stmt->bind_param("i", $departmentId);
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
