<?php
// Démarrer la session de façon sécurisée
session_start();

// Rediriger si la session utilisateur n'est pas définie
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

// Assainir les données de la session
$myuser = htmlspecialchars(json_encode($_SESSION['user']), ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<!-- Nous allons créer une page HTML qui contient un tableau pour
 afficher les utilisateurs récupérés par l'API. Ce tableau sera mis à jour 
 automatiquement toutes les minutes grâce à AJAX. -->
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Liste des Utilisateurs</title>
	<link rel="stylesheet" href="style/salon.css">
	<link href="https://fonts.googleapis.com/css2?family=Playwrite+GB+S:ital,wght@0,100..400;1,100..400&display=swap" rel="stylesheet">

	<link rel="icon" type="image/png" href="img/favicon_2.png" />


</head>
<body>


<section>





<div class="container_profile_parent">




	<h2>Utilisateurs en lignes </h2>

	<p class="text_presentation_live">Bienvenue ! ici, c'est un salon en live server, ce qui signifie qu'il n'y a que des membres actifs. <br>
	   Tu peux discuter en toute tranquillité, nous ne sauvegardons aucune information.
	</p>

	<!-- Conteneur pour le profil sélectionné -->

	<div class="container_profil" id="container_profil" style="display:none;">
	</div>


	 <!-- Filtres pour les utilisateurs -->
	 <div class="filter_chat">
            <label for="gender-filter">Genre :</label>
            <select id="gender-filter" onchange="applyFilters()">
                <option value="all">Tous</option>
                <option value="male">Homme</option>
                <option value="female">Femme</option>
            </select>
		<!-- Ajout du Sélecteur de Filtre pour le Département -->
		<label for="department-filter">Dpt :</label>
		<select id="department-filter" onchange="applyFilters()">
			<option value="all">Tous</option>
			<!-- Les options seront remplies dynamiquement -->
		</select>


		<!-- Ajout du Sélecteur de Filtre pour l'Âge -->
		<label for="age-filter">Âge :</label>
		<select id="age-filter" onchange="applyFilters()">
			<option value="all">Tous</option>
			<option value="-30">Moins de 30 ans</option>
			<option value="30-40">30 à 40 ans</option>
			<option value="45+">Plus de 45 ans</option>
		</select>


	</div>


	<!-- Conteneur pour les étiquettes des profils sélectionnés -->
	<div classe="conteneur_selected_profil" id="selected-profiles"></div>


	<div class="containeur_profil">


		<div class="container_users-table">
			<table id="users-table">
				<thead>
				<tr>
					<th>Avatar</th>
					<th>Pseudo</th>
					<th>Âge</th>
					<th>Dpt</th>
					<th>Ville</th>
				</tr>
				</thead>
				<tbody>
				<!-- Les utilisateurs seront insérés ici par JavaScript -->
				</tbody>

			</table>

		</DIV>


	</div>  <!-- FIN CONTAINER 8PROFIL8 PARENT -->


	
	<div id="chat-window" style="display:none;">
		<div id="chat-messages"></div>
		<input name="message" id="chat-input" type="text" placeholder="Entrez votre message">
	
		<button id="send-button">Envoyer</button>
	</div>



</div>  <!-- fIN containeur_profil_parent -->

</section>








<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
<script>
// Récupération des données utilisateur depuis PHP
const myuser = <?php echo $myuser; ?>;

// Initialisation du socket
const socket = io('https://tchat-direct.com:2053', { query: { user: JSON.stringify(myuser) } });

// Gestion des événements socket
socket.on('connect', () => {
    console.log('Connecté au serveur socket.io');
});

socket.on('user-list', (data) => {
    updateUsersTable(data);
});

// Mise à jour du tableau des utilisateurs
function updateUsersTable(users) {
    const tbody = document.querySelector('#users-table tbody');
    tbody.innerHTML = '';
    users.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><img src="${user.avatar}" alt="Avatar" class="user-avatar"></td>
            <td>${user.pseudo}</td>
            <td>${user.age}</td>
            <td>${user.department}</td>
            <td>${user.city}</td>
        `;
        tbody.appendChild(row);
    });
}

// Appliquer les filtres
function applyFilters() {
    const gender = document.getElementById('gender-filter').value;
    const department = document.getElementById('department-filter').value;
    const age = document.getElementById('age-filter').value;

    socket.emit('apply-filters', { gender, department, age });
}
</script>

</body>
</html>