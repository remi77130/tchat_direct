<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal avec Effets</title>
    <style>
        /* Style général du modal */
        .modal {
            display: none; /* Par défaut, le modal est masqué */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Fond sombre semi-transparent */
            justify-content: center;
            align-items: center;
            opacity: 0; /* Pour l'effet de fade-in */
            transition: opacity 0.5s ease; /* Animation de l'opacité */
        }

        /* Lorsque le modal est affiché */
        .modal.show {
            display: flex; /* Affiche le modal en flexbox */
            opacity: 1; /* Augmente l'opacité pour l'effet */
        }

        /* Contenu du modal */
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
            text-align: center;
            position: relative;
            transform: scale(0.8); /* Départ plus petit */
            animation: zoomIn 0.5s ease forwards; /* Effet de zoom */
        }

        /* Effet de zoom progressif */
        @keyframes zoomIn {
            from {
                transform: scale(0.8);
            }
            to {
                transform: scale(1);
            }
        }

        /* Bouton de fermeture */
        .modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 16px;
            cursor: pointer;
        }

        .modal-close:hover {
            background-color: #ff4d4d;
        }

        /* Champ de saisie */
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Bouton principal */
        button {
            padding: 10px 20px;
            margin-top: 10px;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        button:hover {
            background: linear-gradient(45deg, #2575fc, #6a11cb);
        }
    </style>
</head>
<body>
    <!-- Bouton pour ouvrir le modal -->
    <button id="openModal" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Créer un salon</button>

    <!-- Le modal -->
    <div class="modal" id="myModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">&times;</button>
            <h3 style="color: #6a11cb;">Créer ton propre salon</h3>
            <p style="color: #444;">Ton salon restera actif tant que tu es premium. Tu peux le supprimer via le menu sur ton profil.</p>
            <input type="text" placeholder="Nom du salon" id="salonName">
            <button id="submitSalon">Créer</button>
        </div>
    </div>

    <script>
        // Sélection des éléments
        const modal = document.getElementById("myModal");
        const openModal = document.getElementById("openModal");
        const closeModal = document.getElementById("closeModal");
        const submitSalon = document.getElementById("submitSalon");

        // Ouvrir le modal avec effet
        openModal.addEventListener("click", () => {
            modal.classList.add("show"); // Ajouter la classe pour afficher le modal
        });

        // Fermer le modal en cliquant sur le bouton "x"
        closeModal.addEventListener("click", () => {
            modal.classList.remove("show"); // Retirer la classe pour cacher le modal
        });

        // Fermer le modal en cliquant en dehors du contenu
        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                modal.classList.remove("show");
            }
        });

        // Gérer le clic sur le bouton "Créer"
        submitSalon.addEventListener("click", () => {
            const salonName = document.getElementById("salonName").value;
            if (salonName.trim() !== "") {
                alert(`Salon "${salonName}" créé avec succès !`);
                modal.classList.remove("show"); // Fermer le modal après la création
            } else {
                alert("Veuillez entrer un nom pour le salon.");
            }
        });
    </script>
</body>
</html>
