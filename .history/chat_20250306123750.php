<?php
session_start();

// Inclure le fichier de connexion à la base de données
require_once 'connect_bdd.php';

// Vérifier que la connexion à la base de données est bien établie
if (!$conn) {
    die("Erreur de connexion à la base de données");
}

// Vérifier si l'utilisateur est connecté et mettre à jour son activité
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $stmt = $conn->prepare("UPDATE users SET last_activity = NOW() WHERE username = ?");
    if (is_array($username)) {
        error_log("Erreur : \$username est un tableau au lieu d'une chaîne. Contenu : " . print_r($username, true));
        $username = implode(", ", $username); // Convertir en chaîne si nécessaire
    }
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
    } else {
        error_log("Erreur de préparation de la requête SQL : " . $conn->error);
    }
}

// Récupérer uniquement les utilisateurs actifs
$query  = "SELECT * FROM users WHERE last_activity >= NOW() - INTERVAL 5 MINUTE";
$result = $conn->query($query);

// Vérification des erreurs SQL
if (!$result) {
    die("Erreur SQL : " . $conn->error);
}

// Stocker les résultats
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$result->free();
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
    <h2>Utilisateurs en ligne</h2>
    
    <div id="user-list">
        <?php foreach ($users as $user): ?>
            <div class="user">
                <div class="container_avatar_user">
                    <img class="avatar_user" src="<?= htmlspecialchars($user['avatar']) ?>" 
                    alt="Avatar de <?= htmlspecialchars($user['username']) ?>">
                </div>

                <p><?= htmlspecialchars($user['username']) ?> 
                <?= htmlspecialchars($user['zip_code']) ?>  - 
                <?= htmlspecialchars($user['age']) ?> ans (
                <?= htmlspecialchars($user['ville_users']) ?>)</p>
            </div>
        <?php endforeach; ?>

    </div>
</section>
<script>function refreshUsers() {
    fetch('active_users.php') // Assure-toi que ce fichier renvoie le JSON des utilisateurs actifs
        .then(response => response.json())
        .then(users => {
            let userContainer = document.getElementById("user-list");
            userContainer.innerHTML = ""; // Effacer les anciens utilisateurs

            users.forEach(user => {
                let userDiv = document.createElement("div");
                userDiv.classList.add("user");
                userDiv.innerHTML = `
                    <div class="avatar_user">
                        <img src="${user.avatar}" alt="Avatar de ${user.username}">
                    </div>
                    <div class="info_user">
                        <p>${user.username} - ${user.age} ans (${user.ville_users})</p>
                    </div>
                `;
                userContainer.appendChild(userDiv);
            });
        })
        .catch(error => console.error('Erreur lors du chargement des utilisateurs:', error));
}

// Mettre à jour la liste des utilisateurs toutes les 1000 ms (1 seconde)
// Ajuste l'intervalle selon tes besoins
setInterval(refreshUsers, 1000);

// Chargement initial
refreshUsers();

</script>
</body>
</html>
