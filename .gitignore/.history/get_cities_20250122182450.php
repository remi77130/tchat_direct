<?php // Utiliser une requête SQL pour récupérer les villes correspondant au code postal saisi.

require_once 'connect_bdd.php'; // Connexion à la base de données

if (isset($_GET['zip_code'])) {
    $zip_code = htmlspecialchars($_GET['zip_code']); // Assainir l'entrée utilisateur

    // Requête SQL pour récupérer les villes correspondant au code postal
    $stmt = $conn->prepare("
    SELECT name_city
    FROM cities
    WHERE zip_code = ?
");
    $stmt->bind_param("s", $zip_code);
    $stmt->execute();
    $result = $stmt->get_result();

    $cities = [];
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row['name_city'];
    }

    // Renvoyer les données au format JSON
    echo json_encode($cities);
}
?>
