<header>
    <div class="burger-menu" id="burger-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
</header>

<nav class="sidebar" id="sidebar">
    <ul>
        <?php

        require_once './Class/User.php';

        $prefix = "";
        if(isset($_GET["listId"])){
            $prefix = "../";
        }

        // Vérifiez si l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            // Si connecté, récupérez l'information sur l'utilisateur (y compris le statut administrateur)
            $user = $userCrud->getUserById($_SESSION['user_id']);

            // Vérifiez si l'utilisateur est à la fois connecté et administrateur
            if ($user && $user['admin'] == 1) {
                // Si l'utilisateur est administrateur, affichez le lien vers le panneau d'administration
                echo '<li><a href="'.$prefix.'Dashbord.php">Panneau d\'administration</a></li>';
                echo '<li><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">try this</a></li>';

            }

            // Affichez également les liens du profil et de déconnexion
            echo '<li><a href="'.$prefix.'index.php">Acceuil</a></li>';
            echo '<li><a href="'.$prefix.'profil.php">Profil</a></li>';
            echo '<li><a href="'.$prefix.'project.php">Projets</a></li>';
            echo '<li><a href="'.$prefix.'logout.php">Déconnexion</a></li>';
        } else {
            // Si non connecté, affichez le lien de connexion et d'inscription
            echo '<li><a href="'.$prefix.'connexion.php">Connexion</a></li>';
            echo '<li><a href="'.$prefix.'index.php">Acceuil</a></li>';
            echo '<li><a href="'.$prefix.'inscription.php">Inscription</a></li>';
        }
        ?>
    </ul>
</nav>
