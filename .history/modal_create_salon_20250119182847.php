<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Créer un Salon</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      background: #1e1e2f;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 10;
    }

    .modal {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 90%;
      max-width: 400px;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      z-index: 20;
    }

    .modal h2 {
      font-size: 18px;
      color: #333;
      margin-bottom: 10px;
      text-align: center;
    }

    .modal p {
      font-size: 14px;
      color: #555;
      margin-bottom: 20px;
      line-height: 1.5;
      text-align: center;
    }

    .modal input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-bottom: 20px;
      box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .modal input:focus {
      outline: none;
      border-color: #4caf50;
      box-shadow: 0 0 10px rgba(76, 175, 80, 0.5);
    }

    .modal .close {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 18px;
      color: #f44336;
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .modal .close:hover {
      transform: scale(1.2);
    }

    .modal button {
      display: block;
      width: 100%;
      padding: 10px 0;
      font-size: 16px;
      font-weight: bold;
      color: #fff;
      background: #4caf50;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .modal button:hover {
      background: #45a049;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

<div class="overlay" id="overlay"></div>
<div class="modal" id="modal">
  <span class="close" id="close">&times;</span>
  <h2>Créer un Salon</h2>
  <p>
    Tu peux créer ton propre salon.<br>
    Ton salon restera actif tant que tu es premium.<br>
    Tu peux le supprimer via le menu sur ton profil.
  </p>
  <input type="text" placeholder="Nom du salon" id="salonName" >
  <button onclick="createSalon()">Valider</button>
</div>

<script>
  // Fermer le modal
  document.getElementById('close').addEventListener('click', () => {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('modal').style.display = 'none';
  });

  // Fonction de validation
  function createSalon() {
    const salonName = document.getElementById('salonName').value;
    if (salonName.trim() === '') {
      alert('Veuillez entrer un nom de salon.');
    } else {
      alert(`Salon "${salonName}" créé avec succès !`);
      // Fermer le modal après création
      document.getElementById('overlay').style.display = 'none';
      document.getElementById('modal').style.display = 'none';
    }
  }
</script>

</body>
</html>
