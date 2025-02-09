<?php
require 'connect_bdd.php';
// Récupérer le département via une requête AJAX
if (isset($_GET['department'])) {
    $department = htmlspecialchars($_GET['department']); // Nettoyage de l'entrée utilisateur

    $stmt = $conn->prepare("SELECT name FROM cities WHERE LEFT(zip_code, 2) = ?");
    $stmt->bind_param("s", $department); // Sécurise l'entrée
    $stmt->execute();

    $result = $stmt->get_result();
    $cities = [];
    while ($row = $result->fetch_assoc()) {
        $cities[] = ['name' => $row['name']];
    }

    echo json_encode($cities); // Envoie les résultats au client sous forme JSON
}
?>
