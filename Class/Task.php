<?php

class TaskCrud{
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    // Creation d'une tâche
    public function createTask($name, $description, $user_id, $listId, $endDate){
        $stmt = $this->db->prepare("INSERT INTO task (name, description, user_id, list_id, end_date) VALUES (:name, :description, :user_id, :list_id, :end_date)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':list_id', $listId);
        $stmt->bindParam(':end_date', $endDate);
        if($stmt->execute()){
            $taskId = $this->db->lastInsertId();
            return $this->addTaskMember($taskId, $user_id, 'admin');
        } else {
            return false;
        }
    }

    // Récupération de toutes les tâches
    public function getTasks(){
        $stmt = $this->db->query("SELECT * FROM task");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
        
    }

    // Récupération d'une tâche par son id
    public function getTaskById($taskId){
        $stmt = $this->db->prepare("SELECT * FROM task WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    // Modification d'une tâche
    public function updateTask($taskId, $name, $description, $listId, $endDate){
        $stmt = $this->db->prepare("UPDATE task SET name = :name, description = :description, list_id = :list_id, end_date = :end_date WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':list_id', $listId);
        $stmt->bindParam(':end_date', $endDate);
        return $stmt->execute();
    }

    // Suppression d'une tâche
    public function deleteTask($taskId){
        $stmt = $this->db->prepare("DELETE FROM task WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        return $stmt->execute();
    }

    // Changement de statut d'une tâche (finie)
    public function endTask($taskId){
        $stmt = $this->db->prepare("UPDATE task SET status = 1 WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        return $stmt->execute();
    }

    // Changement de statut d'une tâche (à faire)
    public function restoreTask($taskId){
        $stmt = $this->db->prepare("UPDATE task SET status = 0 WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        return $stmt->execute();
    }

    // Ajout d'un membre à une tâche
    public function addTaskMember($taskId, $userId, $role = "user"){
        $stmt = $this->db->prepare("INSERT INTO task_member (task_id, user_id, role) VALUES (:task_id, :user_id, :role)");
        $stmt->bindParam(':task_id', $taskId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    // Recupération des membres d'une tâche
    public function getTaskMembers($taskId){
        $stmt = $this->db->prepare("SELECT role, user_id, users.login
        FROM task_member 
        JOIN users ON task_member.user_id = users.id
        WHERE task_id = :task_id
        ");
        $stmt->bindParam(':task_id', $taskId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

try {
    $db = new PDO('mysql:host=localhost;dbname=super-reminder', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $taskCrud = new TaskCrud($db);

    $tasks = $taskCrud->getTasks();
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
}

?>