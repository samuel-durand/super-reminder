<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de tache</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script type="module" src="./Scripts/project.js"></script>
</head>
<body>
    <?php include('Header.php');?>
    <script src="menu.js"></script>
    <div class="test">
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
            </div>
            
        </form>
        <?php
            if(isset($errorMessage)){
                echo '<p class="errorMessage">'.$errorMessage.'</p>';
            }
        ?>
    </div>
    <div class="projectlist-container">
        <div class="projects-container">
            <table>
                <caption>
                    <h2>Projets</h2>
                </caption>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date de fin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="current-projects">
        
                </tbody>
            </table>
        </div>
    </div>
    <div>
    <div class="modal-container hidden">
        <div class="test edit-form hidden">
            <form id="edit-form" class="gradient-border"> <!-- Ajoutez la classe "gradient-border" au formulaire -->
                <input type="hidden" id="edit-id" name="edit-id">
                <div class="form-row"> <!-- Ajoutez la classe "form-row" à chaque groupe d'entrées -->
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
    </div>

    </div>
</body>
</html>