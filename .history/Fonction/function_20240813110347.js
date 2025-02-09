
function fetchUsers() {
    fetch('fetch_users.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#users-table tbody');
            tbody.innerHTML = ''; // Vider le tableau

            data.forEach(user => {
                const row = document.createElement('tr');

                 // Colonne Avatar
                 const avatarCell = document.createElement('td');
                 const avatarImg = document.createElement('img');
                 avatarImg.src = user.avatar; // URL de l'avatar
                 avatarImg.alt = user.username;
                 avatarImg.classList.add('avatar');
                 avatarCell.appendChild(avatarImg);
                 row.appendChild(avatarCell);

                const usernameCell = document.createElement('td');
                usernameCell.textContent = user.username;
                row.appendChild(usernameCell);

                const ageCell = document.createElement('td');
                ageCell.textContent = user.age;
                row.appendChild(ageCell);

                const departmentCell = document.createElement('td');
                departmentCell.textContent = user.department;
                row.appendChild(departmentCell);

                const genderCell = document.createElement('td');
                genderCell.textContent = user.gender === 'male' ? 'Homme' : (user.gender === 'female' ? 'Femme' : 'Autre');
                row.appendChild(genderCell);

                tbody.appendChild(row);
            });
        })
        .catch(error => console.error('Erreur lors du chargement des utilisateurs:', error));
}

// Charger les utilisateurs au chargement de la page
fetchUsers();

// Mettre à jour les utilisateurs toutes les minutes
setInterval(fetchUsers, 60000); // 60000 ms = 1 minute