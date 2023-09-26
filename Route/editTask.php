<?php

    require_once "../Class/Task.php";

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        $id = trim(htmlspecialchars($data['id']));  
        $name = trim(htmlspecialchars($data['name']));
        $description = trim(htmlspecialchars($data['description']));
        $endDate = trim(htmlspecialchars($data['end_date']));

        $response['success'] = $taskCrud->updateTask($id, $name, $description, $endDate);
        echo json_encode($response);
    }
?> 