<?php

    require_once "../../Class/Project.php";
    session_start();

    // recupere les projets ou l'utilisateur fait partie des membres
    $response["projects"] = [];
    $response["user"] = $_SESSION["user_id"]; 

    // Ajout des membres de projet dans chaque projet
    foreach ($projects as $project) {
        $project->members = $projectCrud->getProjectMembers($project->id);
        if (in_array($_SESSION["user_id"], array_column($project->members, "user_id"))) {
            array_push($response["projects"], $project);
        }
    }

    echo json_encode($response);
?>