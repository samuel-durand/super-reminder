<?php

class TaskCrud{
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function createTask($name, $description, $user_id){
        $stmt = $this->db->prepare("INSERT INTO task (name, description, user_id) VALUES (:name, :description, :user_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id);
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

    public function updateTask($taskId, $name, $description){
        $stmt = $this->db->prepare("UPDATE task SET name = :name, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public function deleteTask($taskId){
        $stmt = $this->db->prepare("DELETE FROM task WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        return $stmt->execute();
    }
}

try {
    $db = new PDO('mysql:host=localhost;dbname=superreminder', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $taskCrud = new TaskCrud($db);

    $tasks = $taskCrud->getTasks();
    var_dump($tasks);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
}

?>