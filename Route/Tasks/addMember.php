<?php

    require_once "../../Class/Task.php";

    // add member to task
    if ($_SERVER["REQUEST_METHOD"] === "POST"){

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        $taskId = $data["taskId"];
        $userId = $data["userId"];
        $role = $data["role"];

        $response['success'] = $taskCrud->addTaskMember($taskId, $userId, $role);
        echo json_encode($response);
    }
?>