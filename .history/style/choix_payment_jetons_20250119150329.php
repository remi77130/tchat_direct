<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Choix du Paiement en Jetons</title>
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
      width: 90%;
      max-width: 500px;
      background: #2c2c4e;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }
    h1 {
      text-align: center;
      font-size: 20px;
      margin-bottom: 20px;
    }
    .slider-container {
      position: relative;
      margin: 20px 0;
    }
    .slider {
      -webkit-appearance: none;
      width: 100%;
      height: 10px;
      background: linear-gradient(90deg, #4caf50, #ff5722);
      border-radius: 5px;
      outline: none;
      opacity: 0.9;
      transition: opacity 0.2s;
    }
    .slider:hover {
      opacity: 1;
    }
    .slider-label {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
      font-size: 14px;
    }
    .output {
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      margin-top: 10px;
    }
    .warning {
      font-size: 14px;
      color: #ffd700;
      text-align: center;
      margin-top: 10px;
    }
    .button-container {
      text-align: center;
      margin-top: 20px;
    }
    .button {
      padding: 15px 30px;
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
    .earnings {
      margin-top: 15px;
      font-size: 14px;
      text-align: center;
      color: #0dcaf0;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Choisissez le Montant pour votre Salon "{salon_name}"</h1>
    <div class="slider-container">
      <input type="range" min="0" max="300" step="50" value="0" class="slider" id="jetonSlider">
      <div class="slider-label">
        <span>0 Jetons (Gratuit)</span>
        <span>300 Jetons</span>
      </div>
    </div>
    <div class="output" id="output">0 Jetons (Gratuit)</div>
    <p class="warning">Attention, plus le prix est élevé, plus vous devrez attirer du monde !</p>
    <div class="earnings" id="earnings">Gains estimés : 0 € (0 utilisateurs).</div>
    <div class="button-container">
      <button class="button">Valider</button>
    </div>
  </div>

  <script>
    const slider = document.getElementById('jetonSlider');
    const output = document.getElementById('output');
    const earnings = document.getElementById('earnings');

    slider.addEventListener('input', () => {
      const jetons = slider.value;
      const euros = (jetons / 100).toFixed(2);
      output.textContent = `${jetons} Jetons (${jetons === '0' ? 'Gratuit' : euros + ' €'})`;
      const potentialGains = (euros * 50).toFixed(2); // Exemple : 50 utilisateurs
      earnings.textContent = `Gains estimés : ${potentialGains} € (50 utilisateurs).`;
    });
  </script>
</body>
</html>
