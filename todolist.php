<?php

    require_once 'Class/Task.php';

    session_start();
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $name = trim(htmlspecialchars($_POST['name']));
        $description = trim(htmlspecialchars($_POST['description']));
        $user_id = $_SESSION['user_id'];

        $task = $taskCrud->createTask($name, $description, $user_id);

        if($task){
            var_dump($task);
        }else{
            $errorMessage = "Une erreur s'est produite lors de l'ajout de la tache.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de tache</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap">
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
    <?php include('Header.php');?>
    <script  src="script.js"></script>

    <script src="menu.js"></script>
    <div class="container">
        <form method="post" id="task-form" class="gradient-border">
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
                    <label for="description">Date :</label>
                    <div class="underline"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="submit-btn">
                    <div class="input-data">
                        <button type="submit" class="button-85" role="button">Ajouter</button>
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
</body>
</html>