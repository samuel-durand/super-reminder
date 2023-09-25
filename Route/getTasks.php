<?php
    require_once "../Class/Task.php";
    
    $response["tasks"] = $tasks;
    echo json_encode($response);
?>