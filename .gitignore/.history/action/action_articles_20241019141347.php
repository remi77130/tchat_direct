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
}?>
