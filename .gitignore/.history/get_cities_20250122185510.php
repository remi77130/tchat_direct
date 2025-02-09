<?php
// Inclure le fichier de connexion à la base de données
require_once 'connect_bdd.php';

// Vérifier si le paramètre 'zip_code' est présent dans l'URL
if (isset($_GET['zip_code'])) {
    // Assainir l'entrée utilisateur pour éviter les attaques XSS
    $zip_code = htmlspecialchars($_GET['zip_code']);

    // Préparer une requête SQL pour rechercher les villes associées au code postal
    $stmt = $conn->prepare("SELECT name_city FROM cities WHERE zip_code = ?");

    // Lier le paramètre 'zip_code' à la requête SQL pour éviter les injections SQL
    $stmt->bind_param("s", $zip_code);

    // Exécuter la requête SQL
    $stmt->execute();

    // Obtenir le résultat de la requête
    $result = $stmt->get_result();

    // Initialiser un tableau pour stocker les noms de villes trouvés
    $cities = [];
    while ($row = $result->fetch_assoc()) {
        // Ajouter chaque ville trouvée au tableau
        $cities[] = $row['name_city'];
    }

    // Vérifier si aucune ville n'a été trouvée et envoyer un message approprié
    if (empty($cities)) {
        echo json_encode(["message" => "Aucune ville trouvée pour le code postal $zip_code"]);
    } else {
        // Si des villes sont trouvées, les retourner au format JSON
        echo json_encode($cities);
    }

    // Terminer l'exécution du script pour éviter tout traitement supplémentaire
    exit;
}
?>
