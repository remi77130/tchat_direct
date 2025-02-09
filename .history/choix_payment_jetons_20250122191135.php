<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Choix du Paiement en Jetons</title>
  <link rel="stylesheet" href="style/choix_payment_jetons.css">

</head>
<body>
<style>
        /* Style pour masquer le modal par défaut */
        .modal {
            display: none; /* Masqué par défaut */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5); /* Couleur de fond transparent */
        }

        /* Contenu du modal */
        .modal-content {
            background-color: #fff;
            margin: 15% auto; /* Centré verticalement */
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Largeur du modal */
            text-align: center;
        }

        /* Bouton de fermeture */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
    </style>
<div class="container">
<h1>Déterminez le montant en jetons pour l’accès à votre salon exclusif : {salon_name}</h1>
 <!-- Bouton pour ouvrir le modal -->
 <button id="openModalBtn">Info</button>
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

    <!-- Le modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Bonjour, je suis un Modal !</h2>
            <p>Ceci est un contenu dans une fenêtre modale.</p>
        </div>
    </div>



  <script>
    const slider = document.getElementById('jetonSlider');
    const output = document.getElementById('output');
    const earnings = document.getElementById('earnings');

    slider.addEventListener('input', () => {
      const jetons = slider.value;
      const euros = (jetons / 100).toFixed(2); // Conversion jetons -> euros
      const commission = (euros * 0.10).toFixed(2); // 10 % de commission
      const netGainPerUser = (euros - commission).toFixed(2); // Gain net par utilisateur
      const potentialGains = (netGainPerUser * 1000).toFixed(2); // Exemple : 50 utilisateurs

      output.textContent = `${jetons} Jetons (${jetons === '0' ? 'Gratuit' : euros + ' €'})`;
      earnings.textContent = `Gains estimés (net) : ${potentialGains} € /mois (50 utilisateurs).`;
    });

        // Récupération des éléments HTML
        const modal = document.getElementById("myModal");
        const openModalBtn = document.getElementById("openModalBtn");
        const closeModal = document.getElementById("closeModal");

        // Ouvrir le modal
        openModalBtn.addEventListener("click", () => {
            modal.style.display = "block";
        });

        // Fermer le modal en cliquant sur le bouton "x"
        closeModal.addEventListener("click", () => {
            modal.style.display = "none";
        });

        // Fermer le modal en cliquant en dehors du contenu
        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
  </script>
</body>
</html>
