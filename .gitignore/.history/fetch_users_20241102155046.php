<?php
// Inclure le fichier de connexion à la base de données
require 'connect_bdd.php';

// Requête pour récupérer les 50 derniers utilisateurs inscrits, incluant l'avatar
$sql = "SELECT id, username, avatar, age, department, ville_users, gender FROM users ORDER BY created_at DESC LIMIT 50";
$result = $conn->query($sql);


$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = [
            'username' => $row['username'],
            'avatar' => $row['avatar'],
            'age' => $row['age'],
            'department' => $row['department'],
            'ville_users' => $row['ville_users']
        ];
    }
}



// Retourner les résultats au format JSON
header('Content-Type: application/json');
echo json_encode($users);

$conn->close();


?>


