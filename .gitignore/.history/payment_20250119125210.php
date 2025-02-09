<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paiement Abonnement</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: linear-gradient(135deg, #1e1e2f, #28293e);
      color: #f1f1f1;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background: #2c2c4e;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }
    h1 {
      text-align: center;
      font-size: 24px;
      color: #ffd700;
      margin-bottom: 20px;
    }
    p {
      font-size: 16px;
      line-height: 1.6;
      margin-bottom: 20px;
      text-align: center;
    }
    .payment-icons {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }
    .payment-icons img {
      width: 60px;
      height: auto;
      filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-size: 14px;
    }
    input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      color: #000;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    input:focus {
      outline: none;
      border: 1px solid #3b8ef3;
      box-shadow: 0 0 10px rgba(59, 142, 243, 0.5);
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
  </style>
</head>
<body>
  <div class="container">
    <h1>Règlement de l'Abonnement</h1>
    <p>Page de règlement du salon "{salon_name}" avec abonnement <span style="color: #ffd700;">Premium</span>. <br> 
    Chaque personne souhaitant accéder à ce salon devra payer le nombre de jetons que tu as fixé.</p>

    <div class="payment-icons">
      <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="MasterCard">
      <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Visa_2014_logo_detail.png" alt="Visa">
      <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal">
      <img src="img_articles/amex.png" alt="American Express">
    </div>

    <form>
      <div class="form-group">
        <label for="card-number">Numéro de Carte</label>
        <input type="text" id="card-number" placeholder="XXXX-XXXX-XXXX-XXXX" required>
      </div>
      <div class="form-group">
        <label for="expiry-date">Date d'Expiration (MM/AA)</label>
        <input type="text" id="expiry-date" placeholder="MM/YY" required>
      </div>
      <div class="form-group">
        <label for="cvv">Code CVV</label>
        <input type="text" id="cvv" placeholder="CVC" required>
      </div>
      <div class="form-group">
        <label for="card-owner">Titulaire de la Carte</label>
        <input type="text" id="card-owner" placeholder="Nom du Titulaire" required>
      </div>
      <div class="button-container">
        <button type="submit" class="button">Confirmer le Paiement</button>
      </div>
    </form>
  </div>
</body>
</html>
