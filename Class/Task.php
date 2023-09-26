<?php

class TaskCrud{
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function createTask($name, $description, $user_id, $endDate){
        $stmt = $this->db->prepare("INSERT INTO task (name, description, user_id, end_date) VALUES (:name, :description, :user_id, :end_date)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':end_date', $endDate);
        if ($stmt->execute()) {
            $taskId = $this->db->lastInsertId();
            return $this->getTaskById($taskId);

        } else {
            return false;
        }
    }

    public function getTasks(){
        $stmt = $this->db->query("SELECT * FROM task");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
        
    }

    public function getTaskById($taskId){
        $stmt = $this->db->prepare("SELECT * FROM task WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function updateTask($taskId, $name, $description, $endDate){
        $stmt = $this->db->prepare("UPDATE task SET name = :name, description = :description, end_date = :end_date WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':end_date', $endDate);
        return $stmt->execute();
    }

    public function deleteTask($taskId){
        $stmt = $this->db->prepare("DELETE FROM task WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        return $stmt->execute();
    }

    public function endTask($taskId){
        $stmt = $this->db->prepare("UPDATE task SET status = 1 WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        return $stmt->execute();
    }

    public function restoreTask($taskId){
        $stmt = $this->db->prepare("UPDATE task SET status = 0 WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        return $stmt->execute();
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