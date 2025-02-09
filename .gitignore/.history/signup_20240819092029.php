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





             <!-- Sélection du département -->
            <label for="department">Département :</label>
            <select id="department" name="department" required>
            <option value="">Sélectionnez un département</option>
            <!-- Les départements seront remplis ici via PHP -->
            <?php
            require 'connect_bdd.php';
            $result = $conn->query("SELECT id, department_name FROM french_cities GROUP BY department_name 
                                    ORDER BY department_name ASC"); // POURQUOI DEPARTMENT NAME ?

            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['department_name']}</option>";
            }
            ?>
        </select>

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
        $('#department').on('change', function() {
            var departmentId = $(this).val();

            if (departmentId) {
                $.ajax({
                    url: 'get_cities.php',
                    method: 'GET',
                    data: { department: departmentId },
                    success: function(data) {
                        var citySelect = $('#zip_code');
                        citySelect.empty();
                        citySelect.append('<option value="">Sélectionnez une ville</option>');
                        
                        if (data.length > 0) {
                            data.forEach(function(city) {
                                citySelect.append('<option value="' + city.zip_code + '">' + city.label + '</option>');
                            });
                            $('#city-container').show();
                        } else {
                            $('#city-container').hide();
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
