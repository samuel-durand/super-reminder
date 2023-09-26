<?php
    require_once "../../Class/Task.php";
    require_once "../../Class/Project.php";

    if($_SERVER["REQUEST_METHOD"] === "GET"){

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        $project_id = $_GET["listId"];
        $response["tasks"] = $projectCrud->getProjectTasks($project_id);
        echo json_encode($response);
    }
?>