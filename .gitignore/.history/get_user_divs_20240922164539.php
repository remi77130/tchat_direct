<?php
require 'connect_bdd.php';

// Sélectionner toutes les divs enregistrées
$result = $conn->query("SELECT div_name FROM user_divs");

$divs = [];
while ($row = $result->fetch_assoc()) {
    $divs[] = $row;
}

echo json_encode(['success' => true, 'divs' => $divs]);

$conn->close();
?>
