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
			<input type="hidden" id="username" value="<?php  echo htmlspecialchars($username); ?>">



            <input type="text" id="chat-input" placeholder="Tapez votre message ici...">
            <button id="send-message">Envoyer</button>
        </div>
    </div>









	<div id="chat-window" style="display:none;">
		<div id="chat-messages"></div>
		<input name="message" id="chat-input" type="text" placeholder="Entrez votre message">
		<button id="send-button">Envoyer</button>
	</div>



</div>  <!-- fIN containeur_profil_parent -->

</section>







<!-- Bouton pour créer une div -->
<button id="button_create_div" style="display:none;">Créer mon salon</button>



<div id="container_div_create">
    <!-- Les nouvelles divs seront ajoutées ici -->
</div>


<!-- La div pour afficher le chat -->
<div class="div_chat" id="div_chat" style="display:none;">
    <h3 id="chat-title"></h3> <!-- Affiche le titre de la div -->
    <div id="chat-content"></div> <!-- Affiche le contenu des messages -->
 <!-- Form for sending messages -->
 <form class="form_div_chat" id="form_div_chat" onsubmit="sendMessage(event)">
        <input type="text" id="chat-input" placeholder="Tapez votre message..." required>
        <button type="submit">Envoyer</button>
    </form>
</div>







<!-- Formulaire caché pour entrer le nom de la div -->
<div id="create-div-form" style="display: none;">
    <label for="div-name">Nom du salon :</label>
    <input type="text" id="div-name" placeholder="Nom du salon">
    <button id="submit-div-name">Créer</button>
    <button id="cancel-create-div">Annuler</button>
</div>



<div class="nav_bottom_chat">
	<nav>

		<button><a href="">Salons</a></button>
		<button><a href="">Options</a></button>
		<button>
			<a href="">Connécté</a></button>

	</nav>
</div>






<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
<script src="function/function.js"></script>













<script>
	const $userlistContainer = $('#users-table>tbody');

	var myuser = {};
	myuser = <?php echo json_encode($myuser);?>;
	var users = {};
	var user_private = false;

	const socket = io('https://tchat-direct.com:2053', {query: {user: JSON.stringify(myuser)}});


</script>
<script>

	socket.on('addUser', function (user) {
		addUser(user);
	});

	socket.on('removeUser', function (user) {
		$(`.user[data-userid=${user.id}]`).remove();
		delete users[user.id];
	});


	socket.on('users', function (users) {
		$userlistContainer.empty();
		Object.values(users).forEach(user => {
			addUser(user);
		});
	});


	socket.on('private', function(user, message) {
		//createChat(user, false);
		let $chat = $(`#chat_${user.id} .chat-content`);
		let classe = (user.id === myuser.id) ? 'sent':'received';
		if ($chat.is(":visible")) {
			$chat.append(`<div class="message ${classe}">${message}</div>`);
			$chat.scrollTop($chat[0].scrollHeight);
		} else {
			createChat(user, false);
			let $chat = $(`#chat_${user.id} .chat-content`);
			$chat.append(`<div class="message ${classe}">${message}</div>`);
			$chat.scrollTop($chat[0].scrollHeight);
			addNotification(user);
		}
	});


	$(document).on('click', '.send-btn', (e)=>{
		let input = $(e.currentTarget).parent().find('input');
		if (!input.val()) return;
		socket.emit('private', user_private.username, input.val());
		let $chat = $(`#chat_${user_private.id} .chat-content`);
		$chat.append(`<div class="message sent">${input.val()}</div>`);
		$chat.scrollTop($chat[0].scrollHeight);
		$(input).val('');
	});

	$(document).on('keypress', '.chat-input', function (e) {
		if (e.key === 'Enter' && $(this).val().trim() !== '') {
			let input = $(e.currentTarget).parent().find('input');
			if (!input.val()) return;
			socket.emit('private', user_private.username, input.val());
			let $chat = $(`#chat_${user_private.id} .chat-content`);
			$chat.append(`<div class="message sent">${input.val()}</div>`);
			$chat.scrollTop($chat[0].scrollHeight);
			$(input).val('');
		}
	});

	$userlistContainer.on('click', '.user', function() {
		const id = $(this).data('userid');
		let user = users[id];
		createChat(user);
	});
	$(document).on('click', '.notification', (e)=>{
		$(e.currentTarget).remove();
	   let user_id = $(e.currentTarget).data('userid');
	   let user = users[user_id];
	   createChat(user);
	});

</script>


<script>
    const currentUserId = <?php echo $_SESSION['user_id']; ?>; // ID de l'utilisateur connecté
</script>

</body>
</html>