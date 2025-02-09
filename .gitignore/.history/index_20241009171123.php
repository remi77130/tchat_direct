    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chat en ligne sans inscription gratuit</title>
        <link rel="stylesheet" href="style/index.css">

        <meta name="description" content="Tchat en ligne avec d'autres membres. 
        
        <div  class="counter" id="counter"></div>Rejoignez le chat anonyme."/> 
        <meta name="keywords" content="tchat direct" />
        <link rel="icon" type="image/png" href="img/favicon_2.png" />

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
    </head>
    <body style="background-image: url('img/tchat-anonyme.png');

    background-color: #10102a;
    font-family: 'Arial', sans-serif;
    display: block;
    background-position-x: center;
    background-repeat: no-repeat;


    align-items: center;
    height: 100vh;
    color: aliceblue;

    margin: auto;
    width: 100vw;">  
  <div class="title_index">
    <h1 class="title">
    Un pseudo un tchat- numéro 1 du chat anonyme en france.</h1>
  </div>

  <div  class="counter" id="counter"></div>

    <div  class="login-container">
    <div class="login-box">

        
        
    <form action="signup_process.php" method="post">

    <div class="input-box">
                
    <input placeholder="Pseudo" type="text" id="username" name="username" pattern="[a-zA-Z0-9_]+" required maxlength="12">
    </div>

    <div class="input-box">
    <input type="file" id="avatar" name="avatar" accept="image/*" >
                    </div>



                    <div>
                <input placeholder="Age" type="number" id="age" name="age" required>

                    </div>



    <!-- Champ de saisie pour le département (type tel) -->
    <div class="input-box">
            <input placeholder="département" type="number" id="department_id" name="department" required pattern="[0-9]{2,5}" maxlength="5">
    </div>
            <!-- Sélection de la ville -->
            <div class="input-box">

        <div id="city-container" style="display:none;">
            <select id="ville_dpt" name="ville_users" required>
                <option value="">Sélectionnez une ville</option>
            </select>
        </div>
    </div>



    <div class="input-box">
    <input type="radio" id="homme" name="gender" value="male">
    <label for="homme">Homme</label>

                    </div>


                    
                    <div class="input-box">
                    <input type="radio" id="femme" name="gender" value="female">
                    <label for="femme">Femme</label>

                    </div>









                    <button type="submit" class="btn-submit">Submit</button>
                </form>

        </div>


        <div class="text_index">
            <h3>tchat direct</h3> <br>
            
            <p>Créer des salons sur <span>tchat direct</span>, vous pouvez discuter en live avec les autres utilisateurs connectés. <br>
            La connexion se fait via votre navigateur, que vous soyez sur PC ou mobile. 
            c'est le <span>meilleur site de rencontre</span>.
            <br>
            L'accès est gratuit et sans inscription, mais un minimum d'informations est requis pour vous connecter au chat : un pseudonyme, votre âge et votre région. 
            Une fois sur le <span>chat en direct</span>, vous pouvez interagir avec les autres utilisateurs, 
            soit en privé, soit dans les différents salons publics. Plusieurs options et 
            fonctionnalités sont disponibles dans la fenêtre de <span>dialogue en direct</span>, et une aide
            en ligne pour chacune de ces options est accessible directement dans la fenêtre de tchat direct.


</p>
        </div>



        <footer>
        <a href="condition.html" target="_blank" >CGU</a>
        <a href="contact.html" target="_blank" >Contact</a>

    </footer>
</div>






        <script>
        // Fonction pour générer un nombre aléatoire entre 120 et 145
        function generateRandomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        // Fonction pour mettre à jour le compteur toutes les 3 secondes
        function updateCounter() {
            const counterElement = document.getElementById('counter');
            const randomValue = generateRandomNumber(120, 145);
            counterElement.textContent = randomValue;
        }

        // Démarre le compteur avec une mise à jour toutes les 3 secondes (3000 ms)
        setInterval(updateCounter, 3000);

        // Initialisation immédiate du compteur
        updateCounter();
    </script>




        <script>
        $(document).ready(function() {
            $('#department_id').on('input', function() {
                var departmentId = $(this).val().trim();

                if (departmentId.length > 0) {
                    $.ajax({
                        url: 'get_cities.php',
                        method: 'GET',
                        data: { department_id: departmentId },
                        success: function(data) {
                            var citySelect = $('#ville_dpt');
                            citySelect.empty();
                            citySelect.append('<option value="">Sélectionnez une ville</option>');

                            if (data.length > 0) {
                                data.forEach(function(city) {
                                    citySelect.append('<option value="' + city.ville + '">' + city.ville + '</option>');
                                });
                                $('#city-container').show();
                                citySelect.attr('required', true);
                            } else {
                                $('#city-container').hide();
                                citySelect.removeAttr('required');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Erreur AJAX : ", status, error);
                        }
                    });
                } else {
                    $('#city-container').hide();
                    $('#ville_dpt').removeAttr('required');
                }
            });
        });

    </script>
    </body>
    </html>
