<?php
require_once('Class/User.php');

session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $login = $_POST['login'];
    $password = $_POST['password'];

    $user = $userCrud->loginUser($login, $password);

    if ($user) {
        // Rediriger l'utilisateur vers la page profil.php avec son ID dans l'URL
        header("Location: profil.php?id=" . $user['id']);
        exit;
    } else {
        $errorMessage = "Échec de la connexion. Veuillez vérifier vos identifiants.";
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<?php include('Header.php');?>
<script src="menu.js"></script>

    <div class="container">
        <div class="text">Connexion</div>
        <form method="POST">
            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="login" name="login" required>
                    <label for="login">Login :</label>
                    <div class="underline"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Mot de passe :</label>
                    <div class="underline"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="submit-btn">
                    <div class="input-data">
                    <button type="submit" class="button-85"  role="button">Se connecter</button>

                        <div class="inner"></div>
                    </div>
                </div>
            </div>
        </form>

        <?php
            if (isset($errorMessage)) {
                echo '<div style="color: red;">' . $errorMessage . '</div>';
            }
            ?>
    </div>
</body>
</html>
