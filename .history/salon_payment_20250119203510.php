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
    
    
    <div class="section">
      <h2>💡 Détails de ton abonnement :</h2>
      <p>
        Ton salon restera actif tant que tu maintiens ton abonnement <span class="highlight">Premium</span>. <br>
        Tu peux également le supprimer depuis ton profil tout en conservant ton abonnement.
      </p>
    </div>

    <div class="section">
      <h2>📊 Revenu Estimé :</h2>
      <p>
        - Chaque utilisateur devra payer le nombre de jetons que tu as fixé. <br>
        - Par exemple, si tu demandes <span class="highlight">200 jetons</span> par utilisateur, cela correspond à <span class="highlight">2 €</span>.
      </p>
      <div class="example">
        <p><strong>Exemple de calcul :</strong></p>
        <p>Prix utilisateur : <span class="highlight">200 jetons (2 €)</span></p>
        <p>Commission de la plateforme : <span class="highlight">10 % (0,20 €)</span></p>
        <p>Ton gain par utilisateur : <span class="highlight">1,80 €</span></p>
        <p>Si 100 utilisateurs accèdent à ton salon : <span class="highlight">180 €/mois</span></p>
      </div>
    </div>

    <div class="container">
    <h1>Règlement de l'Abonnement</h1>
    <p>Page de règlement du salon "{salon_name}" avec abonnement <span style="color: #ffd700;">Premium</span>. <br> 
    Chaque personne souhaitant accéder à ce salon devra payer le nombre de jetons que tu as fixé. {jetons_nbr}</p>

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
