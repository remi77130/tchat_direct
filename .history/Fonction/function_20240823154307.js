function fetchUsers() {
    fetch('fetch_users.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#users-table tbody');
            tbody.innerHTML = ''; // Vider le tableau



            const departmentFilter = document.getElementById('department-filter');
            const genderFilter = document.getElementById('gender-filter');
            const departments = new Set(); // Utiliser un Set pour éviter les doublons

            data.forEach(user => {
                const row = document.createElement('tr');


                // Ajouter le département à la liste des départements uniques
                departments.add(user.department);

                // Appliquer une classe en fonction du sexe
                if (user.gender === 'female') {
                    row.classList.add('female-row');
                } else if (user.gender === 'male') {
                    row.classList.add('male-row');
                } else {
                    row.classList.add('other-row');
                }

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

                tbody.appendChild(row);
                
            });
 // Remplir dynamiquement le filtre des départements
            departmentFilter.innerHTML = '<option value="all">Tous les départements</option>'; // Réinitialiser les options
            departments.forEach(department => {
                const option = document.createElement('option');
                option.value = department;
                option.textContent = department;
                departmentFilter.appendChild(option);
        


                
            });
  // Appliquer les filtres initialement
  applyFilters();

       

        })
        .catch(error => console.error('Erreur lors du chargement des utilisateurs:', error));
}



function filterUsersByDepartment() {
    const departmentFilter = document.getElementById('department-filter').value;
    const rows = document.querySelectorAll('#users-table tbody tr');

    rows.forEach(row => {
        const department = row.querySelector('td:nth-child(4)').textContent; // Le département est dans la 4ème colonne

        if (departmentFilter === 'all' || departmentFilter === department) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });


             // Appliquer le filtre initialement
             filterUsersByDepartment();
}

function filterUsersByGender() {
    const genderFilter = document.getElementById('gender-filter').value;
    const rows = document.querySelectorAll('#users-table tbody tr');

    rows.forEach(row => {
        const genderClass = row.classList.contains('female-row') ? 'female' :
                            row.classList.contains('male-row') ? 'male' : 'other';

        if (genderFilter === 'all' || genderFilter === genderClass) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });


                
            // Appliquer le filtre initialement
            filterUsersByGender();
}


// Charger les utilisateurs au chargement de la page
fetchUsers();

// Mettre à jour les utilisateurs toutes les minutes
setInterval(fetchUsers, 60000); // 60000 ms = 1 minute
