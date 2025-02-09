<?php
// Démarrer la session de façon sécurisée
session_start();
require 'connect_bdd.php';

// Rediriger si la session utilisateur n'est pas définie
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
// Récupérer les utilisateurs
$query = $conn->query('SELECT username, avatar, age, department, ville_users FROM users');
$users = $query->fetchAll(PDO::FETCH_ASSOC);

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
// Récupérer les utilisateurs depuis PHP
const users = <?php echo $users_json; ?>;

// Fonction pour remplir le tableau
function populateTable(users) {
    const tableBody = document.querySelector('#users-table tbody');
    tableBody.innerHTML = ''; // Vider le tableau
    users.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><img src="${user.avatar}" alt="Avatar" class="user-avatar" width="50"></td>
            <td>${user.username}</td>
            <td>${user.age}</td>
            <td>${user.department}</td>
            <td>${user.ville_users}</td>
        `;
        tableBody.appendChild(row);
    });
}

// Afficher les utilisateurs
populateTable(users);
</script>