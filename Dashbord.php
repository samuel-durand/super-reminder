<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

require_once('Class/User.php');
require_once('Class/Task.php');

$userCrud = new UserCrud($db);
$taskCrud = new TaskCrud($db); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteUser'])) {
        $userIdToDelete = $_POST['user_id'];
        $userToDelete = $userCrud->getUserById($userIdToDelete);

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
    } elseif (isset($_POST['deleteTask'])) {
        $taskIdToDelete = $_POST['task_id'];
        $deleted = $taskCrud->deleteTask($taskIdToDelete);
        if ($deleted) {
            $succesMessage = "La tâche avec l'ID $taskIdToDelete a été supprimée avec succès.";
        } else {
            $errorMessage = "Une erreur s'est produite lors de la suppression de la tâche avec l'ID $taskIdToDelete.";
        }
    }
}


$users = $userCrud->getUsers();
$tasks = $taskCrud->getTasks();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include('Header.php'); ?>
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
                    <th>Action Utilisateur</th>
                </tr>
            </thead>
            <tbody id="users-table">
                <!-- Contenu des utilisateurs sera ajouté ici par JavaScript -->
            </tbody>
        </table>
        <div id="message-container"></div>

    </div>

    <div id="table">
        <h2>Liste des Tâches</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID de la Tâche</th>
                    <th>Nom de la Tâche</th>
                    <th>Description</th>
                    <th>Action Tâche</th>
                </tr>
            </thead>
            <tbody id="tasks-table">
                <!-- Contenu des tâches sera ajouté ici par JavaScript -->
            </tbody>
        </table>
        <div id="message-container"></div>

    </div>

    <!-- Formulaire pour supprimer un utilisateur -->
    <form id="delete-user-form" style="display: none;" method="POST">
        <input type="hidden" name="deleteUser" value="1">
        <input type="hidden" id="user-id-to-delete" name="user_id" value="">
        <button type="submit">Confirmer la suppression de l'Utilisateur</button>
    </form>

    <!-- Formulaire pour supprimer une tâche -->
    <form id="delete-task-form" style="display: none;" method="POST">
        <input type="hidden" name="deleteTask" value="1">
        <input type="hidden" id="task-id-to-delete" name="task_id" value="">
        <button type="submit">Confirmer la suppression de la Tâche</button>
    </form>

    <script>
   
         // Fonction principale asynchrone pour afficher les utilisateurs et leurs tâches
         async function displayUsersAndTasks() {
            // Utilisez les données PHP directement pour les utilisateurs
            const users = <?php echo json_encode($users); ?>;
            // Utilisez les données PHP directement pour les tâches
            const tasks = <?php echo json_encode($tasks); ?>;

            // Afficher les utilisateurs
            const usersTable = document.getElementById('users-table');
            usersTable.innerHTML = '';
            users.forEach(user => {
                if (user.id !== 1) {
                    const row = usersTable.insertRow();
                    row.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.login}</td>
                        <td>${user.firstname}</td>
                        <td>${user.lastname}</td>
                        <td>
                            <button onclick="prepareToDeleteUser(${user.id});">Supprimer l'Utilisateur</button>
                        </td>
                    `;
                }
            });

            // Afficher les tâches
            const tasksTable = document.getElementById('tasks-table');
            tasksTable.innerHTML = '';
            tasks.forEach(task => {
                const row = tasksTable.insertRow();
                row.innerHTML = `
                    <td>${task.id}</td>
                    <td>${task.name}</td>
                    <td>${task.description}</td>
                    <td>
                        <button onclick="prepareToDeleteTask(${task.id});">Supprimer la Tâche</button>
                    </td>
                `;
            });
        }

        // Fonction pour préparer la suppression d'un utilisateur
        function prepareToDeleteUser(userId) {
            document.getElementById('user-id-to-delete').value = userId;
            document.getElementById('delete-user-form').style.display = 'block';
        }

        // Fonction pour préparer la suppression d'une tâche
        function prepareToDeleteTask(taskId) {
            document.getElementById('task-id-to-delete').value = taskId;
            document.getElementById('delete-task-form').style.display = 'block';
        }

        // Appeler la fonction principale pour afficher les utilisateurs et leurs tâches
        displayUsersAndTasks();
    </script>
</body>
</html>
