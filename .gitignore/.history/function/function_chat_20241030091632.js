// ========== SECTION 1: Gestion des Événements de Connexion et Déconnexion des Utilisateurs ==========
/**
 * Ajoute un utilisateur à la liste des utilisateurs en ligne.
 * @param {Object} user - L'utilisateur ajouté.
 */
socket.on('addUser', function(user) {
    addUser(user);
});

/**
 * Retire un utilisateur de la liste des utilisateurs en ligne.
 * @param {Object} user - L'utilisateur retiré.
 */
socket.on('removeUser', function(user) {
    $(`.user[data-userid=${user.id}]`).remove();
    delete users[user.id];
});

/**
 * Charge la liste complète des utilisateurs au démarrage.
 * @param {Object} users - Objet conten
