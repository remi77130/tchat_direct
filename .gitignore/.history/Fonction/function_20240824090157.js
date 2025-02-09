function fetchUsers() {
    fetch('fetch_users.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#users-table tbody');
            tbody.innerHTML = ''; // Vider le tableau avant de le remplir

            const departmentFilter = document.getElementById('department-filter');
            const departments = new Set(); // Utiliser un Set pour stocker les départements uniques (évite les doublons)

            data.forEach(user => {
                const row = document.createElement('tr');

                // Ajouter le département à la liste des départements uniques
                departments.add(user.department);

                // Appliquer une classe à la ligne en fonction du sexe
                if (user.gender === 'female') {
                    row.classList.add('female-row');
                } else if (user.gender === 'male') {
                    row.classList.add('male-row');
                } else {
                    row.classList.add('other-row');
                }

                // Ajout des données du profil dans les cellules du tableau
                row.innerHTML = `
                    <td><img src="${user.avatar}" alt="${user.username}" class="avatar"></td>
                    <td>${user.username}</td>
                    <td>${user.age}</td>
                    <td>${user.department}</td>
                    <td>${user.ville_users}</td>
                `;

                // Gestionnaire de clic sur la ligne pour afficher le profil sélectionné
                row.addEventListener('click', () => {
                    addProfileTag(user.username);
                });

                // Ajoute la ligne au tableau
                tbody.appendChild(row);
            });

            // Remplir dynamiquement le filtre des départements avec les options uniques
            departmentFilter.innerHTML = '<option value="all">Tous les départements</option>'; // Réinitialiser les options du filtre
            departments.forEach(department => {
                const option = document.createElement('option');
                option.value = department;
                option.textContent = department;
                departmentFilter.appendChild(option);
            });

            // Appliquer les filtres dès le chargement des utilisateurs
            applyFilters();
        })
        .catch(error => console.error('Erreur lors du chargement des utilisateurs:', error)); // Gérer les erreurs de la requête
}

// Fonction pour ajouter une étiquette de profil sélectionné sous filter_chat
function addProfileTag(username) {
    const selectedProfiles = document.getElementById('selected-profiles');

    // Vérifier si l'étiquette existe déjà
    if (!document.getElementById(`profile-tag-${username}`)) {
        const profileTag = document.createElement('div');
        profileTag.id = `profile-tag-${username}`;
        profileTag.classList.add('profile-tag');
        profileTag.textContent = `Profil sélectionné : ${username}`;
        selectedProfiles.appendChild(profileTag);
    }
}

// Appliquer les filtres lors des changements de sélection
document.getElementById('gender-filter').addEventListener('change', applyFilters);
document.getElementById('department-filter').addEventListener('change', applyFilters);

// Charger les utilisateurs au chargement de la page
fetchUsers();

// Mettre à jour les utilisateurs toutes les minutes
setInterval(fetchUsers, 60000); // 60000 ms = 1 minute
