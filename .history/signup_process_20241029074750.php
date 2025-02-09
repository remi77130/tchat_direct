<?php
require 'connect_bdd.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = trim($_POST['username']);
    $age = (int)$_POST['age'];
    $department = trim($_POST['department']);
    $ville_users = $_POST['ville_users']; // La ville sélectionnée par l'utilisateur
    $gender = $_POST['gender'];
    //$pays = trim($_POST['pays']);


    // Validation des données
    if (strlen($pseudo) < 3 || strlen($pseudo) > 120) {
        die("Ton pseudo doit contenir entre 3 et 12 caractères.");
    }

    $age = filter_var($age, FILTER_VALIDATE_INT);
    if  ($age === false || $age < 15 || $age > 89) {
        die("Âge invalide.");
    }

    if (strlen($department) > 100) {
        die("Le département ne peut pas dépasser 100 caractères.");
    }

    if (!in_array($gender, ['male', 'female', 'other'])) {
        die("Genre invalide.");
    }


   // Générer un pseudo unique
   $original_pseudo = $pseudo;
   $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
   if ($stmt === false) {
       error_log("Erreur de préparation de la requête : " . $conn->error);
       echo "Une erreur interne est survenue. Veuillez réessayer plus tard.";
       exit;
   }

   $pseudo_taken = true;
   $i = 1;  // Variable pour incrémenter le pseudo en cas de doublon

   // Boucle tant que le pseudo est déjà pris
   while ($pseudo_taken) {
       $stmt->bind_param("s", $pseudo);
       $stmt->execute();
       $stmt->store_result();

       if ($stmt->num_rows > 0) {
           // Si le pseudo est déjà pris, on ajoute un nombre à la fin
           $pseudo = $original_pseudo . $i;
           $i++;
       } else {
           $pseudo_taken = false;
       }
   }
   $stmt->close();

   

    // Insertion des informations dans la base de données, y compris la ville sélectionnée
    $sql = "INSERT INTO users (username, age, department, ville_users, gender) VALUES ( ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log("Erreur de préparation de la requête : " . $conn->error);
        die("Une erreur interne est survenue. Veuillez réessayer plus tard.");
    }
	
    $stmt->bind_param("ssisss", $pseudo, $age, $department, $ville_users, $gender);

    if ($stmt->execute()) {

        // Redirection après succès
		$id = $conn->insert_id;
		$myuser = [
			'id'=>$id,
			'username'=>$pseudo,
			'age'=>$age,
			'dep'=>$department,
			'ville'=>$ville_users,
			'gender'=>$gender,
		];
		$_SESSION['user'] = $myuser;

        header("Location: chat.php");
        exit();
    } 
    
    else 
    {
        error_log("Erreur lors de l'exécution de la requête : " . $stmt->error);
        die("Une erreur est survenue lors de l'inscription.");
    }

    $stmt->close();
} else {
    echo "Méthode de requête non autorisée.";
}

$conn->close();
?>
