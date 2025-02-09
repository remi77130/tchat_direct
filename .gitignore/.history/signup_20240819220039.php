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





            <label for="department">Département:</label>
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

    <script>document.getElementById('department').addEventListener('input', function() {
    var department = this.value;

    if (department.length >= 2) { // Vérifie que le code du département est suffisamment long
        $.ajax({
            url: 'get_cities.php',
            method: 'GET',
            data: { department_code: department },
            success: function(response) {
                var cities = JSON.parse(response);
                var citySelect = $('#city');
                citySelect.empty(); // Vider la liste des villes
                citySelect.append('<option value="">Sélectionnez une ville</option>');

                if (cities.length > 0) {
                    $('#cities-container').show(); // Afficher la liste déroulante
                    cities.forEach(function(city) {
                        citySelect.append('<option value="' + city + '">' + city + '</option>');
                    });
                } else {
                    $('#cities-container').hide(); // Masquer la liste déroulante s'il n'y a pas de villes
                }
            }
        });
    }
});


</script>
</body>
</html>
