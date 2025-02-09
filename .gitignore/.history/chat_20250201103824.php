<?php
session_start();

// Inclure le fichier de connexion à la base de données
require_once 'connect_bdd.php';

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']; // Ou l'ID de l'utilisateur si disponible
    $stmt = $conn->prepare("UPDATE users SET last_activity = NOW() WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
}

// Récupérer les utilisateurs  uniquement les utilisateurs actifs (ex : dernière activité dans les 5 dernières minutes).
$query = "SELECT username, avatar, age, department, ville_users 
          FROM users 
          WHERE last_activity >= NOW() - INTERVAL 5 MINUTE";


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
        <p class="text_presentation_live">
            Bienvenue ! Ici, c'est un salon live server. Il n'y a que des membres actifs.<br>
            Vous pouvez discuter en toute tranquillité, nous ne sauvegardons aucune information.
        </p>

        <div class="container_users-table">
            <table id="users-table">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Pseudo</th>
                        <th>Âge</th>
                        <th>Dpt</th>
                        <th>Ville</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contenu rempli par JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</section>

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
