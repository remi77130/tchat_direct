<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style/index2.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">

            <h2>Login</h2>
            <form action="#" method="post">

                <div class="input-box">
                <label for="username">Pseudo :</label>
                <input type="text" id="username" name="username" pattern="[a-zA-Z0-9_]+" required maxlength="12">
                </div>

                <div class="input-box">
                <label for="avatar"></label>
                <input type="file" id="avatar" name="avatar" accept="image/*" >
                </div>



                <div class="input-box">
                <label for="age">Âge :</label>
            <input type="number" id="age" name="age" required>

                </div>



  <!-- Champ de saisie pour le département (type tel) -->
  <div class="input-box">
  <label for="department">Numéro de Département :</label>
        <input type="tel" id="department_id" name="department" required pattern="[0-9]{2,5}" maxlength="5">
</div>
         <!-- Sélection de la ville -->
         <div class="input-box">

    <div id="city-container" style="display:none;">
        <label for="city">Ville :</label>
        <select id="ville_dpt" name="ville_users" required>
            <option value="">Sélectionnez une ville</option>
        </select>
    </div>
</div>



<div class="input-box">
<input type="radio" id="homme" name="gender" value="male">
<label for="homme">Homme</label>

                </div>


                
                <div class="input-box">
                <input type="radio" id="femme" name="gender" value="female">
                <label for="femme">Femme</label>

                </div>









                <button type="submit" class="btn-submit">Submit</button>
            </form>
            <div class="extra-links">
                <a href="#">Register</a>
                <a href="#">Forgot Password</a>
            </div>
        </div>
        <div class="image-overlay">
            <img src="img/coco_logo(1).svg" alt="Person Illustration">
        </div>
    </div>
</body>
</html>
