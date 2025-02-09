<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Identification par SMS</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: #1e1e2f;
      color: #f1f1f1;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .modal {
      background: #fff;
      width: 90%;
      max-width: 400px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      text-align: center;
      position: relative;
    }
    .modal h2 {
      font-size: 18px;
      color: #333;
      margin-bottom: 10px;
    }
    .modal p {
      font-size: 14px;
      color: #555;
      margin-bottom: 20px;
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
    .modal button {
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      color: #fff;
      background: #4caf50;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .modal button:hover {
      background: #45a049;
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
    .note {
      font-size: 12px;
      color: #888;
      margin-top: 10px;
    }
    .note span {
      color: #4caf50;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="modal">
    <span class="close" onclick="alert('Modal fermé')">&times;</span>
    <h2>Identification requise</h2>
    <p>T'identifier te permettra de recevoir plus de messages et d'accéder à toutes les fonctionnalités.</p>
    <input type="tel" placeholder="Votre numéro de téléphone (+33)" pattern="^(\+33|0)[1-9](\d{2}){4}$" required>
    <button onclick="alert('Numéro validé')">Valider</button>
    <p class="note">Votre numéro restera <span>confidentiel</span>.</p>
  </div>
</body>
</html>
