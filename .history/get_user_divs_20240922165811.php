<?php
require 'connect_bdd.php';

// Sélectionner toutes les divs enregistrées, 
// Même si nous ne sauvegardons pas l'ID utilisateur, 
// nous devons toujours récupérer toutes les divs de la base de données lorsque la page se recharge.


$result = $conn->query("SELECT div_name FROM user_divs");

$divs = [];
while ($row = $result->fetch_assoc()) {
    $divs[] = $row;
}

echo json_encode(['success' => true, 'divs' => $divs]);

$conn->close();
?>

