<?php
require 'connect_bdd.php';

if (isset($_GET['department_code'])) {
    $department_code = $_GET['department_code'];

    $stmt = $conn->prepare("SELECT name FROM cities WHERE department_code = ?");
    $stmt->bind_param("s", $department_code);
    $stmt->execute();
    $result = $stmt->get_result();

    $cities = [];
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row['name'];
    }

    echo json_encode($cities);

    $stmt->close();
}

$conn->close();
?>
