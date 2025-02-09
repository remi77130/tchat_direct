<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Membre</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: #f1f1f1;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .profile-container {
      background: #fff;
      width: 90%;
      max-width: 400px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      position: relative;
    }

    .profile-container h1 {
      font-size: 20px;
      margin-bottom: 20px;
      color: #333;
    }

    .profile-avatar {
      position: relative;
      display: inline-block;
      margin-bottom: 15px;
    }

    .profile-avatar img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 3px solid #ddd;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-avatar img:hover {
      transform: scale(1.1);
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .profile-avatar .edit-icon {
      position: absolute;
      bottom: 0;
      right: 0;
      background: #4caf50;
      color: #fff;
      font-size: 12px;
      border-radius: 50%;
      padding: 5px;
      cursor: pointer;
    }

    .profile-info {
      margin-bottom: 15px;
      font-size: 16px;
      color: #555;
    }

    .auth-buttons {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-bottom: 20px;
    }

    .auth-buttons button {
      padding: 10px;
      font-size: 14px;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .auth-buttons button.auth-phone {
      background: #ff4d4d;
      color: #fff;
    }

    .auth-buttons button.auth-phone:hover {
      background: #ff1a1a;
      transform: scale(1.05);
    }

    .auth-buttons button.auth-mail {
      background: #f44336;
      color: #fff;
    }

    .auth-buttons button.auth-mail:hover {
      background: #d32f2f;
      transform: scale(1.05);
    }

    .premium-button {
      background: #4caf50;
      color: #fff;
      font-size: 16px;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .premium-button:hover {
      background: #45a049;
      transform: scale(1.05);
    }

    .close-icon {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 18px;
      color: #f44336;
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .close-icon:hover {
      transform: scale(1.2);
    }
  </style>
</head>
<body>

<div class="profile-container">
  <span class="close-icon" onclick="closeProfile()">&times;</span>
  <h1>Profil Membre</h1>
  <div class="profile-avatar">
    <img src="https://via.placeholder.com/100" alt="Avatar" onclick="changeAvatar()">
    <span class="edit-icon" onclick="changeAvatar()">✎</span>
  </div>
  <div class="profile-info">
    <p><strong>Pseudo :</strong> John Doe</p>
    <p><strong>Âge :</strong> 32 ans</p>
    <p><strong>Localisation :</strong> 75013 Paris</p>
  </div>
  <div class="auth-buttons">
    <button class="auth-phone">Authentification téléphone : <span style="color: #fff;">Non</span></button>
    <button class="auth-mail">Authentification e-mail : <span style="color: #fff;">Non</span></button>
  </div>
  <button class="premium-button" onclick="goPremium()">Premium</button>
</div>

<script>
  function closeProfile() {
    alert('Fermeture du profil !');
  }

  function changeAvatar() {
    alert('Changer l\'avatar.');
  }

  function goPremium() {
    alert('Redirection vers l\'abonnement Premium.');
  }
</script>

</body>
</html>
