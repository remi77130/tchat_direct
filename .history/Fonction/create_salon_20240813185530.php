<?php
// Ce fichier traitera la demande de création de salon et insérera les données dans la base de données.

// Inclure le fichier de connexion à la base de données
require 'connect_bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salon_name'])) {
    $salonName = $_POST['salon_name'];
    $creatorUsername = 'current_user'; // Remplacer par la session ou autre méthode pour obtenir l'utilisateur actuel

    // Calculer la date d'expiration du salon (1 mois à partir de la création)
    $activeUntil = date('Y-m-d H:i:s', strtotime('+1 month'));

    try {
        // Préparer la requête SQL
        $stmt = $conn->prepare("INSERT INTO salon (name, creator_username, active_until) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $salonName, $creatorUsername, $activeUntil);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception($stmt->error);
        }
    } catch (Exception $e) {
        // Gérer les erreurs et retourner une réponse JSON appropriée
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    $stmt->close();
}

$conn->close();
?>
