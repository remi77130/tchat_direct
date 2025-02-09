// ========== SECTION 1: Gestion des Événements de Connexion et Déconnexion des Utilisateurs ==========
/**
 * Ajoute un utilisateur à la liste des utilisateurs en ligne.
 * @param {Object} user - L'utilisateur ajouté.
 */
socket.on('addUser', function(user) {
    addUser(user);
});




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
 * @param {Object} user - L'utilisateur qui envoie le message.
 * @param {string} message - Le contenu du message privé.
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

/**
 * Ajoute un message au conteneur de chat et défile vers le bas.
 * @param {Object} $chat - Conteneur du chat.
 * @param {string} message - Le message à ajouter.
 * @param {string} classe - La classe CSS ('sent' ou 'received').
 */
function appendMessage($chat, message, classe) {
    $chat.append(`<div class="message ${classe}">${message}</div>`);
    $chat.scrollTop($chat[0].scrollHeight);
}

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
 * @param {Event} e - L'événement de clic sur la notification.
 */
$(document).on('click', '.notification', (e) => {
    $(e.currentTarget).remove();
    let user_id = $(e.currentTarget).data('userid');
    let user = users[user_id];
    createChat(user);
});




