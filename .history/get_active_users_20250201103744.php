<?php
require_once 'connect_bdd.php';
// Ce fichier retourne la liste des utilisateurs actifs en JSON pour le JavaScript.



$query = "SELECT username, avatar, age, department, ville_users 
          FROM users 
          WHERE last_activity >= NOW() - INTERVAL 5 MINUTE";

$result = $conn->query($query);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($users);
?>
