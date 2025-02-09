<?php
require 'connect_bdd.php';

if (isset($_GET['department_id'])) {
    $departmentId = intval($_GET['department_id']);
    $stmt = $conn->prepare("SELECT id, name FROM cities WHERE department_id = ?");
    $stmt->bind_param('i', $departmentId);
    $stmt->execute();
    $result = $stmt->get_result();

    $cities = [];
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }

    echo json_encode($cities);
} else {
    echo json_encode([]);
}

$conn->close();
?>
