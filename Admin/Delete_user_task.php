<?php


$userCrud = new UserCrud($db);
$taskCrud = new TaskCrud($db); 



$users = $userCrud->getUsers();
$tasks = $taskCrud->getTasks();




header('Content-Type: application/json'); // Définir l'en-tête de la réponse comme JSON

$response = array(); // Initialiser un tableau pour la réponse

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteUser'])) {
        $userIdToDelete = $_POST['user_id'];
        $userToDelete = $userCrud->getUserById($userIdToDelete);

        if ($userToDelete) {
            $deleted = $userCrud->deleteUser($userIdToDelete);
            if ($deleted) {
                $response['success'] = true;
                $response['message'] = "L'utilisateur avec l'ID $userIdToDelete (Login: {$userToDelete['login']}) a été supprimé avec succès.";
            } else {
                $response['success'] = false;
                $response['errorMessage'] = "Une erreur s'est produite lors de la suppression de l'utilisateur avec l'ID $userIdToDelete.";
            }
        } else {
            $response['success'] = false;
            $response['errorMessage'] = "Utilisateur non trouvé avec l'ID $userIdToDelete.";
        }
    } elseif (isset($_POST['deleteTask'])) {
        $taskIdToDelete = $_POST['task_id'];
        $deleted = $taskCrud->deleteTask($taskIdToDelete);
        if ($deleted) {
            $response['success'] = true;
            $response['message'] = "La tâche avec l'ID $taskIdToDelete a été supprimée avec succès.";
        } else {
            $response['success'] = false;
            $response['errorMessage'] = "Une erreur s'est produite lors de la suppression de la tâche avec l'ID $taskIdToDelete.";
        }
    }
}

echo json_encode($response); // Encoder le tableau de réponse en JSON et l'envoyer en réponse
