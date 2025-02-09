<?php
require 'connect_bdd.php';

// Récupérer les données envoyées
$data = json_decode(file_get_contents('php://input'), true);
$div_name = $data['div_name'];
$user_id = $data['user_id'];

if (!empty($div_name) && !empty($user_id)) {
    // Insertion de la div dans la base de données
    $stmt = $conn->prepare("INSERT INTO user_divs (user_id, div_name) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $div_name);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Nom de la div ou ID utilisateur manquant']);
}

$conn->close();
?>
