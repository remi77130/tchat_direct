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


            <div id="cities-container" style="display:none;">
            <label for="city">Ville:</label>
            <select id="city" name="city">
            <option value="">Sélectionnez une ville</option>
            </select>
            </div>

            <label for="gender">Sexe :</label>
            <select id="gender" name="gender" required>
                <option value="male">Homme</option>
                <option value="female">Femme</option>
                <option value="other">Autre</option>
            </select>

            <button type="submit">S'inscrire</button>
        </form>
    </div>

    <script>// Assure que le DOM est complètement chargé avant d'exécuter le code
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionne l'élément du formulaire correspondant au département
    const departmentInput = document.getElementById('department');
    
    // Ajoute un événement "input" pour détecter les changements dans le champ département
    departmentInput.addEventListener('input', function() {
        // Récupère la valeur entrée par l'utilisateur dans le champ département
        const departmentCode = departmentInput.value.trim();

        // Vérifie si un code de département est fourni
        if (departmentCode !== '') {
            // Crée une requête AJAX pour obtenir les villes associées au département
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_cities.php?department=' + departmentCode, true);

            // Définit ce qu'il faut faire lorsque la requête est terminée
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Parse la réponse JSON reçue du serveur
                    const cities = JSON.parse(xhr.responseText);

                    // Sélectionne l'élément où les villes seront affichées
                    const citiesDropdown = document.getElementById('cities-dropdown');
                    citiesDropdown.innerHTML = ''; // Vide le contenu actuel

                    // Remplit la liste déroulante avec les villes reçues
                    cities.forEach(function(city) {
                        const option = document.createElement('option');
                        option.value = city; // Valeur de l'option
                        option.textContent = city; // Texte visible dans la liste
                        citiesDropdown.appendChild(option); // Ajoute l'option à la liste
                    });

                    // Rendre visible la liste déroulante si des villes sont disponibles
                    if (cities.length > 0) {
                        citiesDropdown.style.display = 'block';
                    } else {
                        citiesDropdown.style.display = 'none';
                    }
                }
            };

            // En cas d'erreur lors de la requête AJAX
            xhr.onerror = function() {
                console.error("Erreur lors de la récupération des villes.");
            };

            // Envoie la requête au serveur
            xhr.send();
        } else {
            // Cache la liste déroulante si aucun code de département n'est fourni
            document.getElementById('cities-dropdown').style.display = 'none';
        }
    });
});
</script>
</body>
</html>
