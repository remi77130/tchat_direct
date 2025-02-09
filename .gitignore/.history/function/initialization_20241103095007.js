// Initialisation des constantes et des variables globales
const $userlistContainer = $('#users-table>tbody');

// Récupération des données utilisateur passées depuis PHP
var myuser = {};
myuser = <?php echo json_encode($myuser); ?>;

var users = {};
var user_private = false;

// Initialisation du socket avec les informations de l'utilisateur
const socket = io('https://tchat-direct.com:2053', { query: { user: JSON.stringify(myuser) } });

// Les événements et la logique de gestion des utilisateurs et du chat suivent...