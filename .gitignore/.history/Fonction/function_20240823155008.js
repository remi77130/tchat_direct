// Fonction pour récupérer les utilisateurs depuis fetch_users.php
function fetchUsers() {
    fetch('fetch_users.php')
        .then(response => response.json())  // Convertit la réponse en JSON
        .then(data => {
            const tbody = document.querySelector('#users-table tbody');
            tbody.innerHTML = ''; // Vide le tableau avant de le remplir

            const departmentFilter = document.getElementById('department-filter');
            const departments = new Set(); // Utilise un Set pour stocker les départements uniques (évite les doublons)

            // Parcours des utilisateurs récupérés
            data.forEach(user => {
                const row = document.createElement('tr');

                // Ajoute le département à la liste des départements uniques
                departments.add(user.department);

                // Applique une classe à la ligne en fonction du sexe
                if (user.gender === 'female') {
                    row.classList.add('female-row'); // Applique la classe "female-row" si l'utilisateur est une femme
                } else if (user.gender === 'male') {
                    row.classList.add('male-row'); // Applique la classe "male-row" si l'utilisateur est un homme
                } else {
                    row.classList.add('other-row'); // Applique la classe "other-row" si l'utilisateur est autre
                }

                // Création des cellules du tableau pour chaque information de l'utilisateur

                // Colonne Avatar
                const avatarCell = document.createElement('td');
                const avatarImg = document.createElement('img');
                avatarImg.src = user.avatar;
                avatarImg.alt = user.username;
                avatarImg.classList.add('avatar');
                avatarCell.appendChild(avatarImg);
                row.appendChild(avatarCell);

                // Colonne Pseudo
                const usernameCell = document.createElement('td');
                usernameCell.textContent = user.username;
                row.appendChild(usernameCell);

                // Colonne Âge
                const ageCell = document.createElement('td');
                ageCell.textContent = user.age;
                row.appendChild(ageCell);

                // Colonne Département
                const departmentCell = document.createElement('td');
                departmentCell.textContent = user.department;
                row.appendChild(departmentCell);

                // Colonne Ville
                const villeCell = document.createElement('td');
                villeCell.textContent = user.ville_users;
                row.appendChild(villeCell);

                // Ajoute la ligne au tableau
                tbody.appendChild(row);
            });

            // Remplit dynamiquement le filtre des départements avec les options uniques
            departmentFilter.innerHTML = '<option value="all">Tous les départements</option>'; // Réinitialise les options du filtre
            departments.forEach(department => {
                const option = document.createElement('option');
                option.value = department;
                option.textContent = department;
                departmentFilter.appendChild(option); // Ajoute chaque département unique en tant qu'option
            });

            // Applique les filtres dès le chargement des utilisateurs
            applyFilters();
        })
        .catch(error => console.error('Erreur lors du chargement des utilisateurs:', error)); // Gère les erreurs de la requête
}

// Fonction pour appliquer les filtres de sexe et de département
function applyFilters() {
    const genderFilter = document.getElementById('gender-filter').value;
    const departmentFilter = document.getElementById('department-filter').value;
    const rows = document.querySelectorAll('#users-table tbody tr');

    // Parcours de chaque ligne du tableau pour appliquer les filtres
    rows.forEach(row => {
        const genderClass = row.classList.contains('female-row') ? 'female' :
                            row.classList.contains('male-row') ? 'male' : 'other'; // Détermine le sexe de l'utilisateur en fonction de la classe CSS
        const department = row.querySelector('td:nth-child(4)').textContent; // Récupère le département de la 4ème colonne

        // Vérifie si la ligne correspond aux filtres appliqués
        const genderMatch = (genderFilter === 'all' || genderFilter === genderClass);
        const departmentMatch = (departmentFilter === 'all' || departmentFilter === department);

        // Affiche ou masque la ligne en fonction des filtres
        if (genderMatch && departmentMatch) {
            row.style.display = ''; // Affiche la ligne si elle correspond aux filtres
        } else {
            row.style.display = 'none'; // Masque la ligne si elle ne correspond pas aux filtres
        }
    });
}

// Ajoute des écouteurs d'événements pour appliquer les filtres lorsque les sélections changent
document.getElementById('gender-filter').addEventListener('change', applyFilters);
document.getElementById('department-filter').addEventListener('change', applyFilters);

// Charge les utilisateurs au chargement de la page
fetchUsers();

// Met à jour les utilisateurs toutes les minutes
setInterval(fetchUsers, 60000); // 60000 ms = 1 minute
