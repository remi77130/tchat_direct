<?php
require 'connect_bdd.php';

$sql = "SELECT zip, city FROM cities_usa";
$result = $conn->query($sql);

$cities = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($cities);

$conn->close();
?>
