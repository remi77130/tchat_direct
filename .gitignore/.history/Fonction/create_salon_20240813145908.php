
<?php

// Ce fichier traitera la demande de création de salon et insérera les données dans la base de données.

// Inclure le fichier de connexion à la base de données
require 'connect_bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salon_name'])) {
    $salonName = $conn->real_escape_string($_POST['salon_name']);
    $creatorUsername = 'current_user'; // Remplacer par la session ou autre méthode pour obtenir l'utilisateur actuel

    // Calculer la date d'expiration du salon (1 mois à partir de la création)
    $activeUntil = date('Y-m-d H:i:s', strtotime('+1 month'));

    // Insérer le nouveau salon dans la base de données
    $sql = "INSERT INTO salons (name, creator_username, active_until) VALUES ('$salonName', '$creatorUsername', '$activeUntil')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}

$conn->close();
?>
