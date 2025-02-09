<?php
require 'connect_bdd.php';

// Récupérer les données envoyées
$data = json_decode(file_get_contents('php://input'), true);
$div_name = $data['div_name'];

if (!empty($div_name)) {
    // Insertion du nom de la div dans la base de données
    $stmt = $conn->prepare("INSERT INTO user_divs (div_name) VALUES (?)");
    $stmt->bind_param("s", $div_name);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Nom de la div manquant']);
}

$conn->close();
?>
