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


            <label for="department">Département :</label>
            <input type="text" id="department_id" name="department" required>

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

    <script>document.addEventListener('DOMContentLoaded', function() {
    const departmentInput = document.getElementById('department_id');  // Mise à jour de l'ID ici
    const cityContainer = document.getElementById('city-container');
    const zipCodeSelect = document.getElementById('zip_code');

    departmentInput.addEventListener('input', function() {
        const departmentId = departmentInput.value.trim();

        if (departmentId !== '') {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_cities.php?department=' + departmentId, true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const cities = JSON.parse(xhr.responseText);

                    zipCodeSelect.innerHTML = '<option value="">Sélectionnez une ville</option>';
                    cities.forEach(function(city) {
                        const option = document.createElement('option');
                        option.value = city.zip_code;
                        option.textContent = `${city.label} (${city.zip_code})`;
                        zipCodeSelect.appendChild(option);
                    });

                    cityContainer.style.display = cities.length > 0 ? 'block' : 'none';
                }
            };

            xhr.onerror = function() {
                console.error("Erreur lors de la récupération des villes.");
            };

            xhr.send();
        } else {
            cityContainer.style.display = 'none';
        }
    });
});

</script>
</body>
</html>
