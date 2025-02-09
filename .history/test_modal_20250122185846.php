<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemple de Modal</title>
    <style>
        /* Style pour masquer le modal par défaut */
        .modal {
            display: none; /* Masqué par défaut */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5); /* Couleur de fond transparent */
        }

        /* Contenu du modal */
        .modal-content {
            background-color: #fff;
            margin: 15% auto; /* Centré verticalement */
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Largeur du modal */
            text-align: center;
        }

        /* Bouton de fermeture */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Bouton pour ouvrir le modal -->
    <button id="openModalBtn">Ouvrir le Modal</button>

    <!-- Le modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Bonjour, je suis un Modal !</h2>
            <p>Ceci est un contenu dans une fenêtre modale.</p>
        </div>
    </div>

    <script>
        // Récupération des éléments HTML
        const modal = document.getElementById("myModal");
        const openModalBtn = document.getElementById("openModalBtn");
        const closeModal = document.getElementById("closeModal");

        // Ouvrir le modal
        openModalBtn.addEventListener("click", () => {
            modal.style.display = "block";
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
