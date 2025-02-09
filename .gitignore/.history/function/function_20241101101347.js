// ========== SECTION 1: Gestion de l'Affichage du Profil ==========
/**
 * Affiche les informations de profil de l'utilisateur.
 * @param {number} userId - L'ID de l'utilisateur dont le profil doit être affiché.
 */
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
                    <input type="file" id="img_message" accept="image/JPEG, PNG, GIF">
                    <button id="send-button">Envoyer</button>
                </div>
            `;
            container.style.display = 'block';
            setupChatEvents(userId);
        })
        .catch(error => console.error('Erreur lors du chargement du profil:', error));
}

function closeProfileContainer() {
    document.getElementById('container_profil').style.display = 'none';
}


// ========== SECTION 2: Gestion des Événements du Chat ==========
/**
 * Initialise les événements pour l'envoi de messages dans le chat.
 * @param {number} userId - L'ID de l'utilisateur cible pour le chat.
 */
function setupChatEvents(userId) {
    const messageInput = document.getElementById('chat-input');
    const fileInput = document.getElementById('img_message');

    document.getElementById('send-button').addEventListener('click', () => {
        const message = messageInput.value;

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


// ========== SECTION 3: Fonctions Utilitaires ==========
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


// ========== SECTION 4: Gestion des Filtres d'Utilisateur ==========
/**
 * Applique les filtres de genre, département et âge pour afficher les utilisateurs correspondants.
 */
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
        if (ageFilter === '-30') ageMatch = age < 30;
        else if (ageFilter === '30-40') ageMatch = age >= 30 && age <= 40;
        else if (ageFilter === '45+') ageMatch = age > 45;

        row.style.display = (genderMatch && departmentMatch && ageMatch) ? '' : 'none';
    });
}

// Initialisation des filtres sur changement
['gender-filter', 'department-filter', 'age-filter'].forEach(filterId => {
    document.getElementById(filterId).addEventListener('change', applyFilters);
});


// ========== SECTION 5: Création de Fenêtres de Chat et Gestion des Notifications ==========
/**
 * Crée une fenêtre de chat pour un utilisateur donné.
 * @param {Object} user - L'objet utilisateur avec les informations nécessaires.
 * @param {boolean} [display=true] - Indique si la fenêtre de chat doit être affichée immédiatement.
 */
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

/**
 * Ferme la fenêtre de chat.
 */
function closeModal() {
    user_private = false;
    $('.modal').hide();
}

/**
 * Ajoute un utilisateur à la liste avec son profil et les informations principales.
 * @param {Object} user - L'utilisateur à ajouter.
 */
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

/**
 * Ajoute un département au filtre s'il n'est pas déjà présent.
 * @param {string} dep - Le département à ajouter.
 */
function addDepartement(dep) {
    const $departmentFilter = $('#department-filter');
    if ($departmentFilter.find(`option[value='${dep}']`).length === 0) {
        const newOption = $('<option></option>').attr('value', dep).text(dep);
        $departmentFilter.append(newOption);
    }
}

/**
 * Ajoute une notification pour un utilisateur spécifique.
 * @param {Object} user - L'utilisateur pour lequel la notification est ajoutée.
 */
function addNotification(user) {
    const $notifications = $('#selected-profiles');
    if (!$notifications.find(`div[data-userid=${user.id}]`).length) {
        $notifications.append(`<div class="notification" data-userid="${user.id}" data-username="${user.username}">${user.username}</div>`);
    }
}
