async function fetchUsers() {
    try {
        const response = await fetch('fetch_users.php');
        if (!response.ok) {
            throw new Error('Erreur réseau : ' + response.status);
        }

        const data = await response.json();

        // Vider le tableau
        const tbody = document.querySelector('#users-table tbody');
        tbody.innerHTML = '';


        const departmentFilter = document.getElementById('department-filter');
        const departments = new Set(); // Utiliser un Set pour éviter les doublons

        // Utilisation d'un fragment de document pour minimiser les reflows/repaints
        const fragment = document.createDocumentFragment();

        data.forEach(user => {
            const row = document.createElement('tr');


            // Ajouter le département à la liste des départements uniques
            departments.add(user.department);

            // Appliquer une classe en fonction du sexe
            const genderClass = user.gender === 'female' ? 'female-row' :
                                user.gender === 'male' ? 'male-row' : 'other-row';
            row.classList.add(genderClass);

            // Colonne Avatar
            const avatarCell = document.createElement('td');
            const avatarImg = document.createElement('img');
            avatarImg.src = user.avatar; // URL de l'avatar
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

            fragment.appendChild(row);
        });


          // Remplir dynamiquement le filtre des départements
          departmentFilter.innerHTML = '<option value="all">Tous les départements</option>'; // Réinitialiser les options
          departments.forEach(department => {
              const option = document.createElement('option');
              option.value = department;
              option.textContent = department;
              departmentFilter.appendChild(option);
          });

             // Appliquer le filtre initialement
             filterUsersByDepartment();


            }
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
    }


         // Appliquer le filtre initialement
         filterUsersByGender();

        

        // Ajouter toutes les lignes en une seule opération DOM
        tbody.appendChild(fragment);
    } catch (error) {
        console.error('Erreur lors du chargement des utilisateurs:', error);
    }
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

// Fonction pour créer un salon
async function createSalon() {
    const salonName = prompt("Entrez le nom de votre salon :");

    if (salonName) {
        try {
            const response = await fetch('create_salon.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `salon_name=${encodeURIComponent(salonName)}`
            });

            const data = await response.json();

            if (data.success) {
                alert("Salon créé avec succès !");
                fetchSalons(); // Rafraîchir la liste des salons
            } else {
                alert("Erreur lors de la création du salon.");
            }
        } catch (error) {
            console.error('Erreur:', error);
        }
    }
}

// Fonction pour récupérer et afficher les salons
async function fetchSalons() {
    try {
        const response = await fetch('fetch_salons.php');
        if (!response.ok) {
            throw new Error('Erreur réseau : ' + response.status);
        }

        const data = await response.json();
        const salonsList = document.getElementById('salons-list');
        salonsList.innerHTML = ''; // Vider la liste des salons

        // Utilisation d'un fragment de document pour minimiser les reflows/repaints
        const fragment = document.createDocumentFragment();

        data.forEach(salon => {
            const salonDiv = document.createElement('a');
            salonDiv.textContent = `${salon.name} (créé par ${salon.creator_username})`;
            salonDiv.href = `salon_chat.php?salon_id=${salon.id}`; // Lien vers la page de chat du salon
            salonDiv.classList.add('salon-link'); // Optionnel : ajout d'une classe pour le styliser
            fragment.appendChild(salonDiv);
        });

        salonsList.appendChild(fragment);
    } catch (error) {
        console.error('Erreur lors du chargement des salons:', error);
    }
}

// Charger les salons au chargement de la page
fetchSalons();
