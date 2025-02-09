/////////    INDEX.PHP


// FORM

$(document).ready(function() {
	$('#department_id').on('input', function() {
		var departmentId = $(this).val().trim();

		if (departmentId.length > 0) {
			$.ajax({
				url: 'get_cities.php',
				method: 'GET',
				data: { department_id: departmentId },
				success: function(data) {
					var citySelect = $('#ville_dpt');
					citySelect.empty();
					citySelect.append('<option value="">Sélectionnez une ville</option>');

					if (data.length > 0) {
						data.forEach(function(city) {
							citySelect.append('<option value="' + city.ville + '">' + city.ville + '</option>');
						});
						$('#city-container').show();
						citySelect.attr('required', true);
					} else {
						$('#city-container').hide();
						citySelect.removeAttr('required');
					}
				},
				error: function(xhr, status, error) {
					console.error("Erreur AJAX : ", status, error);
				}
			});
		} else {
			$('#city-container').hide();
			$('#ville_dpt').removeAttr('required');
		}
	});
});





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







