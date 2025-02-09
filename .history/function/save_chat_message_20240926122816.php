
<?php
require 'connect_bdd.php';

// Ce fichier sera responsable de l'enregistrement du message de discussion dans la base de données. 
// Voici comment vous pouvez structurer le fichier PHP :

// Récupère les données envoyées via la requête POST
$data = json_decode(file_get_contents('php://input'), true);
$div_name = $data['div_name'];
$message = $data['message'];

// Insère le message dans la base de données
$sql = "INSERT INTO chat_messages (div_name, message) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $div_name, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
