<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/auth_phone_validate.css">
  <title>Validation Réussie</title>

</head>
<body>
  <div class="container">
    <h1>Bravo {username} </h1>
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
