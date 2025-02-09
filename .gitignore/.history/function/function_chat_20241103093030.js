
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

// ========== SECTION 3: Gestion de l'Interface du Chat ==========
/**
 * Envoie un message depuis le champ d'entrée du chat.
 */
$(document).on('click', '.send-btn', (e) => {
    let input = $(e.currentTarget).parent().find('input');
    if (!input.val()) return;

    socket.emit('private', user_private.username, input.val());
    let $chat = $(`#chat_${user_private.id} .chat-content`);
    appendMessage($chat, input.val(), 'sent');
    input.val(''); // Réinitialise le champ d'entrée.
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
 */
$(document).on('click', '.notification', (e) => {
    $(e.currentTarget).remove();
    let user_id = $(e.currentTarget).data('userid');
    let user = users[user_id];
    createChat(user);
});




