<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Téléphone Validé</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: linear-gradient(135deg, #1e1e2f, #28293e);
      color: #f1f1f1;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      text-align: center;
      padding: 20px;
      background: #2c2c4e;
      border-radius: 10px;
      width: 90%;
      max-width: 400px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.9);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }
    h1 {
      font-size: 24px;
      color: #4caf50;
      margin-bottom: 10px;
    }
    p {
      font-size: 16px;
      margin-bottom: 20px;
      line-height: 1.5;
    }
    p span {
      color: #ffd700;
      font-weight: bold;
    }
    .illustration {
      margin-bottom: 20px;
    }
    .illustration img {
      width: 150px;
      height: auto;
    }
    .button-container {
      text-align: center;
    }
    .button {
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      color: #fff;
      background: linear-gradient(90deg, #4caf50, #3b8ef3);
      border: none;
      border-radius: 30px;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }
    .button:hover {
      background: linear-gradient(90deg, #3b8ef3, #4caf50);
      transform: scale(1.05);
    }
    .close {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 18px;
      color: #f44336;
      cursor: pointer;
      transition: transform 0.3s ease;
    }
    .close:hover {
      transform: scale(1.2);
    }
  </style>
</head>
<body>
  <div class="container">
    <span class="close" onclick="alert('Fenêtre fermée')">&times;</span>
    <h1>Super !</h1>
    <p>Votre numéro est maintenant <span>validé</span> !</p>
    <p>Vous avez désormais la <span>pastille validée</span> sur votre profil.</p>
    <div class="illustration">
      <img src="img_articles/amex.png" alt="Illustration de validation">
    </div>
    <div class="button-container">
      <button class="button" onclick="alert('Retour au profil')">Retour au Profil</button>
    </div>
  </div>
</body>
</html>
