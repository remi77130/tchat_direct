

// ========== SECTION 2: Fonctions Utilitaires ==========
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

/**
 * Assainit les entrées pour éviter les failles XSS.
 * @param {string} input - La chaîne à assainir.
 * @returns {string} La chaîne assainie.
 */
function sanitize(input) {
    const element = document.createElement('div');
    element.textContent = input;
    return element.innerHTML;
}

// ========== SECTION 3: Gestion des Événements Socket ==========
/**
 * Ajoute un utilisateur à la liste des utilisateurs en ligne.

/**

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
        appendMessage($chat, message, classe);
        addNotification(user);
    }
});

// ========== SECTION 4: Gestion de l'Interface du Chat ==========
/**
 * Envoie un message depuis le champ d'entrée du chat.
 */
$(document).on('click', '.send-btn', (e) => {
    let input = $(e.currentTarget).parent().find('input');
    if (!input.val()) return;

    socket.emit('private', user_private.username, input.val());
    let $chat = $(`#chat_${user_private.id} .chat-content`);
    appendMessage($chat, input.val(), 'sent');
    input.val('');
});

/**
 * Ouvre une fenêtre de chat pour l'utilisateur sélectionné.
 */
$userlistContainer.on('click', '.user', function() {
    const id = $(this).data('userid');
    let user = users[id];
    createChat(user);
});

/**
 * Affiche une notification lorsqu'un nouveau message est reçu.
 */
$(document).on('click', '.notification', (e) => {
    $(e.currentTarget).remove();
    let user_id = $(e.currentTarget).data('userid');
    let user = users[user_id];
    createChat(user);
});

// ========== SECTION 5: Gestion de l'Affichage du Profil et des Filtres ==========
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
