<?php
require 'connect_bdd.php';

if (isset($_GET['department_id'])) { // On récupère le numéro de département envoyé
    $departmentId = $_GET['department_id'];

    // Requête pour récupérer les villes associées au département (id_dpt)
    $stmt = $conn->prepare("SELECT ville FROM french_cities WHERE id_dpt = ? ORDER BY ville ASC");
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
