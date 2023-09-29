<?php

    class ProjectCrud{

        private $db;

        public function __construct($db){
            $this->db = $db;
        }

        // Creation d'un projet
        public function createProject($name, $description, $endDate, $user_id){

            $stmt = $this->db->prepare("INSERT INTO task_list (name, description, end_date, user_id) VALUES (:name, :description, :end_date, :user_id)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':end_date', $endDate);
            $stmt->bindParam(':user_id', $user_id);
            // Ajout du créateur du projet en tant qu'admin
            if ($stmt->execute()) {
                $projectId = $this->db->lastInsertId();
                return $this->addProjectMember($projectId, $user_id, 'admin');
            } else {
                return false;
            }
        }
        
        // Récupération de tous les projets
        public function getProjects(){
            $stmt = $this->db->query("SELECT * FROM task_list");
            return $stmt->fetchAll(PDO::FETCH_OBJ);
            
        }

        // Récupération d'un projet par son id
        public function getProjectById($projectId){
            $stmt = $this->db->prepare("SELECT * FROM task_list WHERE id = :id");
            $stmt->bindParam(':id', $projectId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        }

        // Suppression d'un projet
        public function deleteProject($projectId){
            $stmt = $this->db->prepare("DELETE FROM task_list WHERE id = :id");
            $stmt->bindParam(':id', $projectId);
            return $stmt->execute();
        }

        // Modification d'un projet
        public function editProject($projectId, $name, $description, $endDate){
            $stmt = $this->db->prepare("UPDATE task_list SET name = :name, description = :description , end_date = :end_date WHERE id = :id");
            $stmt->bindParam(':id', $projectId);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':end_date', $endDate);
            return $stmt->execute();
        }

        // Récupération des tâches d'un projet
        public function getProjectTasks($projectId){
            $stmt = $this->db->prepare("SELECT * FROM task WHERE list_id = :list_id");
            $stmt->bindParam(':list_id', $projectId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // Ajout d'un membre à un projet
        public function addProjectMember($projectId, $userId, $role = "user"){

            $stmt = $this->db->prepare("SELECT * FROM project_member WHERE project_id = :project_id AND user_id = :user_id");
            $stmt->bindParam(':project_id', $projectId);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            if($user){
                // Si l'utilisateur est déjà membre du projet et que son rôle est différent, on le modifie
                if ($user->role != $role){
                    return $this->editProjectMember($projectId, $userId, $role);
                }
                // Sinon on ne fait rien
                return false;
            }

            // Si l'utilisateur n'est pas membre du projet, on l'ajoute
            $stmt = $this->db->prepare("INSERT INTO project_member (project_id, user_id, role) VALUES (:project_id, :user_id, :role)");
            $stmt->bindParam(':project_id', $projectId);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':role', $role);       
            return $stmt->execute();
        }

        // Suppression d'un membre d'un projet
        public function removeProjectMember($projectId, $userId) {

            // L'utilisateur ne peut pas se supprimer lui-même
            if ($userId == $_SESSION['user_id']) {
                return false;
            }

            $stmt = $this->db->prepare("DELETE FROM project_member WHERE project_id = :project_id AND user_id = :user_id");
            $stmt->bindParam(':project_id', $projectId);
            $stmt->bindParam(':user_id', $userId);
            return $stmt->execute();
        }

        // Modification du rôle d'un membre d'un projet
        public function editProjectMember($projectId, $userId, $role){

            $stmt = $this->db->prepare("UPDATE project_member SET role = :role WHERE project_id = :project_id AND user_id = :user_id");
            $stmt->bindParam(':project_id', $projectId);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':role', $role);
            return $stmt->execute();
        }

        // Récupération des membres d'un projet
        public function getProjectMembers($projectId){
            $stmt = $this->db->prepare("SELECT role, user_id, users.login
            FROM project_member
            JOIN users ON project_member.user_id = users.id
            WHERE project_id = :project_id
            ");
            $stmt->bindParam(':project_id', $projectId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }

    try {
        $db = new PDO('mysql:host=localhost;dbname=super-reminder', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $projectCrud = new ProjectCrud($db);

        $projects = $projectCrud->getProjects();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
?>