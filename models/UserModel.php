<?php

class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch all users
    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a user by ID
    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add a new user
    public function addUser($data) {
        $query = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        
        $stmt = $this->conn->prepare($query);
        
        // Hash the password before storing it
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        // Bind parameters
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $data['role']);

        return $stmt->execute();
    }

    // Update user details
    public function updateUser($data, $id) {
        $query = "UPDATE users SET name = :name, email = :email, role = :role WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Delete user by ID
    public function deleteUser($id) {
       $query = "DELETE FROM users WHERE id = :id";
       
       $stmt = $this->conn->prepare($query);
       $stmt->bindParam(':id', $id);

       return $stmt->execute();
   }
}
?>
