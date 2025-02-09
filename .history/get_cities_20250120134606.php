<?php
require 'connect_bdd.php';

if (isset($_GET['department_id'])) {
    $departmentId = $_GET['department_id'];

    // Requête pour récupérer les villes associées au département (id_dpt)
    $stmt = $conn->prepare("SELECT ville FROM villes_france WHERE id_dpt = ? ORDER BY ville ASC");
    if ($stmt === false) {
        error_log("Erreur de préparation de la requête : " . $conn->error);
        exit;
    }

    $stmt->bind_param("s", $departmentId); // Utilisation de "s" car id_dpt est un VARCHAR
    $stmt->execute();
    $result = $stmt->get_result();

    $cities = [];
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($cities);

    $stmt->close();
} else {
    error_log("Paramètre department_id manquant.");
}

$conn->close();
?>
