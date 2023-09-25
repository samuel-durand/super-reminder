<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}


require_once('Class/User.php');
$userCrud = new UserCrud($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $userIdToDelete = $_POST['user_id'];
        $userToDelete = $userCrud->getUserById($userIdToDelete); // Obtenir les informations de l'utilisateur à supprimer
        
        if ($userToDelete) {
            $deleted = $userCrud->deleteUser($userIdToDelete);
            if ($deleted) {
                $succesMessage = "L'utilisateur avec l'ID $userIdToDelete (Login: {$userToDelete['login']}) a été supprimé avec succès.";

            } else {

                $errorMessage = "Une erreur s'est produite lors de la suppression de l'utilisateur avec l'ID $userIdToDelete.";

            }
        } else {
            $errorMessage = "Utilisateur non trouvé avec l'ID $userIdToDelete.";

        }
    }
}

$users = $userCrud->getUsers();
?>

<!DOCTYPE html>
<link rel="stylesheet" href="styles.css">
<html>
<head>
    <title>Liste des Utilisateurs</title>
</head>
<body>

<?php include('Header.php');?>
<script src="menu.js"></script>

<div id="table"> 
    <h2>Liste des Utilisateurs</h2>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Prénom</th>
                <th>Nom de Famille</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) : ?>
    <?php if ($user->id !== 1) : ?>
        <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo $user->login; ?></td>
            <td><?php echo $user->firstname; ?></td>
            <td><?php echo $user->lastname; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                    <input type="submit" name="delete" value="Supprimer">
                </form>
            </td>
        </tr>
    <?php endif; ?>
<?php endforeach; ?>






        </tbody>
    </table>

    <?php
            if (isset($succesMessage)) {
                echo '<div style="color: green;">' . $succesMessage . '</div>';
            }
            ?>

<?php
            if (isset($errorMessage)) {
                echo '<div style="color: red;">' . $errorMessage . '</div>';
            }
            ?>

    </div>

</body>
</html>
