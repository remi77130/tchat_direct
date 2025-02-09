<?php
// Inclut le fichier de connexion à la base de données
require 'connect_bdd.php';

// Vérifie si le code du département a été envoyé via la méthode GET
if (isset($_GET['department'])) {
    // Récupère le code du département depuis les paramètres de la requête
    $department_code = $_GET['department'];

    // Prépare une requête SQL pour sélectionner les noms des villes correspondant au code du département
    $stmt = $conn->prepare("SELECT name FROM cities WHERE department_code = ?");
    
    // Lie la valeur du code du département au paramètre de la requête SQL
    $stmt->bind_param("s", $department_code);
    
    // Exécute la requête SQL
    $stmt->execute();
    
    // Récupère les résultats de la requête
    $result = $stmt->get_result();

    // Initialise un tableau pour stocker les noms des villes
    $cities = [];
    
    // Parcourt chaque ligne de résultat et ajoute le nom de la ville au tableau $cities
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row['name'];
    }

    // Encode le tableau $cities en JSON et l'envoie en réponse
    echo json_encode($cities);

    // Ferme la requête préparée
    $stmt->close();
}

// Ferme la connexion à la base de données
$conn->close();
?>
