<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider Jetons</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            text-align: center;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            overflow: hidden; /* Cache les options hors de la vue */
            position: relative;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease; /* Animation fluide du glissement */
        }

        .slide {
            min-width: 100%; /* Chaque option occupe 100% de la largeur du conteneur */
            box-sizing: border-box;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .slide h2 {
            color: #333;
        }

        .slide p {
            margin: 10px 0;
            font-size: 16px;
            color: #666;
        }

        .slide button {
            padding: 10px 20px;
            margin-top: 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .slide button:hover {
            background: #218838;
        }

        /* Boutons de navigation */
        .nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 24px;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .nav:hover {
            background: rgba(0, 0, 0, 0.7);
        }

        .nav-left {
            left: 10px;
        }

        .nav-right {
            right: 10px;
        }
    </style>
</head>
<body>
    <h1>BANQUE</h1>
    <p>Ici, tu peux acheter des jetons pour jouer à des mini-jeux et débloquer des fonctionnalités spéciales.</p>

    <!-- Conteneur principal du slider -->
    <div class="container">
        <!-- Slider -->
        <div class="slider" id="slider">
            <!-- Option 1 -->
            <div class="slide">
                <h2>25 jetons = 0.99€/mois</h2>
                <p>Avec ces jetons, tu peux débloquer des salons exclusifs ou rejouer à des jeux.</p>
                <button>Je prends</button>
            </div>
            <!-- Option 2 -->
            <div class="slide">
                <h2>50 jetons = 1.99€/mois</h2>
                <p>Double tes jetons pour encore plus de fun et d'options premium !</p>
                <button>Je prends</button>
            </div>
            <!-- Option 3 -->
            <div class="slide">
                <h2>100 jetons = 3.99€/mois</h2>
                <p>Le meilleur rapport qualité-prix pour profiter à fond des fonctionnalités.</p>
                <button>Je prends</button>
            </div>
        </div>

        <!-- Boutons de navigation -->
        <button class="nav nav-left" id="prevBtn">&#8249;</button>
        <button class="nav nav-right" id="nextBtn">&#8250;</button>
    </div>

    <script>
        // Sélectionner les éléments nécessaires
        const slider = document.getElementById("slider");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");

        // Variables pour le suivi du slide actuel
        let currentSlide = 0;
        const totalSlides = document.querySelectorAll(".slide").length;

        // Fonction pour mettre à jour la position du slider
        function updateSliderPosition() {
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        // Gestion du bouton "Suivant"
        nextBtn.addEventListener("click", () => {
            currentSlide = (currentSlide + 1) % totalSlides; // Retourne au début si c'est le dernier slide
            updateSliderPosition();
        });

        // Gestion du bouton "Précédent"
        prevBtn.addEventListener("click", () => {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides; // Retourne au dernier si c'est le premier slide
            updateSliderPosition();
        });
    </script>
</body>
</html>
