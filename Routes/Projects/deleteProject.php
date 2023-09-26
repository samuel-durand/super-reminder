<?php


    require_once "../../Class/Project.php";
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        $response['success'] = $projectCrud->deleteProject($data["id"]);
        echo json_encode($response);
    }
?>
