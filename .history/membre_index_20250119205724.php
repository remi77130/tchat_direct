<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Membres et Salons</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      background: #f1f1f1;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 20px;
    }

    h1 {
      font-size: 24px;
      margin-bottom: 20px;
      color: #333;
    }

    table {
      width: 100%;
      max-width: 600px;
      border-collapse: collapse;
      margin-bottom: 30px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    th, td {
      padding: 10px;
      text-align: center;
      border: 1px solid #ddd;
    }

    th {
      background: #ff9800;
      color: #fff;
      font-size: 14px;
      text-transform: uppercase;
      cursor: pointer;
    }

    tr:nth-child(even) {
      background: #ffebcc;
    }

    tr:nth-child(odd) {
      background: #fff;
    }

    tr:hover {
      background: #ffcc80;
    }

    .salons {
      width: 100%;
      max-width: 400px;
      border-collapse: collapse;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .salons th, .salons td {
      padding: 10px;
      text-align: center;
      border: 1px solid #ddd;
    }

    .salons th {
      background: #00bcd4;
      color: #fff;
      text-transform: uppercase;
    }

    .salons tr:nth-child(even) {
      background: #e0f7fa;
    }

    .salons tr:nth-child(odd) {
      background: #b2ebf2;
    }

    .salons button {
      padding: 5px 10px;
      background: #4caf50;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 12px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .salons button:hover {
      background: #45a049;
    }
  </style>
</head>
<body>

<h1>Membres en ligne</h1>
<table>
  <thead>
    <tr>
      <th>Avatar</th>
      <th>Nom</th>
      <th>Âge</th>
      <th>Dépt</th>
      <th>Ville</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><img src="https://via.placeholder.com/40" alt="Avatar"></td>
      <td>Edouard</td>
      <td>32</td>
      <td>75</td>
      <td>Paris</td>
    </tr>
    <tr>
      <td><img src="https://via.placeholder.com/40" alt="Avatar"></td>
      <td>Magalie</td>
      <td>28</td>
      <td>77</td>
      <td>Montereau</td>
    </tr>
    <tr>
      <td><img src="https://via.placeholder.com/40" alt="Avatar"></td>
      <td>Kevin</td>
      <td>36</td>
      <td>91</td>
      <td>Corbeil</td>
    </tr>
  </tbody>
</table>

<h1>Liste des salons</h1>
<table class="salons">
  <thead>
    <tr>
      <th>Salon</th>
      <th>Utilisateurs</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Celib de France</td>
      <td>252</td>
      <td><button onclick="createSalon('Celib de France')">Créer</button></td>
    </tr>
    <tr>
      <td>Celib Paris</td>
      <td>137</td>
      <td><button onclick="createSalon('Celib Paris')">Créer</button></td>
    </tr>
    <tr>
      <td>Entrepreneur</td>
      <td>87</td>
      <td><button onclick="createSalon('Entrepreneur')">Créer</button></td>
    </tr>
    <tr>
      <td>Travail</td>
      <td>12</td>
      <td><button onclick="createSalon('Travail')">Créer</button></td>
    </tr>
  </tbody>
</table>

<script>
  function createSalon(salonName) {
    alert(`Salon "${salonName}" créé avec succès !`);
  }
</script>

</body>
</html>
