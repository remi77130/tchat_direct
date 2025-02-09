<?php
// get_user_info.php va récupérer les informations de l'utilisateur à partir de la base de données :
require 'connect_bdd.php'; // Connexion à la base de données

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);

    // Préparer la requête pour récupérer les informations de l'utilisateur
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_info = $result->fetch_assoc();
        echo json_encode($user_info);
    } else {
        echo json_encode(['error' => 'Utilisateur non trouvé']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID utilisateur non fourni']);
}

$conn->close();
?>
