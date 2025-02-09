// ========== SECTION 1: Gestion des Événements de Connexion et Déconnexion des Utilisateurs ==========
/**
 * Ajoute un utilisateur à la liste des utilisateurs en ligne.
 
// ========== SECTION 2: Gestion de la Communication Privée ==========
/**
 * Reçoit et affiche un message privé.
 * @param {Object} user - L'utilisateur qui envoie le message.
 * @param {string} message - Le contenu du message privé.
 */
socket.on('private', function(user, message) {
    let $chat = $(`#chat_${user.id} .chat-content`);
    let classe = (user.id === myuser.id) ? 'sent' : 'received';

    if ($chat.is(":visible")) {
        $chat.append(`<div class="message ${classe}">${message}</div>`);
        $chat.scrollTop($chat[0].scrollHeight);
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
 * Envoie un message depuis le champ d'entrée du chat.
 * @param {Event} e - L'événement du clic.
 */
$(document).on('click', '.send-btn', (e) => {
    let input = $(e.currentTarget).parent().find('input');
    if (!input.val()) return;

    socket.emit('private', user_private.username, input.val());
    let $chat = $(`#chat_${user_private.id} .chat-content`);
    $chat.append(`<div class="message sent">${input.val()}</div>`);
    $chat.scrollTop($chat[0].scrollHeight);
    input.val('');
});

/**
 * Envoie un message lorsque l'utilisateur appuie sur "Enter" dans le champ d'entrée du chat.
 * @param {Event} e - L'événement de la touche appuyée.
 */
$(document).on('keypress', '.chat-input', function(e) {
    if (e.key === 'Enter' && $(this).val().trim() !== '') {
        let input = $(e.currentTarget).parent().find('input');
        if (!input.val()) return;

        socket.emit('private', user_private.username, input.val());
        let $chat = $(`#chat_${user_private.id} .chat-content`);
        $chat.append(`<div class="message sent">${input.val()}</div>`);
        $chat.scrollTop($chat[0].scrollHeight);
        input.val('');
    }
});

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
