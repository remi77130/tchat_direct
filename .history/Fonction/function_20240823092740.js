function fetchUsers() {
    fetch('fetch_users.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#users-table tbody');
            tbody.innerHTML = ''; // Vider le tableau

            data.forEach(user => {
                const row = document.createElement('tr');

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

            // Appliquer le filtre initialement
            filterUsersByGender();
        })
        .catch(error => console.error('Erreur lors du chargement des utilisateurs:', error));
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
}

// Charger les utilisateurs au chargement de la page
fetchUsers();

// Mettre à jour les utilisateurs toutes les minutes
setInterval(fetchUsers, 60000); // 60000 ms = 1 minute
