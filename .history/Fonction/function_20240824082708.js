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
        const departments = new Set(); // Utilise un Set pour les départements uniques

        const fragment = document.createDocumentFragment(); // Fragment pour réduire les reflows/repaints

        data.forEach(user => {
            const row = document.createElement('tr');

            // Ajoute le département à la liste des départements uniques
            departments.add(user.department);

            // Applique une classe à la ligne en fonction du sexe
            row.classList.add(user.gender === 'female' ? 'female-row' :
                              user.gender === 'male' ? 'male-row' : 'other-row');

            // Création des cellules du tableau pour chaque information de l'utilisateur
            row.innerHTML = `
                <td><img src="${user.avatar}" alt="${user.username}" class="avatar"></td>
                <td>${user.username}</td>
                <td>${user.age}</td>
                <td>${user.department}</td>
                <td>${user.ville_users}</td>
            `;

            fragment.appendChild(row); // Ajoute la ligne au fragment
        });

        tbody.appendChild(fragment); // Ajoute toutes les lignes en une seule opération DOM

        // Mise à jour des options du filtre département
        updateDepartmentFilter(departmentFilter, departments);

        // Applique les filtres dès le chargement des utilisateurs
        applyFilters();
    } catch (error) {
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

// Fonction pour appliquer les filtres de sexe et de département
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

// Ajout d'écouteurs d'événements pour appliquer les filtres
document.getElementById('gender-filter').addEventListener('change', applyFilters);
document.getElementById('department-filter').addEventListener('change', applyFilters);

// Charge les utilisateurs au chargement de la page
fetchUsers();

// Met à jour les utilisateurs toutes les minutes
setInterval(fetchUsers, 60000); // 60000 ms = 1 minute


// Ouvrir la fenêtre de messagerie lorsqu'on clique sur un utilisateur
document.querySelectorAll('#users-table').forEach(row => {
    row.addEventListener('click', () => {
        document.getElementById('chat-window').style.display = 'block';
    });
});