<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style/profil.css">
</head>
<body class="bg-gray-100 font-sans">
    <!-- Navigation Bar -->
    <nav class="bg-gray-800 text-white p-4 flex items-center justify-between">
        <div class="text-lg font-bold">Tchat Direct</div>
        <!-- Hamburger Menu -->
        <div class="relative">
            <button id="menuButton" class="focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <div id="menuDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10">
            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Mon profil</a>
                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Mes salons</a>
                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Déconnexion</a>
            </div>
        </div>
    </nav>

    <!-- Profile Section -->
    <div class="max-w-md mx-auto mt-6 bg-white shadow-lg rounded-lg p-4">
        <!-- Profile Image and Edit Icon -->
        <div class="flex justify-center relative">
            <img src="img/avatar_default.svg" alt="Avatar" class="avatar_profil">
            <button class="absolute bottom-0 right-10 bg-gray-800 text-white p-1 rounded-full">
                <svg class="w-4 h-4" fill="none" 
                stroke="currentColor" viewBox="0 0 24 24" 
                xmlns="http://www.w3.org/2000/svg">
                
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l4 4m-3.5-4.5L15 9m-2 6a9.77 9.77 0 004.5-.5m-3.5 0h0"></path>
                </svg>
            </button>
        </div>

        <!-- Profile Information -->
        <div class="text-center mt-4">
            <p class="text-gray-800 font-bold text-xl">Pseudo</p>
            <p class="text-gray-500">Vous êtes créateur</p>
            <p class="text-gray-500">0 Jetons</p>
            <textarea name="" id="" cols="30" rows="0" placeholder="test"</textarea>
        </div>

        <!-- Additional Details -->
        <div class="mt-4 text-gray-800">
            <p><span class="font-bold">Âge : </span>32 ans</p>
            <p><span class="font-bold">Localisation : </span>75013 Paris</p>
        </div>

        <!-- Settings Buttons -->
        <div class="mt-6 space-y-3">
            <button class="w-full py-2 bg-red-500 text-white rounded-lg focus:outline-none">Arrêter abonnement</button>
            <button class="w-full py-2 bg-gray-800 text-white rounded-lg focus:outline-none">Mes salons</button>
            <div class="grid grid-cols-2 gap-4">
                <button class="py-2 bg-gray-200 text-gray-800 rounded-lg focus:outline-none">Auth. téléphone : <span class="text-red-500">non</span></button>
                <button class="py-2 bg-gray-200 text-gray-800 rounded-lg focus:outline-none">Auth. mail : <span class="text-red-500">non</span></button>
            </div>
        </div>
    </div>

    <script>
        // Hamburger menu toggle
        const menuButton = document.getElementById('menuButton');
        const menuDropdown = document.getElementById('menuDropdown');

        menuButton.addEventListener('click', () => {
            menuDropdown.classList.toggle('hidden');
        });
    </script>
</body>
</html>
