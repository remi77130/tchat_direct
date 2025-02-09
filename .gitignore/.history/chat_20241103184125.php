<?php session_start();
$myuser = $_SESSION['user'];
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


	<div class="filter_chat">
		<!-- Ajout du Sélecteur de Filtre -->
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






	<div id="rencontre-container">
        <h3 onclick="toggleRencontre()">Rencontre Paris</h3>
        <div id="rencontre">
            <div id="chat-content"></div>
            <input type="hidden" id="username" value="<?php echo htmlspecialchars($username); ?>">


            <input type="text" id="chat-input" placeholder="Tapez votre message ici...">
            <button id="send-message">Envoyer</button>
        </div>
    </div>









	<div id="chat-window" style="display:none;">
		<div id="chat-messages"></div>
		<input name="message" id="chat-input" type="text" placeholder="Entrez votre message">
	
		<button id="send-button">Envoyer</button>
	</div>
    <input type="hidden" value=<?= htmlspecialchars(json_encode($myuser)); ?> id="user-data">


</div>  <!-- fIN containeur_profil_parent -->

</section>








<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
<script src="function/function.js"></script>
<script>
// Initialisation des constantes et des variables globales
const $userlistContainer = $('#users-table>tbody');

// Récupération des données utilisateur passées depuis PHP
var myuser = document.getElementById('user-data');

var users = {};
var user_private = false;

// Initialisation du socket avec les informations de l'utilisateur
const socket = io('https://tchat-direct.com:2053', { query: { user: JSON.stringify(myuser) } });

// Les événements et la logique de gestion des utilisateurs et du chat suivent...
</script>
<script src="function/function_chat.js"></script>

</body>
</html>