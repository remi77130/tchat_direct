

socket.on('addUser', function (user) {
    addUser(user);
});

socket.on('removeUser', function (user) {
    $(`.user[data-userid=${user.id}]`).remove();
    delete users[user.id];
});


socket.on('users', function (users) {
    $userlistContainer.empty();
    Object.values(users).forEach(user => {
        addUser(user);
    });
});


socket.on('private', function(user, message) {
    //createChat(user, false);
    let $chat = $(`#chat_${user.id} .chat-content`);
    let classe = (user.id === myuser.id) ? 'sent':'received';
    if ($chat.is(":visible")) {
        $chat.append(`<div class="message ${classe}">${message}</div>`);
        $chat.scrollTop($chat[0].scrollHeight);
    } else {
        createChat(user, false);
        let $chat = $(`#chat_${user.id} .chat-content`);
        $chat.append(`<div class="message ${classe}">${message}</div>`);
        $chat.scrollTop($chat[0].scrollHeight);
        addNotification(user);
    }
});


$(document).on('click', '.send-btn', (e)=>{
    let input = $(e.currentTarget).parent().find('input');
    if (!input.val()) return;
    socket.emit('private', user_private.username, input.val());
    let $chat = $(`#chat_${user_private.id} .chat-content`);
    $chat.append(`<div class="message sent">${input.val()}</div>`);
    $chat.scrollTop($chat[0].scrollHeight);
    $(input).val('');
});

$(document).on('keypress', '.chat-input', function (e) {
    if (e.key === 'Enter' && $(this).val().trim() !== '') {
        let input = $(e.currentTarget).parent().find('input');
        if (!input.val()) return;
        socket.emit('private', user_private.username, input.val());
        let $chat = $(`#chat_${user_private.id} .chat-content`);
        $chat.append(`<div class="message sent">${input.val()}</div>`);
        $chat.scrollTop($chat[0].scrollHeight);
        $(input).val('');
    }
});

$userlistContainer.on('click', '.user', function() {
    const id = $(this).data('userid');
    let user = users[id];
    createChat(user);
});
$(document).on('click', '.notification', (e)=>{
    $(e.currentTarget).remove();
   let user_id = $(e.currentTarget).data('userid');
   let user = users[user_id];
   createChat(user);
});
