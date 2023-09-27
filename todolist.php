<?php

    require_once 'Class/Task.php';
    require_once 'Class/Project.php';
    session_start();

    if ($_GET["listId"]) {
        $listId = $_GET["listId"];
        $project = $projectCrud->getProject($listId);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de tache</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap">
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <script type="text/javascript" src="../Scripts/todolist.js"></script>
</head>
<body>
    <?php include('Header.php');?>
    <script src="../menu.js"></script>
    <div class="project-header">
        <h1><?php echo $project->name ?></h1>
        <p><?php echo $project->description ?></p>
    </div>
    <div class="container">
        <form method="post" id="task-form" class="gradient-border">
            <input type="hidden" id="list-id" name="list-id" value="<?php echo $listId ?>">
            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="name" name="name" placeholder="Nom">
                    <label for="name">Nom :</label>
                    <div class="underline"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="description" name="description" placeholder="Description">
                    <label for="description">Description :</label>
                    <div class="underline"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="date" id="date" name="date" placeholder="Description">
                    <label for="description">Date de fin :</label>
                    <div class="underline"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="submit-btn">
                    <div class="input-data">
                        <button type="button" id="add-btn" class="button-85" role="button">Ajouter</button>
                        <div class="inner"></div>
                    </div>
                </div>
            </div>
            
        </form>
        <?php
            if(isset($errorMessage)){
                echo '<p class="errorMessage">'.$errorMessage.'</p>';
            }
        ?>
    </div>
    <div class="todolist-container">
        <div class="tasks-container">
            <table>
                <caption>
                    <h2>Tâches à faire</h2>
                </caption>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date de fin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="current-tasks">
        
                </tbody>
            </table>
        </div>
        <div class="tasks-container">
            <table>
                <caption>
                    <h2>Tâches terminées</h2>
                </caption>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date de fin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="done-tasks">
        
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <form id="edit-form" class="edit-container">
            <input type="hidden" id="edit-id" name="edit-id">
            <input type="text" id="edit-name" name="edit-name" placeholder="Nom">
            <input type="text" id="edit-description" name="edit-description" placeholder="Description">
            <input type="date" id="edit-date" name="edit-date" placeholder="Date de fin">
            <button type="button" id="edit-btn" class="button-85" role="button">Modifier</button>
        </form>
    </div>
</body>
</html>