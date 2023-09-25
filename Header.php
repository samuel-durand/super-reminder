<header>
    <div class="burger-menu" id="burger-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
</header>

<nav class="sidebar" id="sidebar">
    <ul>
        <li><a href="Index.php">Accueil</a></li>
        <?php
        // Vérifiez si l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            // Si connecté, récupérez l'information sur l'utilisateur (y compris le statut administrateur)
            $user = $userCrud->getUserById($_SESSION['user_id']);

            // Vérifiez si l'utilisateur est à la fois connecté et administrateur
            if ($user && $user['admin'] == 1) {
                // Si l'utilisateur est administrateur, affichez le lien vers le panneau d'administration
                echo '<li><a href="Dashbord.php">Panneau d\'administration</a></li>';
                echo '<li><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">try this</a></li>';

            }

            // Affichez également les liens du profil et de déconnexion
            echo '<li><a href="profil.php">Profil</a></li>';
            echo '<li><a href="logout.php">Déconnexion</a></li>';
        } else {
            // Si non connecté, affichez le lien de connexion et d'inscription
            echo '<li><a href="connexion.php">Connexion</a></li>';
            echo '<li><a href="index.php">Acceuil</a></li>';
            echo '<li><a href="inscription.php">Inscription</a></li>';
        }
        ?>
    </ul>
</nav>
