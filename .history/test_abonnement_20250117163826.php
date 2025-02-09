<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans d'Abonnement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .plan {
            background-color: #1e1e1e;
            border: 2px solid #444;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .plan.popular {
            border-color: #ff9800;
            position: relative;
        }

        .plan.popular::before {
            content: "Meilleur choix";
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #ff9800;
            color: #000;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
        }

        .plan h3 {
            font-size: 1.8em;
            margin-bottom: 10px;
            color: #ff9800;
        }

        .plan p {
            margin: 10px 0;
            line-height: 1.5;
        }

        .price {
            font-size: 2em;
            font-weight: bold;
            margin: 20px 0;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff9800;
            color: #000;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #ffa733;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="plan">
            <h3>Compte Basique</h3>
            <div class="price">5€/mois</div>
            <p>100 jetons inclus</p>
            <p>Créer jusqu'à 1 salon/mois</p>
            <p>Ajouter une description de profil</p>
            <p>Passer des appels vidéo</p>
            <a href="#" class="button">Choisir ce plan</a>
        </div>

        <div class="plan popular">
            <h3>Compte Premium</h3>
            <div class="price">12€/mois</div>
            <p>300 jetons inclus</p>
            <p>Créer 2 salons/mois monétisables</p>
            <p>Ajouter une description de profil</p>
            <p>Passer des appels vidéo</p>
            <a href="#" class="button">Choisir ce plan</a>
        </div>

        <div class="plan">
            <h3>Compte Ultime</h3>
            <div class="price">19€/mois</div>
            <p>500 jetons inclus</p>
            <p>Créer 5 salons/mois monétisables</p>
            <p>Ajouter une description de profil</p>
            <p>Passer des appels vidéo</p>
            <a href="#" class="button">Choisir ce plan</a>
        </div>
    </div>

</body>
</html>
