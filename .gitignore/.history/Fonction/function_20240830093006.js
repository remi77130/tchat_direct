// Initialisation de la connexion Socket.io
const socket = io(); 

// Fonction pour envoyer l'événement de connexion de l'utilisateur
function userConnected(userId) {
    socket.emit('userConnected', userId);
}

// Fonction pour mettre à jour la liste des utilisateurs affichés
socket.on('updateUserList', (activeUserIds) => {
    const rows = document.querySelectorAll('#users-table tbody tr');
    rows.forEach(row => {
        const userId = row.getAttribute('data-user-id');
        if (!activeUserIds.includes(userId)) {
            row.remove(); // Supprime la ligne si l'utilisateur n'est plus actif
        }
    });
});

// Exemple de déclenchement de la connexion lors du chargement de la page ou lorsqu'un utilisateur se connecte
window.addEventListener('load', () => {
    const currentUserId = /* Récupérer l'ID de l'utilisateur connecté ici */;
    userConnected(currentUserId);
});

// Récupérer les utilisateurs depuis fetch_users.php et les afficher
async function fetchUsers() {
    try {
        const response = await fetch('fetch_users.php');
        if (!response.ok) {
            throw new Error('Erreur réseau : ' + response.status);
        }

        const data = await response.json();
        const tbody = document.querySelector('#users-table tbody');
        tbody.innerHTML = ''; // Vide le tableau avant de le remplir

        const departmentFilter = document.getElementById('department-filter');
        const departments = new Set(); // Utilise un Set pour des départements uniques
        const fragment = document.createDocumentFragment(); // Fragment pour limiter les reflows/repaints

        data.forEach(user => {
            const row = document.createElement('tr');
            row.setAttribute('data-user-id', user.id);

            departments.add(user.department);

            row.classList.add(user.gender === 'female' ? 'female-row' :
                              user.gender === 'male' ? 'male-row' : 'other-row');

            row.innerHTML = `
                <td><img src="${sanitize(user.avatar)}" alt="${sanitize(user.username)}" class="avatar"></td>
                <td>${sanitize(user.username)}</td>
                <td>${sanitize(user.age)}</td>
                <td>${sanitize(user.department)}</td>
                <td>${sanitize(user.ville_users)}</td>
            `;

            fragment.appendChild(row);

            row.addEventListener('click', () => {
                showProfileContainer(user.id);
            });
        });

        tbody.appendChild(fragment);
        updateDepartmentFilter(departmentFilter, departments);
        applyFilters();
    } catch (error) {
        alert('Une erreur est survenue lors du chargement des utilisateurs. Veuillez réessayer plus tard.');
        console.error('Erreur lors du chargement des utilisateurs:', error);
    }
}

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
                    </div>
                    <div id="message_user"></div> <!-- Fenêtre de messagerie -->
                    <div id="chat-messages"></div>
                    <input id="chat-input" type="text" placeholder="Entrez votre message">
                    <button id="send-button">Envoyer</button>
                </div>
            `;
            container.style.display = 'block';

            document.getElementById('send-button').addEventListener('click', () => {
                const messageInput = document.getElementById('chat-input');
                const message = messageInput.value;
                if (message.trim()) {
                    socket.emit('chatMessage', { to: userId, message });
                    messageInput.value = '';
                }
            });

            socket.on('chatMessage', ({ from, message }) => {
                if (from === userId) {
                    const messagesContainer = document.getElementById('chat-messages');
                    const messageElement = document.createElement('div');
                    messageElement.textContent = message;
                    messagesContainer.appendChild(messageElement);
                }
            });
        })
        .catch(error => console.error('Erreur lors du chargement du profil:', error));
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

function updateDepartmentFilter(filterElement, departments) {
    filterElement.innerHTML = '<option value="all">Tous</option>';
    departments.forEach(department => {
        const option = document.createElement('option');
        option.value = department;
        option.textContent = department;
        filterElement.appendChild(option);
    });
}

// Fonction pour appliquer les filtres
function applyFilters() {
    const genderFilter = document.getElementById('gender-filter').value;
    const departmentFilter = document.getElementById('department-filter').value;
    const ageFilter = document.getElementById('age-filter').value;

    const rows = document.querySelectorAll('#users-table tbody tr');

    rows.forEach(row => {
        const genderClass = row.classList.contains('female-row') ? 'female' :
                            row.classList.contains('male-row') ? 'male' : 'other';
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

// Ajout d'écouteurs d'événements pour appliquer les filtres
document.getElementById('gender-filter').addEventListener('change', applyFilters);
document.getElementById('department-filter').addEventListener('change', applyFilters);
document.getElementById('age-filter').addEventListener('change', applyFilters);

// Charge les utilisateurs au chargement de la page
fetchUsers();

// Met à jour les utilisateurs toutes les minutes
setInterval(fetchUsers, 60000); // 60000 ms = 1 minute
