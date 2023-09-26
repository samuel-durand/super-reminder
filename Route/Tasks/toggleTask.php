<?php

    require_once "../../Class/Task.php";

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        if ($data["status"] == 1)
        	$response['success'] = $taskCrud->restoreTask($data["id"]);
        else {
            $response['success'] = $taskCrud->endTask($data["id"]);
        }
        echo json_encode($response);
    }

?>