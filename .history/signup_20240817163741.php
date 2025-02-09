<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style/signup.css">
   
</head>
<body>
    <div class="container">

        <h2>Inscription</h2>
        <!-- Le formulaire est envoye au fichier signup_process.php qui traitera l'inscription.-->

        <form action="signup_process.php" method="POST" enctype="multipart/form-data">
            
            <label for="username">Pseudo :</label>
            <input type="text" id="username" name="username" required>


            <label for="avatar">Avatar :</label>
            <input type="file" id="avatar" name="avatar" accept="image/*" required>

            <label for="age">Âge :</label>
            <input type="number" id="age" name="age" required>

            <label for="department">Département :</label>
            <input type="text" id="department" name="department" required>

            <label for="gender">Sexe :</label>
            <select id="gender" name="gender" required>
                <option value="male">Homme</option>
                <option value="female">Femme</option>
                <option value="other">Autre</option>
            </select>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>
