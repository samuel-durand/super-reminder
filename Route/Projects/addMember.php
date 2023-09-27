<?php
    require_once "../../Class/Project.php";

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        $projectId = $data["projectId"];
        $userId = $data["userId"];
        $role = $data["role"];

        $response['success'] = $projectCrud->addProjectMember($projectId, $userId, $role);
        echo json_encode($response);
    }
?>