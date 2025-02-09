
// Modal

    // Fonction pour ouvrir la fenêtre modale au chargement de la page
    window.onload = function() {
        document.getElementById('beta-modal').style.display = 'block';
    };

    // Fonction pour fermer la fenêtre modale
    function closeBetaModal() {
        document.getElementById('beta-modal').style.display = 'none';
    }


	// nbr aleatoire

	        // Fonction pour générer un nombre aléatoire entre 120 et 145
			function generateRandomNumber(min, max) {
				return Math.floor(Math.random() * (max - min + 1)) + min;
			}
	
			// Fonction pour mettre à jour le compteur toutes les 3 secondes
			function updateCounter() {
				const counterElement = document.getElementById('counter');
				const randomValue = generateRandomNumber(120, 145);
				counterElement.textContent = randomValue;
			}
	
			// Démarre le compteur avec une mise à jour toutes les 3 secondes (3000 ms)
			setInterval(updateCounter, 3000);
	
			// Initialisation immédiate du compteur
			updateCounter();







