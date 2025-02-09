<?php
require 'connect_bdd.php';

if (isset($_GET['city_code'])) { // Utilisation de 'department' au lieu de 'department_number'
    $department = $_GET['city_code'];

    // Requête pour récupérer les villes du département sélectionné
    $stmt = $conn->prepare("SELECT zip_code, label FROM french_cities WHERE department_number = ? ORDER BY label ASC");
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
