<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Abonnements</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #1c1c1e;
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
      background-color: #2c2c2e;
      border-radius: 10px;
      width: 300px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card h2 {
      margin-bottom: 10px;
      font-size: 24px;
      color: #ffc107;
    }
    .card p {
      margin: 10px 0;
      font-size: 16px;
    }
    .price {
      font-size: 32px;
      color: #0dcaf0;
      margin-bottom: 20px;
    }
    .btn {
      display: inline-block;
      padding: 10px 20px;
      font-size: 16px;
      color: #fff;
      background-color: #0dcaf0;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .btn:hover {
      background-color: #007bff;
    }
    .badge {
      background-color: #ffc107;
      color: #000;
      font-size: 14px;
      padding: 5px 10px;
      border-radius: 15px;
      position: absolute;
      top: 20px;
      right: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="badge">Recommandé</div>
      <h2>Compte Basique</h2>
      <p class="price">5€/mois</p>
      <p>Créer jusqu'à 1 salon/mois</p>
      <p>Ajouter une description de profil</p>
      <p>Passer des appels vidéo</p>
      <a href="#" class="btn">Choisir ce plan</a>
    </div>

    <div class="card">
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
