<?php

    session_start();
    require_once "../../Class/Project.php";
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        $name = trim(htmlspecialchars($data["name"]));
        $description = trim(htmlspecialchars($data["description"]));
        $endDate = trim(htmlspecialchars($data["end_date"]));
        $userId = $_SESSION["user_id"];

        $response['success'] = $projectCrud->createProject($name, $description, $endDate, $userId);
        echo json_encode($response);
    }
?>