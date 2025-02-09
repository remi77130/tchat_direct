// CHAT.PHP

// Fonction pour afficher la div de profil
function showProfileContainer(userId) {
    fetch(`get_user_info.php?user_id=${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            const container = document.getElementById('container_profil');
            container.innerHTML = `
                <div class="profile-content">
                    <button class="close-btn" onclick="closeProfileContainer()">Fermer</button>
                    <div>
                        <img src="${sanitize(data.avatar)}" alt="${sanitize(data.username)}" class="avatar">
                        <h3>${sanitize(data.username)}</h3>  
                        <h3>${sanitize(data.department)}</h3>
                    </div>
                    <div id="message_user"></div>
                    <div id="chat-messages"></div>
                    <input id="chat-input" type="text" placeholder="Entrez votre message">
                    <!-- envoyer une image -->	<input type="file" id="img_message" accept="image/JPEG, PNG, GIF" >

                    <button id="send-button">Envoyer</button>
                </div>
            `;
            container.style.display = 'block';

            setupChatEvents(userId);
        })
        .catch(error => console.error('Erreur lors du chargement du profil:', error));
}

function setupChatEvents(userId) {
    const messageInput = document.getElementById('chat-input');
    const fileInput = document.querySelector('.chat-file-input');
    document.getElementById('send-button').addEventListener('click', () => {
        const message = messageInput.value;
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                socket.emit('chatImage', { to: user.id, image: event.target.result, fileName: file.name });
            };
            reader.readAsDataURL(file);
        }

        if (message.trim()) {
            socket.emit('chatMessage', { to: userId, message });
            messageInput.value = '';
        }

        fileInput.value = ''; // Réinitialisation du champ de fichier
    });

    socket.on('chatMessage', ({ from, message }) => {
        if (from === userId) {

            const messagesContainer = document.getElementById('chat-messages');
            const messageElement = document.createElement('div');
            messageElement.textContent = message;
            messagesContainer.appendChild(messageElement);
        }
    });
}

function closeProfileContainer() {
    document.getElementById('container_profil').style.display = 'none';
}

// Fonction pour assainir les entrées utilisateur
function sanitize(input) {
    const element = document.createElement('div');
    element.textContent = input;
    return element.innerHTML;
}

// Fonction pour appliquer les filtres
function applyFilters() {
    const genderFilter = document.getElementById('gender-filter').value;
    const departmentFilter = document.getElementById('department-filter').value;
    const ageFilter = document.getElementById('age-filter').value;
    const rows = document.querySelectorAll('#users-table tbody tr');

    rows.forEach(row => {
        const genderClass = row.classList.contains('female-row') ? 'female' : row.classList.contains('male-row') ? 'male' : 'other';
        const department = row.querySelector('td:nth-child(4)').textContent;
        const age = parseInt(row.querySelector('td:nth-child(3)').textContent);

        const genderMatch = (genderFilter === 'all' || genderFilter === genderClass);
        const departmentMatch = (departmentFilter === 'all' || departmentFilter === department);

        let ageMatch = true;
        if (ageFilter === '-30') {
            ageMatch = age < 30;
        } else if (ageFilter === '30-40') {
            ageMatch = age >= 30 && age <= 40;
        } else if (ageFilter === '45+') {
            ageMatch = age > 45;
        }

        row.style.display = (genderMatch && departmentMatch && ageMatch) ? '' : 'none';
    });
}

// Gestion des filtres
['gender-filter', 'department-filter', 'age-filter'].forEach(filterId => {
    document.getElementById(filterId).addEventListener('change', applyFilters);
});

// Création de la fenêtre de chat
function createChat(user, display = true) {
    const id = `chat_${user.id}`;
    user_private = user;
    let $chat = $(`#${id}`);
    $('.modal').hide();

    if (!$chat.length) {
        const template = `
            <div id="${id}" class="modal">
                <div class="chat-popup">
                    <div class="chat-header">
                        <img src="${user.avatar}" alt="Avatar" class="avatar64">
                        <div class="username">${user.username}</div>
                        <div class="userage">${user.age} ans</div>
                        <div class="userdpt">${user.dep}</div>
                        <div class="userville">${user.ville}</div>
                    </div>
                    <div class="chat-content"></div>
                    <div class="chat-footer">
                        <input type="text" class="chat-input" placeholder="Tapez votre message...">
                        <button class="send-btn">Envoyer</button>
                    </div>
                </div>
                <button class="close-btn" onclick="closeModal()">Fermer</button>
            </div>`;
        $('body').append(template);
    }
    if (display) document.getElementById(id).style.display = 'flex';
}

function closeModal() {
    user_private = false;
    $('.modal').hide();
}

function addUser(user) {
    users[user.id] = user;
    const class_user = (user.gender === 'female') ? 'female-row' : 'male-row';
    $userlistContainer.append(`
        <tr class="user ${class_user}" data-userid="${user.id}" data-username="${user.username}" 
            data-avatar="${user.avatar}" data-age="${user.age}" data-ville="${user.ville}" 
            data-dep="${user.dep}" data-gender="${user.gender}">
            <td><img class="avatar16" src="${user.avatar}" alt="${user.username}"></td>
            <td><b>${user.username}</b></td>
            <td>${user.age}</td>
            <td>${user.dep}</td>
            <td>${user.ville}</td>
        </tr>`);
    addDepartement(user.dep);
}

function addDepartement(dep) {
    const $departmentFilter = $('#department-filter');
    if ($departmentFilter.find(`option[value='${dep}']`).length === 0) {
        const newOption = $('<option></option>').attr('value', dep).text(dep);
        $departmentFilter.append(newOption);
    }
}

function addNotification(user) {
    const $notifications = $('#selected-profiles');
    if (!$notifications.find(`div[data-userid=${user.id}]`).length) {
        $notifications.append(`<div class="notification" data-userid="${user.id}" data-username="${user.username}">${user.username}</div>`);
    }
}

// Fonction de la page rencontre
function toggleRencontre() {
    const rencontreDiv = document.getElementById('rencontre');
    rencontreDiv.style.display = (rencontreDiv.style.display === 'none' || rencontreDiv.style.display === '') ? 'block' : 'none';
}

document.getElementById('send-message').addEventListener('click', function() {
    const chatInput = document.getElementById('chat-input');
    const chatContent = document.getElementById('chat-content');
    const username = document.getElementById('username').value;

    const message = chatInput.value.trim();
    if (message) {
        const messageElement = document.createElement('p');
        messageElement.textContent = message;
        chatContent.appendChild(messageElement);
        chatInput.value = '';
    }

















    
});







