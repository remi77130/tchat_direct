// ========== SECTION 1: Gestion du Profil et de l'Affichage des Infos Utilisateur ==========
/**
 * Affiche la div de profil en récupérant les informations utilisateur par AJAX.
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
                    <button id="send-button">Envoyer</button>
                </div>
            `;
            container.style.display = 'block';
            setupChatEvents(userId);
        })
        .catch(error => console.error('Erreur lors du chargement du profil:', error));
}

/**
 * Ferme la fenêtre de profil.
 */
function closeProfileContainer() {
    document.getElementById('container_profil').style.display = 'none';
}



// ========== SECTION 2: Gestion des Événements de Chat ==========
/**
 * 
 * 
 * Gère les événements de chat pour l'envoi et la réception de messages.
 * @param {number} userId - L'ID de l'utilisateur cible pour le chat.
 */
function setupChatEvents(userId) {
    const messageInput = document.getElementById('chat-input');
    const fileInput = document.querySelector('.chat-file-input');
    document.getElementById('send-button').addEventListener('click', () => {
        const message = messageInput.value;
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                socket.emit('chatImage', { to: userId, image: event.target.result, fileName: file.name });
            };
            reader.readAsDataURL(file);
        }

        if (message.trim()) {
            socket.emit('chatMessage', { to: userId, message });
            messageInput.value = '';
        }

        fileInput.value = '';
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
 * 
 * 
 * Assainit une chaîne d'entrée pour prévenir les failles XSS.
 * @param {string} input - La chaîne à assainir.
 * @returns {string} La chaîne assainie.
 */
function sanitize(input) {
    const element = document.createElement('div');
    element.textContent = input;
    return element.innerHTML;
}

// ========== SECTION 4: Gestion des Filtres ==========
/**
 * Applique les filtres de genre, département et âge aux utilisateurs.
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



// ========== SECTION 5: Création et Gestion des Notifications ==========
/**
 * 
 * 
 *
 * Ajoute une notification pour un utilisateur.
 * @param {Object} user - Objet contenant les informations utilisateur.
 */
function addNotification(user) {
    const $notifications = $('#selected-profiles');
    if (!$notifications.find(`div[data-userid=${user.id}]`).length) {
        $notifications.append(`<div class="notification" data-userid="${user.id}" data-username="${user.username}">${user.username}</div>`);
    }
}

// Initialisation des événements pour les filtres
['gender-filter', 'department-filter', 'age-filter'].forEach(filterId => {
    document.getElementById(filterId).addEventListener('change', applyFilters);
});
