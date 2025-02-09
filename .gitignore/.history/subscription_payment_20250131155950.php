<!-- ICI, on récupére le nom de l'abonnement choisi {subscription_choice}--> 
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/payment.css">
  <title>Règlement abonnement</title>
  
</head>
<body>
  <div class="container">
    <h1>Page de Règlement abonnemen {subscription_choice}"</h1>

    <div class="payment-icons">
      <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="MasterCard">
      <img src="img_articles/discover_tchat-direct.png" alt="Visa">
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
    <div class="footer">
      <p>Des questions ? Consulte notre <a href="#" style="color: #3b8ef3; text-decoration: none;">FAQ</a>.</p>
    </div>
  </div>
</body>
</html>
