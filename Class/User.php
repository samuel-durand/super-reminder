<?php


class UserCrud
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createUser($username, $firstname, $lastname, $password, $admin = 0)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $stmt = $this->db->prepare("INSERT INTO users (login, firstname, lastname, password, admin) VALUES (:login, :firstname, :lastname, :password, :admin)");
        $stmt->bindParam(':login', $username);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':admin', $admin); 
    
        if ($stmt->execute()) {
            $userId = $this->db->lastInsertId();
    
            $_SESSION['user_id'] = $userId;
    
            return $this->getUserById($userId);
        } else {
            return false;
        }
    }
    
    public function getUsers()
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($user);

    }
    
    public function getUserById($userId, $returnName = false)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    
        if ($returnName) {
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $userData ? $userData['firstname'] . ' ' . $userData['lastname'] : '';
        } else {
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        }
    }
    
    

    public function loginUser($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->bindParam(':login', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC); 
    
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return $user;
        } else {
            return false;
        }
    }
    

    public function updateUser($id, $login, $firstname, $lastname, $password)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE login = :login AND id != :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
    
        $existingUser = $stmt->fetch(PDO::FETCH_OBJ);
    
        if (!$existingUser) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            $stmt = $this->db->prepare("UPDATE users SET login = :login, firstname = :firstname, lastname = :lastname, password = :password WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':password', $hashedPassword);
    
            return $stmt->execute();
        } else {
            return false;
        }
    }
    
    
    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

try {
    $db = new PDO('mysql:host=localhost;dbname=superreminder', 'root', 'SuperP3scado');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userCrud = new UserCrud($db);

    $users = $userCrud->getUsers();
    //print_r($users);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
}




