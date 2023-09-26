<?php

    require_once "../../Class/Task.php";
    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        $name = trim(htmlspecialchars($data['name']));
        $description = trim(htmlspecialchars($data['description']));
        $endDate = trim(htmlspecialchars($data['end_date']));
        $projectId = trim(htmlspecialchars($data['list_id']));

        $response['success'] = $taskCrud->createTask($name, $description, $_SESSION["user_id"], $projectId, $endDate);
        echo json_encode($response);
    }
?>