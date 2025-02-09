<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Création de Salon</title>
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
            background-color: rgba(0, 0, 0, 0.5); /* Fond sombre semi-transparent */
            justify-content: center;
            align-items: center;
        }

        /* Contenu du modal */
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            text-align: center;
            position: relative;
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

        /* Champ de saisie */
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Bouton principal */
        button {
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Bouton pour ouvrir le modal -->
    <button id="openModal">Créer un salon</button>

    <!-- Le modal -->
    <div class="modal" id="myModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">&times;</button>
            <h3>Tu peux créer ton propre salon</h3>
            <p>Ton salon restera actif tant que tu es premium. Tu peux le supprimer via le menu sur ton profil.</p>
            <input type="text" placeholder="Nom du salon" id="salonName">
            <a href="description_room.php">Créer</a>
        </div>
    </div>

    <script>
        // Sélectionner les éléments nécessaires
        const modal = document.getElementById("myModal");
        const openModal = document.getElementById("openModal");
        const closeModal = document.getElementById("closeModal");

        // Ouvrir le modal
        openModal.addEventListener("click", () => {
            modal.style.display = "flex"; // Afficher le modal en flexbox
        });

        // Fermer le modal en cliquant sur le bouton "x"
        closeModal.addEventListener("click", () => {
            modal.style.display = "none";
        });

        // Fermer le modal en cliquant en dehors du contenu
        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });

   
    </script>
</body>
</html>
