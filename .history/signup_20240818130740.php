<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form action="signup_process.php" method="post" enctype="multipart/form-data">
        <!-- Autres champs du formulaire -->

        <label for="department">Département :</label>
        <input type="text" id="department" name="department" required>

        <div id="city-container" style="display:none;">
            <label for="city">Ville :</label>
            <select id="city" name="city">
                <option value="">Sélectionnez une ville</option>
            </select>
        </div>

        <!-- Autres champs du formulaire -->
        <button type="submit">S'inscrire</button>
    </form>

    <script>
    $(document).ready(function() {
        $('#department').on('input', function() {
            var department = $(this).val().trim();

            if (department.length > 0) {
                $.ajax({
                    url: 'get_cities.php',
                    method: 'GET',
                    data: { department: department },
                    success: function(data) {
                        var citySelect = $('#city');
                        citySelect.empty();
                        citySelect.append('<option value="">Sélectionnez une ville</option>');
                        
                        if (data.length > 0) {
                            data.forEach(function(city) {
                                citySelect.append('<option value="' + city.name + '">' + city.name + '</option>');
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
