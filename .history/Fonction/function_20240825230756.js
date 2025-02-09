async function fetchUsers() {
    try {
        const response = await fetch('fetch_users.php');
        
        // Vérifie que la réponse est correcte
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

            // Ajoute le département à la liste des départements uniques
            departments.add(user.department);

            // Applique une classe à la ligne en fonction du sexe
            row.classList.add(user.gender === 'female' ? 'female-row' :
                              user.gender === 'male' ? 'male-row' : 'other-row');

            // Assainissement des données pour éviter les injections XSS
            row.innerHTML = `
                <td><img src="${sanitize(user.avatar)}" alt="${sanitize(user.username)}" class="avatar"></td>
                <td>${sanitize(user.username)}</td>
                <td>${sanitize(user.age)}</td>
                <td>${sanitize(user.department)}</td>
                <td>${sanitize(user.ville_users)}</td>
            `;

            fragment.appendChild(row); // Ajoute la ligne au fragment
        });

        tbody.appendChild(fragment); // Ajoute toutes les lignes en une seule opération DOM

        // Mise à jour des options du filtre département
        updateDepartmentFilter(departmentFilter, departments);

        // Applique les filtres dès le chargement des utilisateurs
        applyFilters();
    } catch (error) {
        // Affiche une alerte visuelle ou message d'erreur à l'utilisateur
        alert('Une erreur est survenue lors du chargement des utilisateurs. Veuillez réessayer plus tard.');
        console.error('Erreur lors du chargement des utilisateurs:', error);
    }
}

function updateDepartmentFilter(filterElement, departments) {
    filterElement.innerHTML = '<option value="all">Tous les départements</option>';
    departments.forEach(department => {
        const option = document.createElement('option');
        option.value = department;
        option.textContent = department;
        filterElement.appendChild(option);
    });
}

const socket = io();

// Enregistrer l'utilisateur lorsqu'il arrive sur la page
const username = 'currentUsername'; // Récupérer le nom d'utilisateur depuis PHP ou session
socket.emit('registerUser', username);

// Détecter la fermeture ou le rechargement de la page
window.addEventListener('beforeunload', () => {
    socket.disconnect(); // Informer le serveur que l'utilisateur quitte la page
});

// Réception de l'événement pour supprimer la ligne associée à l'utilisateur déconnecté
socket.on('removeUserRow', (username) => {
    const rows = document.querySelectorAll('#users-table tbody tr');
    rows.forEach(row => {
        if (row.querySelector('td:nth-child(2)').textContent === username) {
            row.remove(); // Supprimer la ligne correspondante
        }
    });
});




// Connexion au serveur Socket.io

// Gestion de l'envoi de messages
document.getElementById('send-button').addEventListener('click', () => {
    const message = document.getElementById('chat-input').value;
    if (message.trim() !== '') {
        socket.emit('chatMessage', message);
        document.getElementById('chat-input').value = '';
    }
});

// Affichage des messages reçus
socket.on('chatMessage', (msg) => {
    const messageContainer = document.createElement('div');
    messageContainer.textContent = msg;
    document.getElementById('chat-messages').appendChild(messageContainer);
});

// Ouvrir la fenêtre de messagerie lorsqu'on clique sur un utilisateur
document.querySelectorAll('#users-table tr').forEach(row => {
    row.addEventListener('click', () => {
        document.getElementById('chat-window').style.display = 'block';
    });
});





// ettiquette 
function addProfileTag(username) {
    const selectedProfiles = document.getElementById('selected-profiles');

    // Vérifier si l'étiquette existe déjà
    if (!document.getElementById(`profile-tag-${sanitize(username)}`)) {
        const profileTag = document.createElement('div');
        profileTag.id = `profile-tag-${sanitize(username)}`;
        profileTag.classList.add('profile-tag');
        profileTag.textContent = `Profil sélectionné : ${sanitize(username)}`;
        selectedProfiles.appendChild(profileTag);
    }
}

function applyFilters() {
    const genderFilter = document.getElementById('gender-filter').value;
    const departmentFilter = document.getElementById('department-filter').value;
    const rows = document.querySelectorAll('#users-table tbody tr');

    rows.forEach(row => {
        const genderClass = row.classList.contains('female-row') ? 'female' :
                            row.classList.contains('male-row') ? 'male' : 'other';
        const department = row.querySelector('td:nth-child(4)').textContent;

        const genderMatch = (genderFilter === 'all' || genderFilter === genderClass);
        const departmentMatch = (departmentFilter === 'all' || departmentFilter === department);

        row.style.display = (genderMatch && departmentMatch) ? '' : 'none';
    });
}

// Fonction pour assainir les entrées utilisateur
function sanitize(input) {
    const element = document.createElement('div');
    element.textContent = input;
    return element.innerHTML;
}

// Ajout d'écouteurs d'événements pour appliquer les filtres
document.getElementById('gender-filter').addEventListener('change', applyFilters);
document.getElementById('department-filter').addEventListener('change', applyFilters);

// Charge les utilisateurs au chargement de la page
fetchUsers();

// Met à jour les utilisateurs toutes les minutes
setInterval(fetchUsers, 60000); // 60000 ms = 1 minute
