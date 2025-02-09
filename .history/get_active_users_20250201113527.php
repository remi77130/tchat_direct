<?php
require_once 'connect_bdd.php';

// Vérifier que la connexion est bien établie
if (!$conn) {
    die(json_encode(["error" => "Erreur de connexion à la base de données"]));
}

// Requête pour récupérer uniquement les utilisateurs actifs
$query = "SELECT *
          FROM users 
          WHERE last_activity >= NOW() - INTERVAL 1 MINUTE";

$result = $conn->query($query);

$users = [];

if ($result && $result->num_rows > 0) { // Vérification que $result n'est pas null
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($users);
?>
