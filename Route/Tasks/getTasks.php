<?php
    require_once "../../Class/Task.php";
    require_once "../../Class/Project.php";
    session_start();

    if($_SERVER["REQUEST_METHOD"] === "GET"){

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        $project_id = $_GET["listId"];
        $response["tasks"] = $projectCrud->getProjectTasks($project_id);
        $response["members"] = $projectCrud->getProjectMembers($project_id);
        // Ajout des membres de la tache dans chaque tache
        foreach($response["tasks"] as $task){
            $task->members = $taskCrud->getTaskMembers($task->id);
        }
        $response["user"] = $_SESSION["user_id"];
        echo json_encode($response);
    }
?>