// ========== SECTION 1: Gestion des Événements de Connexion et Déconnexion des Utilisateurs ==========
/**
 * Ajoute un utilisateur à la liste des utilisateurs en ligne.
 * 
 * 
 * 
 * 
 * 
 */
socket.on('addUser', function(user) {
    addUser(user);
});


/**
 *  @param {Object} user - L'utilisateur ajouté.
 * @param {Object} $chat - Conteneur du chat.
 * @param {string} message - Le message à ajouter.
 * @param {string} classe - La classe CSS ('sent' ou 'received').
 * @returns {string} La chaîne assainie.
 *  * @param {Event} e - L'événement de clic sur la notification.

 */

/**
 * Charge la liste complète des utilisateurs au démarrage.
 * Utilité : Met à jour la liste des utilisateurs connectés en temps réel.
 */
socket.on('users', function(users) {
    $userlistContainer.empty(); // Réinitialise le conteneur avant de le remplir.
    Object.values(users).forEach(user => {
        addUser(user);
    });
});

// ========== SECTION 2: Gestion de la Communication Privée ==========
/**
 * Reçoit et affiche un message privé.
 */
socket.on('private', function(user, message) {
    let $chat = $(`#chat_${user.id} .chat-content`);
    let classe = (user.id === myuser.id) ? 'sent' : 'received';

    if ($chat.is(":visible")) {
        appendMessage($chat, message, classe);
    } else {
        createChat(user, false);
        $chat = $(`#chat_${user.id} .chat-content`);
        appendMessage($chat, message, classe);
        addNotification(user);
    }
});


function appendMessage($chat, message, classe) {
    $chat.append(`<div class="message ${classe}">${message}</div>`);
    $chat.scrollTop($chat[0].scrollHeight);
}

* Ouvre une fenêtre de chat pour l'utilisateur sélectionné.
*/
$userlistContainer.on('click', '.user', function() {
   const id = $(this).data('userid');
   let user = users[id];
   createChat(user);
});



