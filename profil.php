<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}


require_once('Class/User.php');

$userCrud = new UserCrud($db);

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Récupérer les données de l'utilisateur actuel
    $user = $userCrud->getUserById($userId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['update'])) {
            $login = trim(htmlspecialchars($_POST['login']));
            $firstname = trim(htmlspecialchars($_POST['firstname']));
            $lastname = trim(htmlspecialchars($_POST['lastname']));
            $password = $_POST['password'];

            // Mettre à jour les données de l'utilisateur
            $updated = $userCrud->updateUser($userId, $login, $firstname, $lastname, $password);

            if ($updated) {
                // Rediriger l'utilisateur vers la page de profil
                header("Location: profil.php");
                exit();
            } else {
                $errorMessage = "Une erreur s'est produite lors de la mise à jour des informations de l'utilisateur.";

            }
        } elseif (isset($_POST['delete'])) {
            // Supprimer l'utilisateur
            $deleted = $userCrud->deleteUser($userId);

            if ($deleted) {
                // Rediriger vers la page d'accueil ou une autre page après la suppression
                header("Location: index.php");
                exit();
            } else {
                $errorMessage = "Une erreur s'est produite lors de la suppression du compte..";

            }
        }
    } else {
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include('Header.php');?>
<script src="menu.js"></script>
    <div class="container">
        <?php
        if ($user) {
            echo "Bienvenue, " . $user['login'] . " " . $user['lastname'];
        } else {
            echo "Bienvenue, utilisateur inconnu";
        }
        ?>
        <div class="text">Profil</div>
        <form action="" method="post">
            <div class="form-row">
                <div class="input-data">
                    <input type="text" value="<?php echo isset($user['login']) ? $user['login'] : ''; ?>" name="login">
                    <label for="login">Your login :</label>
                    <div class="underline"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="text" value="<?php echo isset($user['firstname']) ? $user['firstname'] : ''; ?>" name="firstname">
                    <label for="firstname">Your First Name :</label>
                    <div class="underline"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="text" value="<?php echo isset($user['lastname']) ? $user['lastname'] : ''; ?>" name="lastname">
                    <label for="lastname">Your Last Name :</label>
                    <div class="underline"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="password" name="password" placeholder="********">
                    <label for="password">Password :</label>
                    <div class="underline"></div>
                </div>
            </div>

            <div class="form-row">
                <div class="input-data">
                    <button type="submit" class="btn" name="update">Mettre à jour</button>
                    <button type="submit" class="btn" name="delete">Supprimer le compte</button>
                    <div class="inner"></div>
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
