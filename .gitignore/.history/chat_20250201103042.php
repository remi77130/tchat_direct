<?php
// Inclure le fichier de connexion à la base de données
require_once 'connect_bdd.php';

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']; // Ou l'ID de l'utilisateur si disponible
    $stmt = $conn->prepare("UPDATE users SET last_activity = NOW() WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
}

// Récupérer les utilisateurs de la base de données
$query = "SELECT username, avatar, age, department, ville_users FROM users";
$result = $conn->query($query);

$users = [];
if ($result->num_rows > 0) {
    // Stocker les résultats dans un tableau
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
</body>
</html>
