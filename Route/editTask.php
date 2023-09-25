<?php

    require_once "../Class/Task.php";

    if($_SESSION["REQUEST_METHOD"] === "POST"){

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        $name = trim(htmlspecialchars($data['name']));
        $description = trim(htmlspecialchars($data['description']));

        $response['success'] = $taskCrud->updateTask($data["id"], $name, $description);
        echo json_encode($response);
    }
?>