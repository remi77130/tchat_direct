// ========== SECTION 1: Gestion des Événements de Connexion et Déconnexion des Utilisateurs ==========
/**
 * Ajoute un utilisateur à la liste des utilisateurs en ligne.
 * @param {Object} user - L'utilisateur ajouté.
 */
socket.on('addUser', function(user) {
    addUser(user);
});

/**

/**
 * Charge la liste complète des utilisateurs au démarrage.
 */
socket.on('users', function(users) {
    $userlistContainer.empty();
    Object.values(users).forEach(user => {
        addUser(user);
    });
});


// ========== SECTION 2: Gestion de la Communication Privée ==========
/**
 * Reçoit et affiche un message privé.
 * @param {Object} user - L'utilisateur qui envoie le message.
 * @param {string} message - Le contenu du message privé.
 */
socket.on('private', function(user, message) {
    let $chat = $(`#chat_${user.id} .chat-content`);
    let classe = (user.id === myuser.id) ? 'sent' : 'received'; // message privé est reçu, la fonction est
                                                                //appelée avec deux paramètres : user message

    if ($chat.is(":visible")) { // Vérifie si le chat est visible.

        $chat.append(`<div class="message ${classe}">${message}</div>`); // Ajoute le message au conteneur de chat avec la classe appropriée (sent ou received).
        $chat.scrollTop($chat[0].scrollHeight); //  défiler le chat pour que le dernier message ajouté soit visible en bas de la fenêtre.

    } else {
        createChat(user, false);
        $chat = $(`#chat_${user.id} .chat-content`);
        $chat.append(`<div class="message ${classe}">${message}</div>`);
        $chat.scrollTop($chat[0].scrollHeight);
        addNotification(user);
    }
});


// ========== SECTION 3: Gestion de l'Interface du Chat ==========
/**
 



/**
 * Ouvre une fenêtre de chat pour l'utilisateur sélectionné.
 */
$userlistContainer.on('click', '.user', function() {
    const id = $(this).data('userid');
    let user = users[id];
    createChat(user);
});


// ========== SECTION 4: Notifications de Nouveaux Messages ==========
/**
 * Affiche une notification lorsqu'un nouveau message est reçu.
 * @param {Event} e - L'événement de clic sur la notification.
 */
$(document).on('click', '.notification', (e) => {
    $(e.currentTarget).remove();

    let user_id = $(e.currentTarget).data('userid');
    let user = users[user_id];
    createChat(user);
});
