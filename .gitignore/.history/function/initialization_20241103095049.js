// Initialisation des constantes et des variables globales
const $userlistContainer = $('#users-table>tbody');



var users = {};
var user_private = false;

// Initialisation du socket avec les informations de l'utilisateur
const socket = io('https://tchat-direct.com:2053', { query: { user: JSON.stringify(myuser) } });

// Les événements et la logique de gestion des utilisateurs et du chat suivent...