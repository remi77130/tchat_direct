<?php
session_start();

// Inclure le fichier de connexion à la base de données
require_once 'connect_bdd.php';

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']; // Ou l'ID de l'utilisateur si disponible
    $stmt = $conn->prepare("UPDATE users SET last_activity = NOW() WHERE username = ?");
    $stmt->bind_param("s", $username);
}
// Vérifier que la connexion à la base de données est bien établie
if (!$conn) {
    die("Erreur de connexion à la base de données");
}
// Récupérer uniquement les utilisateurs actifs (dernière activité dans les 5 dernières minutes)
$query = "SELECT *
          FROM users 
          WHERE last_activity >= NOW() - INTERVAL 5 MINUTE";

$result = $conn->query($query);

$users = [];

if ($result && $result->num_rows > 0) { // Vérification que $result n'est pas null
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Encoder les utilisateurs en JSON pour le script JavaScript
$users_json = json_encode($users);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="style/salon.css">
</head>
<body>

<section>
    <div class="container_profile_parent">
        <h2>Utilisateurs en ligne</h2>
        <div id="user-list"></div>
    </div>
</section>

<script>
function refreshUsers() {
    fetch('get_active_users.php')
        .then(response => response.json())
        .then(users => {
            let userContainer = document.getElementById("user-list");
            userContainer.innerHTML = ""; // Réinitialisation de la liste
            users.forEach(user => {
                userContainer.innerHTML += `
                    <div class="user">
                        <img src="${user.avatar}">
                        <p>${user.username} - ${user.age} ans (${user.ville_users})</p>
                    </div>
                `;
            });
        })
        .catch(error => console.error('Erreur lors du chargement des utilisateurs:', error));
}

// Rafraîchissement toutes les 10 secondes
setInterval(refreshUsers, 10000);

// Chargement initial
refreshUsers();
</script>

<script>
function refreshUsers() {
    fetch('get_active_users.php')
        .then(response => response.json())
        .then(users => {
            let userContainer = document.querySelector(".container_profile_parent");
            userContainer.innerHTML = "<h2>Utilisateurs en ligne</h2>"; // Réinitialisation
            users.forEach(user => {
                userContainer.innerHTML += `
                    <div class="user">
                        <img src="${user.avatar}" alt="Avatar de ${user.username}">
                        <p>${user.username} - ${user.age} ans (${user.ville_users})</p>
                    </div>
                `;
            });
        })
        .catch(error => console.error('Erreur lors du chargement des utilisateurs:', error));
}

// Rafraîchissement toutes les 10 secondes
setInterval(refreshUsers, 10000);

// Chargement initial
refreshUsers();
</script>


</body>
</html>
