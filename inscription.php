<?php
require_once('Class/User.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim(htmlspecialchars($_POST['login']));
    $firstname = trim(htmlspecialchars($_POST['firstname']));
    $lastname = trim(htmlspecialchars($_POST['lastname']));
    $password = trim(htmlspecialchars($_POST['password']));
    
    // Vérifiez d'abord si l'utilisateur existe déjà
    $existingUser = $userCrud->loginUser($login, $password);

    if ($existingUser) {
        // L'utilisateur existe déjà, retournez un message d'erreur
        $errorMessage = "Cet utilisateur existe déjà.";

    } else {
        // L'utilisateur n'existe pas, essayez de créer un nouvel utilisateur
        $user = $userCrud->createUser($login, $firstname, $lastname, $password, 0);

        if ($user) {
            header("Location: connexion.php?id=" . $user['id']);
            echo json_encode($user);
        } else {
            $errorMessage = "Une erreur s'est produite lors de l'inscription.";
        }
    }
}

?>





<!DOCTYPE html>
<html>
<head>
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php include('Header.php');?>
<script src="menu.js"></script>
<div class="container" >
    <div class="text">Inscription</div>
    <form method="POST" id="registrationForm" class="gradient-border">
        <div class="form-row">
            <div class="input-data">
                <input type="text" id="login" name="login" required>
                <label for="login">Login :</label>
                <div class="underline"></div>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data">
                <input type="text" id="firstname" name="firstname" required>
                <label for="firstname">Prénom :</label>
                <div class="underline"></div>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data">
                <input type="text" id="lastname" name="lastname" required>
                <label for="lastname">Nom de famille :</label>
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
            <!-- Ajout de la classe "submit-btn" pour le bouton -->
            <div class="submit-btn">
                <div class="input-data">
                    <button type="submit" class="button-85"  role="button">S'inscrire</button>

                    <!-- Ajout de la classe "inner" pour l'animation du bouton -->
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
