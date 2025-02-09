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
      padding: 20px;
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
    .card:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.1), transparent);
      z-index: 1;
    }
    .card h2 {
      margin: 10px 0;
      font-size: 24px;
      color: #ffd700;
      z-index: 2;
      position: relative;
    }
    .card p {
      margin: 10px 0;
      font-size: 16px;
      z-index: 2;
      position: relative;
    }
    .price {
      font-size: 36px;
      color: #4caf50;
      margin-bottom: 20px;
      z-index: 2;
      position: relative;
    }
    .btn {
      display: inline-block;
      padding: 12px 20px;
      font-size: 16px;
      font-weight: bold;
      color: #fff;
      background: linear-gradient(90deg, #4caf50,rgb(0, 115, 255));
      border: none;
      border-radius: 50px;
      text-decoration: none;
      z-index: 2;
      position: relative;
      transition: background 0.4s ease, transform 0.3s ease;
    }
    .btn:hover {
      background: linear-gradient(90deg, #3b8ef3, #4caf50);
      transform: scale(1.1);
    }
    .badge {
      background: linear-gradient(90deg, #ff5722, #ff9800);
      color: #fff;
      font-size: 14px;
      padding: 8px 12px;
      border-radius: 20px;
      position: absolute;
      top: 15px;
      right: 15px;
      z-index: 3;
    }
    .card:nth-child(2) .badge {
      background: linear-gradient(90deg, #9c27b0, #673ab7);
    }
    .card:nth-child(3) .badge {
      background: linear-gradient(90deg, #009688, #4caf50);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h2>Compte Basique</h2>
      <p class="price">5€/mois</p>
      <p>Créer jusqu'à 1 salon/mois</p>
      <p>Ajouter une description de profil</p>
      <p>Passer des appels vidéo</p>
      <a href="#" class="btn">Choisir ce plan</a>
    </div>

    <div class="card">
      <div class="badge">Recommandé</div>
      <h2>Compte Premium</h2>
      <p class="price">12€/mois</p>
      <p>Créer jusqu'à 2 salons monétisables</p>
      <p>Ajouter une description de profil</p>
      <p>Passer des appels vidéo</p>
      <a href="#" class="btn">Choisir ce plan</a>
    </div>

    <div class="card">
      <h2>Compte Ultime</h2>
      <p class="price">19€/mois</p>
      <p>Créer jusqu'à 5 salons monétisables</p>
      <p>Ajouter une description de profil</p>
      <p>Passer des appels vidéo</p>
      <a href="#" class="btn">Choisir ce plan</a>
    </div>
  </div>
</body>
</html>
