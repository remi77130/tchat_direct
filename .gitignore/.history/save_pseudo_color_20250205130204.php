<?php

// Sauvegarder la couleur choisie en base de données
session_start();
include 'connect_bdd.php'; // Connexion à la base de données

if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté.");
}

$user_id = $_SESSION['user_id'];
$pseudo_color = $_POST['pseudo_color'];

// Vérifier que la couleur est bien un format valide (hexadécimal)
if (!preg_match('/^#[a-f0-9]{6}$/i', $pseudo_color)) {
    die("Format de couleur invalide.");
}

// Mettre à jour la base de données
$sql = "UPDATE users SET pseudo_color=? WHERE id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$pseudo_color, $user_id]);

header("Location: parametres.php?success=1");
?>
