<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style/signup.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   
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





             <!-- Champ de saisie pour le département (type tel) -->
            <label for="department">Numéro de Département :</label>
            <input type="tel" id="department" name="department"  required>

            <!-- Sélection de la ville -->
            <div id="city-container" style="display:none;">
            <label for="city">Ville :</label>
            <select id="zip_code" name="zip_code" required>
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

    <script>
    $(document).ready(function() {
        // Quand l'utilisateur saisit un numéro de département
        $('#department').on('input', function() {
            var departmentId = $(this).val().trim();

            if (departmentId.length > 0) {
                // Requête AJAX pour obtenir les villes associées au département
                $.ajax({
                    url: 'get_cities.php',
                    method: 'GET',
                    data: { department: departmentId }, // Envoi du numéro de département
                    success: function(data) {
                        var citySelect = $('#zip_code');
                        citySelect.empty(); // On vide la liste actuelle
                        citySelect.append('<option value="">Sélectionnez une ville</option>');
                        
                        if (data.length > 0) {
                            data.forEach(function(city) {
                                citySelect.append('<option value="' + city.zip_code + '">' + city.zip_code + '</option>');
                            });
                            $('#city-container').show(); // Affiche la liste des villes
                        } else {
                            $('#city-container').hide(); // Cache la liste si aucune ville n'est trouvée
                        }
                    }
                });
            } else {
                $('#city-container').hide();
            }
        });
    });
</script>
</body>
</html>
