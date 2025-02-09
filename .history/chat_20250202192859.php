
<?php
session_start();

// Inclure le fichier de connexion à la base de données
require_once 'connect_bdd.php';

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
    } else {
        error_log("Erreur de préparation de la requête SQL : " . $conn->error);
    }
}

// Vérifier que la connexion à la base de données est bien établie
if (!$conn) {
    die("Erreur de connexion à la base de données");
}

// Récupérer uniquement les utilisateurs actifs
$query = "SELECT * 
          FROM users 
          WHERE last_activity >= NOW() - INTERVAL 5 MINUTE";

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


    <h1>Chat en temps réel</h1>
    
    <input type="text" id="message" placeholder="Tapez un message">
    <button onclick="envoyerMessage()">Envoyer</button>
    
    <div id="messages"></div>

    <script>
        // Connexion au serveur Node.js + Socket.io
        const socket = io("http://localhost:3000");

        // Réception des messages en temps réel
        socket.on("message", (data) => {
            let div = document.createElement("div");
            div.textContent = data;
            document.getElementById("messages").appendChild(div);
        });

        // Envoi des messages
        function envoyerMessage() {
            let message = document.getElementById("message").value;
            socket.emit("message", message);
            document.getElementById("message").value = ""; // Vide le champ après envoi
        }
    </script>
    <div id="user-list">
        <?php foreach ($users as $user): ?>
            <div class="user">
                <div class="container_avatar_user"><img class="avatar_user" src="<?= htmlspecialchars($user['avatar']) ?>"></div>
                <p><?= htmlspecialchars($user['username']) ?> - <?= htmlspecialchars($user['age']) ?> ans (<?= htmlspecialchars($user['ville_users']) ?>)</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<script>
function refreshUsers() {
    fetch('get_active_users.php')
        .then(response => response.json())
        .then(users => {
            let userContainer = document.getElementById("user-list");
            userContainer.innerHTML = ""; // Effacer les anciens utilisateurs

            users.forEach(user => {
                let userDiv = document.createElement("div");
                userDiv.classList.add("user");
                userDiv.innerHTML = `
                    <div class="avatar_user"><img src="${user.avatar}"> </div>
                    <div class="info_user"><p>${user.username} - ${user.age} ans (${user.ville_users})</p></div>
                `;
                userContainer.appendChild(userDiv);
            });
        })
        .catch(error => console.error('Erreur lors du chargement des utilisateurs:', error));
}

// Mettre à jour la liste des utilisateurs toutes les 100 secondes
setInterval(refreshUsers, 100000);

// Chargement initial
refreshUsers();
</script>
</body>
</html>
