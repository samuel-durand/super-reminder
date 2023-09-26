<?php

    class ProjectCrud{

        private $db;

        public function __construct($db){
            $this->db = $db;
        }

        public function createProject($name, $description, $endDate, $user_id){

            $stmt = $this->db->prepare("INSERT INTO task_list (name, description, end_date, user_id) VALUES (:name, :description, :end_date, :user_id)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':end_date', $endDate);
            $stmt->bindParam(':user_id', $user_id);
            return $stmt->execute();
        }

        public function getProjects(){
            $stmt = $this->db->query("SELECT * FROM task_list");
            return $stmt->fetchAll(PDO::FETCH_OBJ);
            
        }

        public function getProjectById($projectId){
            $stmt = $this->db->prepare("SELECT * FROM task_list WHERE id = :id");
            $stmt->bindParam(':id', $projectId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        }

        public function deleteProject($projectId){
            $stmt = $this->db->prepare("DELETE FROM task_list WHERE id = :id");
            $stmt->bindParam(':id', $projectId);
            return $stmt->execute();
        }

        public function editProject($projectId, $name, $description, $endDate){
            $stmt = $this->db->prepare("UPDATE task_list SET name = :name, description = :description , end_date = :end_date WHERE id = :id");
            $stmt->bindParam(':id', $projectId);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':end_date', $endDate);
            return $stmt->execute();
        }

        public function getProjectTasks($projectId){
            $stmt = $this->db->prepare("SELECT * FROM task WHERE list_id = :list_id");
            $stmt->bindParam(':list_id', $projectId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }

    try {
        $db = new PDO('mysql:host=localhost;dbname=superreminder', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $projectCrud = new ProjectCrud($db);

        $projects = $projectCrud->getProjects();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
?>