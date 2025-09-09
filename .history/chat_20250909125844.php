<?php
session_start();
require_once 'connect_bdd.php';

// Si la requête est en AJAX (paramètre ajax=1), on renvoie la liste des utilisateurs actifs en JSON
if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    // Vérifier que la connexion est bien établie
    if (!$conn) {
        die(json_encode(["error" => "Erreur de connexion à la base de données"]));
    }
    
    // Récupérer les utilisateurs dont l'activité remonte aux 5 dernières minutes
    $query = "SELECT * FROM users WHERE last_activity >= NOW() - INTERVAL 1 MINUTE";
    $result = $conn->query($query);

    if (!$result) {
        die(json_encode(["error" => "Erreur SQL : " . $conn->error]));
    }
    
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $result->free();
    
    header('Content-Type: application/json');
    echo json_encode($users);
    exit();
}

// Pour une requête classique, on affiche la page du chat

// Vérifier la connexion à la base
if (!$conn) {
    die("Erreur de connexion à la base de données");
}

// Si l'utilisateur est connecté, mettre à jour son activité
if (isset($_SESSION['user'])) {
    // Supposons que $_SESSION['user'] est un tableau associatif et que le pseudo est stocké sous "username"
    $username = $_SESSION['user']['username'];
    $stmt = $conn->prepare("UPDATE users SET last_activity = NOW() WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
    } else {
        error_log("Erreur de préparation de la requête SQL : " . $conn->error);
    }
}

// Récupérer initialement les utilisateurs actifs pour affichage
$query  = "SELECT * FROM users WHERE last_activity >= NOW() - INTERVAL 5 MINUTE";
$result = $conn->query($query);
$users = [];
if ($result && $result->num_rows > 0) {
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
  <title>Chat en ligne</title>
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
          <?= htmlspecialchars($user['zip_code']) ?> - 
          <?= htmlspecialchars($user['age']) ?> ans (<?= htmlspecialchars($user['ville_users']) ?>)
        </p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<script>
function refreshUsers() {
    // Appel AJAX pour récupérer les utilisateurs actifs
    fetch('chat.php?ajax=1')
        .then(response => response.json())
        .then(users => {
            let userContainer = document.getElementById("user-list");
            userContainer.innerHTML = ""; // Effacer l'ancienne liste

            users.forEach(user => {
                let userDiv = document.createElement("div");
                userDiv.classList.add("user");
                userDiv.innerHTML = `
                    <div class="avatar_user">
                        <img src="${user.avatar}" alt="Avatar de ${user.username}">
                    </div>
                    <div class="info_user">
                        <p>${user.username} - ${user.zip_code} - ${user.age} ans (${user.ville_users})</p>
                    </div>
                `;
                userContainer.appendChild(userDiv);
            });
        })
        .catch(error => console.error('Erreur lors du chargement des utilisateurs:', error));
}

// Actualiser la liste toutes les secondes (1000 ms)
setInterval(refreshUsers, 1000);
// Chargement initial
refreshUsers();
</script>
</body>
</html>
