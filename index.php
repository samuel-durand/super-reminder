<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Accueil</title>
</head>
<body>
<?php include('Header.php');?>

<script src="menu.js"></script>
<div class="index">
        <main id="features">
            <h2 id="features-title">Fonctionnalités Du Site</h2>
            <ul id="feature-list">
                <li><strong>Inscription :</strong> Créez un compte en quelques étapes  </li>
                <li><strong>Connexion :</strong> Si vous avez déjà un compte, il vous suffit de vous connecter avec vos identifiants pour accéder à votre espace personnel.</li>
                <li><strong>Mise à Jour de Profil :</strong> Personnalisez votre profil en ajoutant des informations,</li>
            </ul>
        </main>
    </div>



    <script src="player.js"></script>

</html>