async function fetchUsers() {
    try {
        const response = await fetch('fetch_users.php');
        
        // Vérifie que la réponse est correcte
        if (!response.ok) {
            throw new Error('Erreur réseau : ' + response.status);
        }

       