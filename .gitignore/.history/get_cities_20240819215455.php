<?php
require 'connect_bdd.php';

if (isset($_GET['department'])) {  // Le paramètre reste le même
    $department_id = $_GET['department'];

    $stmt = $conn->prepare("SELECT DISTINCT label, zip_code FROM french_cities WHERE department_number = ?");
    $stmt->bind_param("s", $department_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $cities = [];
    while ($row = $result->fetch_assoc()) {
        $cities[] = ['label' => $row['label'], 'zip_code' => $row['zip_code']];
    }

    echo json_encode($cities);
    $stmt->close();
}

$conn->close();
?>
