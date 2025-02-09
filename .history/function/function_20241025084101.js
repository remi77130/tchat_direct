// CHAT.PHP



// Fonction pour afficher la div de profil
function showProfileContainer(userId) {
	fetch(`get_user_info.php?user_id=${userId}`)
		.then(response => response.json())
		.then(data => {
			if (data.error) {
				alert(data.error);
				return;
			}

			const container = document.getElementById('container_profil');
			container.innerHTML = `
                <div class="profile-content">
                    <button class="close-btn" onclick="closeProfileContainer()">Fermer</button>
                    <div>
                        <img src="${sanitize(data.avatar)}" alt="${sanitize(data.username)}" class="avatar">
                        <h3>${sanitize(data.username)}</h3>  
						 <h3>${sanitize(data.department)}</h3>
                    </div>

                    
                    <div id="message_user">
                    
                    
                    
                    </div> <!-- Fenêtre de messagerie -->
                    <div id="chat-messages"></div>
                    <input id="chat-input" type="text" placeholder="Entrez votre message">
                    <button id="send-button">Envoyer</button>
                </div>
            `;
			container.style.display = 'block';

			document.getElementById('send-button').addEventListener('click', () => {
				const messageInput = document.getElementById('chat-input');
				const fileInput = document.querySelector('.chat-file-input');
				const message = messageInput.value;
				const file = fileInput.files[0];

				  // Si un fichier est sélectionné
				  if (file) {
					const reader = new FileReader();
					reader.onload = function(event) {
						const imageData = event.target.result;
						socket.emit('chatImage', { to: user.id, image: imageData, fileName: file.name });
					};
					reader.readAsDataURL(file);
				}
			

				if (message.trim()) {
					socket.emit('chatMessage', {to: userId, message});
					messageInput.value = '';
				}

				   // Réinitialisation du champ de fichier
				   fileInput.value = '';
			});

			socket.on('chatMessage', ({from, message}) => {
				if (from === userId) {
					const messagesContainer = document.getElementById('chat-messages');
					const messageElement = document.createElement('div');
					messageElement.textContent = message;
					messagesContainer.appendChild(messageElement);
				}
			});



			// Ajoutez la gestion de la réception des images
			//socket.on('chatImage', ({ from, image, fileName }) => {
				//const messagesContainer = document.querySelector('.chat-content');
			//	const imageElement = document.createElement('img');
			//	imageElement.src = image;  // Base64 data
			//	imageElement.alt = fileName;
			//	imageElement.classList.add('chat-image');  // Ajout de classe pour styliser l'image
			//	messagesContainer.appendChild(imageElement);
			//});
		})






		.catch(error => console.error('Erreur lors du chargement du profil:', error));
}


function closeProfileContainer() {
	document.getElementById('container_profil').style.display = 'none';
}

// Fonction pour assainir les entrées utilisateur
function sanitize(input) {
	const element = document.createElement('div');
	element.textContent = input;
	return element.innerHTML;
}



// Fonction pour appliquer les filtres
function applyFilters() {
	const genderFilter = document.getElementById('gender-filter').value;
	const departmentFilter = document.getElementById('department-filter').value;
	const ageFilter = document.getElementById('age-filter').value;
	const rows = document.querySelectorAll('#users-table tbody tr');

	rows.forEach(row => {
		const genderClass = row.classList.contains('female-row') ? 'female' : row.classList.contains('male-row') ? 'male' : 'other';
		const department = row.querySelector('td:nth-child(4)').textContent;
		const age = parseInt(row.querySelector('td:nth-child(3)').textContent);

		const genderMatch = (genderFilter === 'all' || genderFilter === genderClass);
		const departmentMatch = (departmentFilter === 'all' || departmentFilter === department);

		let ageMatch = true;
		if (ageFilter === '-30') {
			ageMatch = age < 30;
		} else if (ageFilter === '30-40') {
			ageMatch = age >= 30 && age <= 40;
		} else if (ageFilter === '45+') {
			ageMatch = age > 45;
		}

		row.style.display = (genderMatch && departmentMatch && ageMatch) ? '' : 'none';
	});
}

// Ajout d'écouteurs d'événements pour appliquer les filtres
document.getElementById('gender-filter').addEventListener('change', applyFilters);
document.getElementById('department-filter').addEventListener('change', applyFilters);
document.getElementById('age-filter').addEventListener('change', applyFilters);





// CHAT.PHP


	function createChat(user, display = true) {
			let id = `chat_${user.id}`;
			user_private = user;
			$chat = $(`#${id}`);
			$('.modal').hide();

			if (!$chat.length) {
				let template = `
				<div id="${id}" class="modal">
					<div class="chat-popup">

						<div class="chat-header">

							<div> <img src="${user.avatar}" alt="Avatar" class="avatar64"> </div>
							<div class="username">${user.username}</div>
							<div class="userage">${user.age} ans</div>
							<div class="userdpt">${user.dep}</div>
							<div class="userville">${user.ville}</div>
						</div>

						<div class="chat-content"></div>
						<div class="chat-footer">
							<input type="text" class="chat-input" placeholder="Tapez votre message...">
							
							<button class="send-btn">Envoyer</button>
						</div>
					</div>
					<button class="close-btn" onclick="closeModal()">Fermer</button>
				</div>`;
				$('body').append(template);
			}
			if (display) {
				document.getElementById(`${id}`).style.display = 'flex';
			}
	}

	function closeModal() {
		user_private = false;
		$('.modal').hide();
	}

	function addUser(user) {  // Tableau des users sur chat.php on chercher l'info avec data
		users[user.id] = user;
		let class_user = (user.gender==='female') ? 'female-row': 'male-row';
		$userlistContainer.append(`

			
			<tr class="user ${class_user}" data-userid="${user.id}" data-username="${user.username}" 
			data-avatar="${user.avatar}" data-age="${user.age}" data-ville="${user.ville}" 
			data-dep="${user.dep}  data-gender="${user.gender}">

				<td><img class="avatar16" src="${user.avatar}" alt="${user.username}"></td>
				<td><div><b>${user.username}</b></div></td>
				<td><div>${user.age}</div></td>
				<td><div>${user.dep}</div></td>
				<td><div>${user.ville}</div></td>
			</tr>`);
		addDepartement(user.dep);
	}

	function addDepartement(dep) {
		// Select the #department-filter element
		let $departmentFilter = $('#department-filter');

		// Check if an option with the value 'dep' already exists
		if ($departmentFilter.find(`option[value='${dep}']`).length === 0) {
			// If not, create a new option element
			let newOption = $('<option></option>')
				.attr('value', dep) // Set the value attribute
				.text(dep); // Set the text of the option

			// Append the new option to the select element
			$departmentFilter.append(newOption);
		}
	}

	function addNotification(user) {
		$notications = $('#selected-profiles');
		if(!$notications.find(`div[data-userid=${user.id}]`).length) {
			$notications.append(`<div class="notification" data-userid="${user.id}" data-username="${user.username}">${user.username}</div>`);
		}
	}





// Voici le code pour gérer l'ouverture du formulaire, 
// la soumission du nom de la div, et la création de la div dans le conteneur container_div_create.




	document.getElementById('button_create_div').addEventListener('click', function() {
		// Afficher le formulaire pour entrer le nom de la div
		document.getElementById('create-div-form').style.display = 'block';
	});
	
	document.getElementById('submit-div-name').addEventListener('click', function() {
		const divName = document.getElementById('div-name').value.trim();
	
		if (divName === "") {
			alert("Veuillez entrer un nom pour la div.");
			return;
		}
		

 			// Envoyer les informations de la div au serveur pour enregistrement
 			fetch('save_div.php', {
			method: 'POST',
			headers: {
			'Content-Type': 'application/json'
			},
			body: JSON.stringify({ div_name: divName }) // Envoi uniquement le nom de la div
			})


		
	
		// Créer une nouvelle div avec le nom donné
		const newDiv = document.createElement('div');
		newDiv.classList.add('created-div');
		newDiv.innerHTML = `<h3>${divName}</h3>`;
		
		// Ajouter la nouvelle div au conteneur
		document.getElementById('container_div_create').appendChild(newDiv);
		
		// Cacher le formulaire et réinitialiser le champ
		document.getElementById('create-div-form').style.display = 'none';
		document.getElementById('div-name').value = '';
	});
	
	document.getElementById('cancel-create-div').addEventListener('click', function() {
		// Cacher le formulaire sans rien faire
		document.getElementById('create-div-form').style.display = 'none';
		document.getElementById('div-name').value = '';
	});
	


	// Fonction pour récupérer les divs depuis la base de données
function fetchDivs() {
    fetch('get_user_divs.php') // Requête pour récupérer les divs
        .then(response => response.json()) // Traiter la réponse en JSON
        .then(data => {
            if (data.success) {
                // Vider le conteneur avant d'ajouter les nouvelles divs
                const container = document.getElementById('container_div_create');
                container.innerHTML = ''; 

                // Ajouter chaque div récupérée
                data.divs.forEach(div => {
                    const newDiv = document.createElement('div');
                    newDiv.classList.add('created-div');
					
                    newDiv.innerHTML = `<h3>${div.div_name}</h3>`;
                    container.appendChild(newDiv);



					// Ajouter un événement de clic à la div pour afficher la div_chat
                    newDiv.addEventListener('click', () => {
                        openChatDiv(newDiv.textContent); // Appeler une fonction pour ouvrir div_chat avec le titre
                    });


					


// Fonction pour ouvrir la div_chat et y afficher le titre
function openChatDiv(title) {
    const chatDiv = document.getElementById('div_chat'); // Assurez-vous que cette div existe dans votre HTML
	const chatTitle = document.getElementById('chat-title');
    const chatContent = document.getElementById('chat-content');




    if (chatDiv) {
        // Remplir la div_chat avec le titre
        chatDiv.innerHTML = `<h3>${title}</h3>`;
		chatDiv.style.display = 'block';

		
    } 
	
	
	else 
	
	{
        console.error('div_chat non trouvée');
    }

}          


// Fonction pour envoyer le message depuis le formulaire
function sendMessage(event) {
    event.preventDefault(); // Empêche le rechargement de la page lors de la soumission du formulaire

    const chatInput = document.getElementById('chat-input');
    const chatContent = document.getElementById('chat-content');
    const message = chatInput.value.trim();  // Get the message

    if (message) {
        // Afficher le message dans la div_chat
        const messageElement = document.createElement('div');
        messageElement.textContent = message;
        chatContent.appendChild(messageElement);
        
        // Sauvegarder le message dans la base de données via une requête API
        fetch('save_chat_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ div_name: document.getElementById('chat-title').textContent, message })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Erreur lors de l\'enregistrement du message.');
            }
        })
        .catch(error => console.error('Erreur lors de l\'enregistrement du message:', error));

        chatInput.value = '';  // Clear the input field
    }
}



});
            } else {
                alert('Erreur lors de la récupération des divs.');
            }
        })
        .catch(error => console.error('Erreur lors de la récupération des divs:', error));
}

// Appeler cette fonction au chargement de la page pour afficher les divs
window.addEventListener('load', fetchDivs);





/////                  PAGE CHAT.PHP


 // DIV RENCONTRE

// Fonction pour ouvrir ou fermer la div "rencontre"
function toggleRencontre() {
    const rencontreDiv = document.getElementById('rencontre');
    if (rencontreDiv.style.display === 'none' || rencontreDiv.style.display === '') {
        rencontreDiv.style.display = 'block';
    } else {
        rencontreDiv.style.display = 'none';
    }
}

// Fonction pour envoyer des messages dans la div "rencontre"
document.getElementById('send-message').addEventListener('click', function () {
    const chatInput = document.getElementById('chat-input');
    const chatContent = document.getElementById('chat-content');
	const username = document.getElementById('username').value; // On demande d'affiché le pseudo (la value du input :username)

    const message = chatInput.value.trim();

    if (message) {
        // Créer un nouvel élément pour afficher le message
        const messageElement = document.createElement('p');
        messageElement.textContent = message;
		echo htmlspecialchars($username);
        chatContent.appendChild(messageElement);

        // Nettoyer le champ de saisie
        chatInput.value = '';
    }
});

