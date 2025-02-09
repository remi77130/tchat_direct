<?php

// Connexion à la base de données
// Inclure le fichier de connexion à la base de données
require 'connect_bdd.php';


// Vérifier si un commentaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_comment'])) {
    
    $author = htmlspecialchars($conn->real_escape_string($_POST['author']));
    $comment = htmlspecialchars($conn->real_escape_string($_POST['comment']));

    $sql = "INSERT INTO comments (author, comment) VALUES ('$author', '$comment')";

    if ($conn->query($sql) === TRUE) {
                // Rediriger après l'insertion pour éviter la duplication lors de l'actualisation

        header("Location: articles.php");
        exit();

    } 
    
    else 
    {
        echo "<p>Erreur : " . $conn->error . "</p>";
    }
}





// Récupérer les commentaires
$sql = "SELECT author, comment, created_at FROM comments ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Afficher chaque commentaire
    while($row = $result->fetch_assoc()) {
        echo "<div class='comment'>";
        echo "<p><strong>" . htmlspecialchars($row['author']) . "</strong> - " . $row['created_at'] . "</p>";
        echo "<p>" . htmlspecialchars($row['comment']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>Aucun commentaire pour l'instant. Soyez le premier à commenter !</p>";
}

// Fermer la connexion
$conn->close();

