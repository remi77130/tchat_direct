    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chat en ligne sans inscription gratuit</title>
        <link rel="stylesheet" href="style/index.css">

        <meta name="description" content="Tchat en ligne avec d'autres membres. Rejoignez le chat anonyme."/> 
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
    Un pseudo un tchat</h1>
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

<div class="text_index">

<h3>tchat direct</h3>

<p>
Le site pour parler avec des gens en ligne gratuitement ! 
Envie de rencontrer de nouvelles personnes et de discuter sans inscription ? 
<span>Tchat Direct</span> est un tchat libre.
Que ce soit pour un échange amical ou pour un <span>chat coquin gratuit </span>, 
notre plateforme vous permet de commencer facilement et rapidement. 
Aucun compte à créer, aucune donnée collectée. 
Il vous suffit de choisir un pseudo, de renseigner votre âge et votre ville 
pour rejoindre notre communauté.
<span>Tchat-Direct</span>, c'est le site parfait pour discuter en ligne de façon anonyme et gratuite. 
Rejoignez-nous dès maintenant sur <span>Tchat-Direct</span>, le <span>tchat gratuit</span> qui vous permet de 
parler librement.
</p>

</div>


<div class="text_index">

<p>
Bienvenue sur <span>Tchat-Direct</span>, la plateforme ultime pour faire des rencontres sans aucune contrainte ! 
Si vous cherchez un <SPan>site de rencontre sans inscription</SPan>, vous êtes au bon endroit. 
Avec <SPAn>Tchat-Direct</SPAn>, vous pouvez directement accéder à des discussions 
passionnantes et rencontrer des gens qui partagent vos centres d'intérêts. 
Pas besoin de passer par des formulaires longs et 
fastidieux—ici, tout est simplifié pour que vous puissiez profiter
d'un chat rencontre gratuit sans perdre de temps.

Notre site chat gratuit offre une expérience de chat instantanée et facile. 
Vous pouvez démarrer une discussion en quelques clics seulement, accéder à un tchatche en ligne 
sans fournir d'informations personnelles. 
Que vous soyez à la recherche d'une rencontre amicale ou à un  chat coquin, le chat gratuit sans inscription
est idéal pour ceux qui veulent faire des rencontres sans barrières. 
Sur <span>por hub com</span>Vous gardez ainsi un anonymat total tout en profitant d'une grande 
liberté pour discuter avec des inconnus.

Sur Tchat-Direct, l'accent est mis sur la convivialité et la facilité d'accès. Notre site de rencontre sans inscription vous permet de commencer à parler dès que vous arrivez, sans délais ni procédures compliquées. Vous pouvez choisir la salle de discussion qui vous intéresse et commencer une conversation en quelques secondes. Notre chat rencontre gratuit est conçu pour vous offrir un espace sûr et agréable pour rencontrer des personnes du monde entier.

Rejoignez Tchat-Direct aujourd'hui et découvrez par vous-même à quel point il est simple de se faire de nouveaux amis sur un site chat gratuit. Nos fonctionnalités de chat gratuit sans inscription rendent chaque rencontre fluide, amusante et sans stress. Qu'attendez-vous pour vous lancer ? Commencez à chatter maintenant et laissez la magie des rencontres instantanées opérer !


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
