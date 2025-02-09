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

                // Colonne Sexe
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







// Fonction pour créer un salon
function createSalon() {
    const salonName = prompt("Entrez le nom de votre salon :");

    if (salonName) {
        fetch('create_salon.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `salon_name=${encodeURIComponent(salonName)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Salon créé avec succès !");
                fetchSalons(); // Rafraîchir la liste des salons
            } else {
                alert("Erreur lors de la création du salon.");
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
}

// Fonction pour récupérer et afficher les salons
salons.forEach(salon => {
    // Vérifie que salon.id est bien défini
    if (salon.id && salon.name && salon.creator_username) {

        
        const salonDiv = document.createElement('a');
        salonDiv.href = "salon_chat.php?salon_id=" + encodeURIComponent (salon.id); // Utilisation de salon.id
        salonDiv.textContent = salon.name + " (créé par " + salon.creator_username + ")";
        salonDiv.classList.add('salon-link');
        salonsList.appendChild(salonDiv);
    } else {
        console.error("Données du salon manquantes ou incorrectes", salon);
    }
});
// Charger les salons au chargement de la page
fetchSalons();



console.log(salon); // Pour vérifier la structure des données du salon









