<?php

    require_once "../../Class/Project.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        $name = trim(htmlspecialchars($data["name"]));
        $description = trim(htmlspecialchars($data["description"]));
        $endDate = trim(htmlspecialchars($data["end_date"]));
        $id = trim(htmlspecialchars($data["id"]));

        $response['success'] = $projectCrud->editProject($id, $name, $description, $endDate);
        echo json_encode($response);
    }
?>