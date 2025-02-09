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
            fill: white;
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
    </style>
</head>
<body>
    <header>
        <div class="user-profile">
            <img src="https://via.placeholder.com/40" alt="Avatar">
            <div class="user-info">
                <span>fogel92</span>
                <span>Femme, 28 ans, 92 Clamart</span>
            </div>
        </div>
        <div class="user-actions">
            <svg onclick="alert('Alerte activée!')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2a9.978 9.978 0 00-9.906 8.684A3.486 3.486 0 002 14.5C2 16.432 3.568 18 5.5 18h13c1.932 0 3.5-1.568 3.5-3.5 0-1.684-1.162-3.093-2.686-3.435A9.978 9.978 0 0012 2zm0 2c3.973 0 7.221 2.933 7.906 6.764A1.5 1.5 0 0118.5 14h-13a1.5 1.5 0 01-1.406-2.236A7.978 7.978 0 0112 4zm-1 14h2v2h-2v-2zm0-6h2v4h-2v-4z"/></svg>
            <svg onclick="alert('Déconnecté!')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 3v2H5v14h4v2H3V3h6zm8 0v2h4v14h-4v2h6V3h-6zM12 7v10l-5-5 5-5z"/></svg>
            <svg onclick="alert('Ouverture du profil!')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            <svg onclick="alert('Démarrage de la vidéo!')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 16.5l6-4.5-6-4.5v9zm10-11v11.86c0 1.56-1.26 2.82-2.82 2.82H3.82C2.26 20.18 1 18.92 1 17.36V6.14C1 4.58 2.26 3.32 3.82 3.32h13.36c1.56 0 2.82 1.26 2.82 2.82z"/></svg>
            <svg onclick="alert('Ouverture du magasin!')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7 4V2H5v2H3v2h2v12H3v2h2v2h2v-2h10v2h2v-2h2v-2h-2V6h2V4h-2V2h-2v2H7zm0 2h10v12H7V6z"/></svg>
        </div>
    </header>

   
</body>
</html>
