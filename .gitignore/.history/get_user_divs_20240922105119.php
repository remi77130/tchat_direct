<?php
require 'connect_bdd.php';

$user_id = $_GET['user_id'];

if (!empty($user_id)) {
    // Sélectionner les divs de l'utilisateur
    $stmt = $conn->prepare("SELECT div_name FROM user_divs WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $divs = [];
    while ($row = $result->fetch_assoc()) {
        $divs[] = $row;
    }

    echo json_encode(['success' => true, 'divs' => $divs]);
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>
