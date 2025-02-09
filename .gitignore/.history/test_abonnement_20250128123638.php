<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Abonnements</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: linear-gradient(135deg, #1e1e2f, #28293e);
      color: #f1f1f1;
      margin: 0;
      padding: 0;
    }
    .toggle-container {
      display: flex;
      justify-content: center;
      margin: 30px;
    }
    .toggle-button {
      background: #3b8ef3;
      color: #fff;
      border: none;
      border-radius: 20px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
      margin: 0 10px;
    }
    .toggle-button.active {
      background: #ff5722;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 20px;
      padding: 50px;
      flex-wrap: wrap;
    }
    .card {
        background: linear-gradient(145deg, #2c2c3e, #3c3c4e);
    border-radius: 15px;
    width: 320px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    position: relative;
    overflow: hidden;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    }
    .card:hover {
      transform: translateY(-10px) scale(1.05);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.4);
    }
    .card h2 {
      margin: 10px 0;
      font-size: 24px;
      color: #ffd700;
    }
    .card p {
      margin: 10px 0;
      font-size: 16px;
    }
    .price {
      font-size: 36px;
      color: #4caf50;
      margin-bottom: 10px;
    }
    .price span {
      font-size: 16px;
      color: #aaa;
      display: block;
      margin-top: 5px;
    }
    .btn {
      display: inline-block;
      padding: 12px 20px;
      font-size: 16px;
      font-weight: bold;
      color: #fff;
      background: linear-gradient(90deg, #4caf50, #3b8ef3);
      border: none;
      border-radius: 50px;
      text-decoration: none;
      transition: background 0.4s ease, transform 0.3s ease;
    }
    .btn:hover {
      background: linear-gradient(90deg, #3b8ef3, #4caf50);
      transform: scale(1.1);
    }

    .text_abonnement
    {
        text-align: left;
    }
    .badge {
        background: linear-gradient(90deg, #ff5722, #ff9800);
    color: #fff;
    font-size: 14px;
    padding: 8px 12px;
    border-radius: 20px;
    position: absolute;
    top: 5px;
    right: 15px;
    }
  </style>
  <script>
    function togglePlan(option) {
      const cards = document.querySelectorAll('.card');
      const buttons = document.querySelectorAll('.toggle-button');
      buttons.forEach(btn => btn.classList.remove('active'));
      document.getElementById(option).classList.add('active');

      if (option === 'monthly') {
        cards[0].querySelector('.price').innerHTML = "4,99€/mois<span>Facturé mensuellement</span>";
        cards[1].querySelector('.price').innerHTML = "12€/mois<span>Facturé mensuellement</span>";
        cards[2].querySelector('.price').innerHTML = "19€/mois<span>Facturé mensuellement</span>";
      } else {
        cards[0].querySelector('.price').innerHTML = "50€/an<span>Soit 4,17€/mois</span>";
        cards[1].querySelector('.price').innerHTML = "120€/an<span>Soit 10€/mois</span>";
        cards[2].querySelector('.price').innerHTML = "190€/an<span>Soit 15,83€/mois</span>";
      }
    }
  </script>
</head>
<body>
  <div class="toggle-container">
    <button id="monthly" class="toggle-button active" onclick="togglePlan('monthly')">Mensuel</button>
    <button id="yearly" class="toggle-button" onclick="togglePlan('yearly')">Annuel</button>
  </div>
  <div class="container">
    <div class="card">
      <h2>Compte Basique</h2>
      <p class="price">4,99€/mois<span>Facturé mensuellement</span></p>
      <ul class="text_abonnement">

<li>Créer 1 salon à entrée libre </p>
<li>Ajouter une description de profil</p>


</ul>
      <a href="#" class="btn">Choisir ce plan</a>
    </div>

    <div class="card">
      <div class="badge">Recommandé</div>
      <h2>Compte Premium</h2>
      <p class="price">12€/mois<span>Facturé mensuellement</span></p>

      <ul class="text_abonnement">

      <li>Créer jusqu'à 2 salon payant</p>
      <li>Ajouter une description de profil</p>
      <li>Passer des appels vidéo</p>

</ul>
      <a href="page_reglement.php" class="btn">Je prend !</a>

 
      
    </div>

    <div class="card">
      <h2>Compte Ultime</h2>
      <p class="price">19€/mois<span>Facturé mensuellement</span></p>
      <ul class="text_abonnement">

<li>Créer jusqu'à 5 salon payant</p>
<li>Ajouter une description de profil</p>
<li>Passer des appels vidéo</p>

</ul>
      <a href="#" class="btn">Go !</a>
    </div>
  </div>
</body>
</html>
