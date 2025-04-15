<?php

class UserController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    // Retrieve all users
    public function index() { 
        return json_encode($this->userModel->getAllUsers());
    }
    
    // Retrieve a specific user by ID
    public function show($id) { 
        return json_encode($this->userModel->getUserById($id));
    }
    
    // Add a new user
    public function store($data) { 
        if ($this->userModel->addUser($data)) {
            return json_encode(['message' => 'User added successfully']);
        } else {
            return json_encode(['message' => 'Failed to add user']);
        }
    }
    
    // Update user details
    public function update($data, $id) { 
        if ($this->userModel->updateUser($data, $id)) {
            return json_encode(['message' => 'User updated successfully']);
        } else {
            return json_encode(['message' => 'Failed to update user']);
        }
    }
    
    // Delete a user
    public function destroy($id) { 
        if ($this->userModel->deleteUser($id)) {
            return json_encode(['message' => 'User deleted successfully']);
        } else {
            return json_encode(['message' => 'Failed to delete user']);
        }
    }
}
?>
