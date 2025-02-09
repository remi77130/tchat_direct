<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magasin d'Icônes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        header {
            width: 100%;
            padding: 10px 20px;
            background-color: #6200ea;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
        }
        .user-profile .user-info {
            display: flex;
            flex-direction: column;
            font-size: 14px;
        }
        .user-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .user-actions svg {
            width: 24px;
            height: 24px;
            cursor: pointer;
            transition: fill 0.3s;
        }
        .user-actions svg:hover {
            fill: #ffcc00;
        }
        .icon-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 400px;
        }
        .icon-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .icon-card img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }
        .icon-card button {
            background-color: #6200ea;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .icon-card button:hover {
            background-color: #3700b3;
        }
        @media (max-width: 600px) {
            .user-profile .user-info {
                font-size: 12px;
            }
            header {
                flex-direction: column;
                align-items: flex-start;
            }


        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #6200ea;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }
        footer input {
            flex: 1;
            margin-right: 20px;
            padding: 10px;
            border: none;
            border-radius: 20px;
            font-size: 14px;
        }
        footer svg {
            width: 24px;
            height: 24px;
            fill: white;
            cursor: pointer;
            transition: fill 0.3s;
        }
        footer svg:hover {
            fill: #ffcc00;
        }
        @media (max-width: 600px) {
            .user-profile .user-info {
                font-size: 12px;
            }
            header {
                flex-direction: column;
                align-items: flex-start;
            }
            footer {
                flex-wrap: wrap;
                gap: 10px;
                justify-content: center;
            }
            footer input {
                flex-basis: 70%;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="user-profile"> <!-- ici, on récup les info de la table users.-->
            <img src="" alt="Avatar">
            <div class="user-info">
                <span>fogel92</span>
                <span>Femme, 28 ans, 92 Clamart</span>
            </div>
        </div>
        <div class="user-actions">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
</svg>

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
</svg>



        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
</svg>



<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
</svg>


        </div>
    </header>

   
    <footer>
        <input type="text" placeholder="Taper votre message">
        <svg onclick="alert('Envoyer des pièces !')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-2.83-.48-5.05-2.7-5.53-5.53H5v-2h1.47C6.95 9.77 9.17 7.55 12 7.07v1.43c-2.27.46-4 2.48-4 4.95s1.73 4.49 4 4.95v1.43zm6.53-5.53c-.48 2.83-2.7 5.05-5.53 5.53v-1.43c2.27-.46 4-2.48 4-4.95s-1.73-4.49-4-4.95V7.07c2.83.48 5.05 2.7 5.53 5.53H19v2h-1.47z"/></svg>
        <svg onclick="alert('Ajouter une image !')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zm-2 0H5V5h14v14zm-7-9l-2.5 3.01L8.5 11 5 16h14l-5-7z"/></svg>
        <svg onclick="alert('Activer le micro !')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3s-3 1.34-3 3v6c0 1.66 1.34 3 3 3zm4-3c0 2.5-2.01 4.43-4.5 4.92V19h3v2h-7v-2h3v-3.08C8.01 15.43 6 13.5 6 11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h2z"/></svg>
    </footer>

</body>
</html>
