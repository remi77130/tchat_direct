<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salon VIP Créé</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: #1e1e2f;
      margin: 0;
      padding: 0;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff;
    }

    .container {
      text-align: center;
      position: relative;
      animation: fadeIn 1s ease-in-out;
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
      font-size: 48px;
      color: #ffd700;
      margin-bottom: 10px;
      animation: glow 1s ease-in-out infinite alternate;
      position: relative;
    }

    @keyframes glow {
      from {
        text-shadow: 0 0 10px #ffd700, 0 0 20px #ffd700, 0 0 30px #ff8c00, 0 0 40px #ff8c00;
      }
      to {
        text-shadow: 0 0 20px #ff8c00, 0 0 30px #ffd700, 0 0 40px #ffd700, 0 0 50px #ffd700;
      }
    }

    p {
      font-size: 18px;
      line-height: 1.5;
      animation: fadeIn 1.5s ease-in-out;
    }

    .button-container {
      margin-top: 20px;
    }

    .button {
      padding: 12px 30px;
      font-size: 16px;
      font-weight: bold;
      color: #fff;
      background: linear-gradient(90deg, #ff5722, #ff9800);
      border: none;
      border-radius: 30px;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }

    .button:hover {
      background: linear-gradient(90deg, #ff9800, #ff5722);
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

    .sparkle {
      position: absolute;
      width: 5px;
      height: 5px;
      background: #fff;
      border-radius: 50%;
      box-shadow: 0 0 10px #ffd700, 0 0 20px #ffd700;
      animation: sparkle 2s linear infinite;
    }

    @keyframes sparkle {
      0%, 100% {
        opacity: 1;
        transform: scale(1);
      }
      50% {
        opacity: 0.5;
        transform: scale(1.5);
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Félicitations !</h1>
    <p>Votre salon VIP est maintenant <span style="color: #ffd700; font-weight: bold;">créé</span> ! <br> Une nouvelle aventure prestigieuse commence.</p>
    <p>Partagez-le pour attirer encore plus de membres exclusifs.</p>
    <div class="button-container">
      <button class="button" onclick="alert('Partager le salon')">Partager le Salon</button>
    </div>
  </div>

  <!-- Confetti -->
  <script>
    // Générer des confettis
    for (let i = 0; i < 150; i++) {
      const confetti = document.createElement('div');
      confetti.className = 'confetti';
      document.body.appendChild(confetti);
      confetti.style.left = `${Math.random() * 100}vw`;
      confetti.style.animationDuration = `${Math.random() * 2 + 1}s`;
      confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
    }

    // Générer des étoiles scintillantes
    for (let i = 0; i < 50; i++) {
      const sparkle = document.createElement('div');
      sparkle.className = 'sparkle';
      document.body.appendChild(sparkle);
      sparkle.style.left = `${Math.random() * 100}vw`;
      sparkle.style.top = `${Math.random() * 100}vh`;
      sparkle.style.animationDuration = `${Math.random() * 3 + 1}s`;
    }

    // Ajouter le son festif
    const audio = new Audio('https://www.soundjay.com/button/beep-07.wav'); // Exemple de son festif
    audio.volume = 0.5; // Ajuste le volume
    audio.play();
  </script>
</body>
</html>
