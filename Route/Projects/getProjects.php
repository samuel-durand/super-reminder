<?php

    require_once "../../Class/Project.php";
    
    $response["projects"] = $projects;
    echo json_encode($response);
?>