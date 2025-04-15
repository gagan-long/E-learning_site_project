<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Include database connection and models
include_once '../includes/db.php';
include_once '../models/user_model.php';

// Initialize user model
$userModel = new UserModel($conn);

// Get the request method
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Handle API requests based on the request method
switch ($requestMethod) {
   case 'GET':
       if (isset($_GET['id'])) {
           echo json_encode($userModel->getUserById($_GET['id']));
       } else {
           echo json_encode($userModel->getAllUsers());
       }
       break;

   case 'POST':
       // Add a new user or register a new account
       $data = json_decode(file_get_contents("php://input"), true);
       echo json_encode(['success' => ($userModel->addUser($data))]);
       break;

   case 'PUT':
       // Update an existing user
       parse_str(file_get_contents("php://input"), $_PUT); // Parse PUT data
       echo json_encode(['success' => ($userModel->updateUser($_PUT, $_PUT['id']))]);
       break;

   case 'DELETE':
       if (isset($_GET['id'])) {
           echo json_encode(['success' => ($userModel->deleteUser($_GET['id']))]);
       } else {
           echo json_encode(['error' => 'Invalid ID']);
       }
       break;

   default:
       echo json_encode(['message' => 'Method not allowed']);
       break;
}
?>
