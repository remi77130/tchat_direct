<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Salons</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: #f1f1f1;
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
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      position: relative;
    }

    .modal h2 {
      font-size: 20px;
      color: #333;
      margin-bottom: 20px;
    }

    .dropdown {
      margin-bottom: 20px;
      position: relative;
    }

    select {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 5px;
      appearance: none;
      cursor: pointer;
    }

    .dropdown::after {
      content: "▼";
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      pointer-events: none;
      font-size: 16px;
      color: #888;
    }

    .buttons {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }

    .btn {
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-danger {
      background: #ff4d4d;
      color: #fff;
    }

    .btn-danger:hover {
      background: #ff1a1a;
      transform: scale(1.05);
    }

    .btn-share {
      background: #4caf50;
      color: #fff;
    }

    .btn-share:hover {
      background: #45a049;
      transform: scale(1.05);
    }

    .confirmation {
      display: none;
      background: #fff;
      border: 1px solid #ddd;
      padding: 20px;
      border-radius: 10px;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 10;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    .confirmation p {
      margin-bottom: 20px;
    }

    .overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 5;
    }
  </style>
</head>
<body>
  <div class="modal">
    <h2>Voici vos salons</h2>
    <p>Premium depuis : <strong>Date</strong></p>
    <div class="dropdown">
      <select id="salonSelect">
        <option value="salon1">Salon 1</option>
        <option value="salon2">Salon 2</option>
      </select>
    </div>
    <div class="buttons">
      <button class="btn btn-danger" onclick="confirmDelete()">Supprimer</button>
      <button class="btn btn-share" onclick="shareSalon()">Partager</button>
    </div>
  </div>

  <!-- Confirmation Popup -->
  <div class="overlay" id="overlay"></div>
  <div class="confirmation" id="confirmation">
    <p>Êtes-vous sûr de vouloir supprimer ce salon ?</p>
    <button class="btn btn-danger" onclick="deleteSalon()">Oui, supprimer</button>
    <button class="btn btn-share" onclick="closeCo
