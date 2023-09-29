<?php

    require_once 'Class/Task.php';
    require_once 'Class/Project.php';
    require_once 'Class/User.php';
    session_start();

    if ($_GET["listId"]) {
        $listId = $_GET["listId"];
        $project = $projectCrud->getProject($listId);
        $members = $projectCrud->getProjectMembers($listId);

        // find the role that correspond to the user_id
        foreach ($members as $member) {
            if($member->user_id == $_SESSION["user_id"]){
                $role = $member->role;
            }
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
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <script type="module" src="../Scripts/todolist.js"></script>
</head>
<body>
    <?php include('Header.php');?>
    <script src="../menu.js"></script>
    <div class="project-header">
        <div>
            <h1><?php echo $project->name ?></h1>
            <p><?php echo $project->description ?></p>
        </div>
        <div >
                <h3>Membres du projet</h3>
                <div class="members">
                    <div class="member-list"></div>
                    
                    <?php
                        if($role == "admin"){
                            echo '<div class="add-member">';
                            echo '<button type="button" id="add-member-btn" class="btn members-btn" role="button">+</button>';
                            echo '<div class="inner"></div>';
                            echo '</div>';
                            echo '<div class="remove-member">';
                            echo '<button type="button" id="remove-member-btn" class="btn members-btn" role="button">-</button>';
                            echo '<div class="inner"></div>';
                            echo '</div>';
                        }
                    ?>
                </div>
        </div>
    </div>
    <div class="test">
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
                        <button type="button" id="add-btn" class="btn" role="button">Ajouter</button>
                        <div class="inner"></div>
                    </div>
                </div>
                </form>
            </div>
            
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

    <div class="modal-container hidden">
        <div class="test edit-form hidden">
            <form method="post" id="task-form" class="gradient-border">
                <input type="hidden" id="edit-id" name="edit-id">
                <div class="form-row">
                    <div class="input-data">
                        <input type="text" id="edit-name" name="edit-name" placeholder="Nom">
                        <label for="edit-name">Nom :</label>
                        <div class="underline"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-data">
                        <input type="text" id="edit-description" name="edit-description" placeholder="Description">
                        <label for="edit-description">Description :</label>
                        <div class="underline"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-data">
                        <input type="date" id="edit-date" name="edit-date" placeholder="Date de fin">
                        <label for="edit-date">Date de fin :</label>
                        <div class="underline"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="submit-btn">
                        <div class="input-data">
                            <button type="button" id="edit-btn" class="btn" role="button">Modifier</button>
                            <div class="inner"></div>
                        </div>
                    </div>
                    <div class="submit-btn">
                        <div class="input-data">
                            <button type="button" id="cancel-btn" class="btn" role="button">Annuler</button>
                            <div class="inner"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="test invite-form hidden">
            <form action="">
                <div class="form-row">
                    <div class="input-data">
                        <select id="user">
                            <?php
                                foreach ($users as $user) {
                                    if($user->id == $_SESSION["user_id"]){
                                        continue;
                                    }
                                    echo '<option value="'.$user->id.'">'.$user->login.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-data">
                        <select id="role">
                            <option value="user">Utilisateur</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="submit-btn">
                        <div class="input-data">
                            <button type="button" id="invite-btn" class="btn" role="button">Inviter</button>
                        </div>
                    </div>
                    <div class="submit-btn">
                        <div class="input-data">
                            <button type="button" id="cancel-invite-btn" class="btn" role="button">Annuler</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="test remove-form hidden">
            <form action="">
                <div class="form-row">
                    <div class="input-data">
                        <select id="remove-user">
                            <?php
                                foreach ($members as $user) {
                                    if($user->user_id == $_SESSION["user_id"]){
                                        continue;
                                    }
                                    echo '<option value="'.$user->user_id.'">'.$user->login.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="submit-btn">
                        <div class="input-data">
                            <button type="button" id="remove-btn" class="btn" role="button">Retirer</button>
                        </div>
                    </div>
                    <div class="submit-btn">
                        <div class="input-data">
                            <button type="button" id="cancel-remove-btn" class="btn" role="button">Annuler</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>



