<?php
require 'connect_bdd.php';

if (isset($_GET['department'])) {
    $department = $_GET['department'];

    // Requête pour récupérer les villes du département donné
    $stmt = $conn->prepare("SELECT id, zip_code FROM french_cities WHERE department_code = ?");
    $stmt->bind_param("s", $department);
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
