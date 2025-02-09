// ========== SECTION 1: Gestion du formulaire pour la sélection des villes ==========
$(document).ready(function() {
    $('#department_id').on('input', function() {
        var departmentId = $(this).val().trim();

        if (departmentId.length > 0) {
            // Requête AJAX pour obtenir les villes en fonction du département
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


// ========== SECTION 2: Fonctionnalités de la modale ==========
window.onload = function() {
    // Ouvre la fenêtre modale au chargement de la page
    document.getElementById('beta-modal').style.display = 'block';
};

// Fonction pour fermer la fenêtre modale
function closeBetaModal() {
    document.getElementById('beta-modal').style.display = 'none';
}


// ========== SECTION 3: Fonction utilitaire pour le nombre aléatoire ==========
/**
 * Génère un nombre aléatoire entre min et max.
 * @param {number} min - La valeur minimale.
 * @param {number} max - La valeur maximale.
 * @returns {number} Nombre aléatoire compris entre min et max.
 */
function generateRandomNumber(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


// ========== SECTION 4: Mise à jour du compteur ==========
/**
 * Met à jour le compteur avec une valeur aléatoire toutes les 3 secondes.
 */
function updateCounter() {
    const counterElement = document.getElementById('counter');
    const randomValue = generateRandomNumber(120, 145);
    counterElement.textContent = randomValue;
}

// Initialisation du compteur avec une mise à jour toutes les 3 secondes (3000 ms)
setInterval(updateCounter, 3000);
updateCounter();  // Appel initial pour démarrer immédiatement le compteur
