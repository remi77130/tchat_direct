// ========== SECTION 1: Gestion de l'Affichage du Profil ==========
/**
 * Affiche les informations de profil de l'utilisateur.
 */
function showProfileContainer(userId) {
    
    fetch(`get_user_info.php?user_id=${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            renderProfile(data);
            setupChatEvents(userId);
        })
        .catch(error => console.error('Erreur lors du chargement du profil:', error));
}

