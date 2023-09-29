<?php

    require_once '../../Class/Project.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        $projectId = trim(htmlspecialchars($data["projectId"]));
        $userId = trim(htmlspecialchars($data["userId"]));

        $response["success"] = $projectCrud->removeProjectMember($projectId, $userId);

        echo json_encode($response);
    }
?>