<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validation Réussie</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: #1e1e2f;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
      color: #f1f1f1;
    }

    .container {
      text-align: center;
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.8);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    h1 {
      font-size: 36px;
      color: #4caf50;
      margin-bottom: 10px;
      animation: popIn 0.5s ease-in-out;
    }

    @keyframes popIn {
      from {
        transform: scale(0.5);
        opacity: 0;
      }
      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .subtext {
      font-size: 18px;
      margin-bottom: 30px;
      line-height: 1.5;
      animation: fadeIn 1.5s ease-in-out;
    }

    .subtext span {
      color: #ffd700;
      font-weight: bold;
    }

    .button-container {
      margin-top: 20px;
    }

    .button {
      padding: 12px 30px;
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
      transform: scale(1.1);
    }

    .confetti {
      position: absolute;
      width: 10px;
      height: 10px;
      background: #ffd700;
      animation: confettiFall 2.5s linear infinite;
    }

    @keyframes confettiFall {
      from {
        transform: translateY(-100vh) rotate(0deg);
        opacity: 1;
      }
      to {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Bravo Sandra </h1>
    <p class="subtext">Votre numéro est maintenant <span>validé</span> ! <br> Vous avez obtenu la <span>pastille validée</span> sur votre profil.</p>
    <div class="button-container">
      <button class="button" onclick="alert('Retour au profil')">Retour au Profil</button>
    </div>
  </div>

  <!-- Confetti -->
  <script>
    for (let i = 0; i < 100; i++) {
      const confetti = document.createElement('div');
      confetti.className = 'confetti';
      document.body.appendChild(confetti);
      confetti.style.left = `${Math.random() * 100}vw`;
      confetti.style.animationDuration = `${Math.random() * 2 + 1}s`;
      confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
    }
  </script>
</body>
</html>
