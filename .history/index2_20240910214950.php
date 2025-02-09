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
                <label for="avatar">Avatar :</label>
                <input type="file" id="avatar" name="avatar" accept="image/*" >
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
