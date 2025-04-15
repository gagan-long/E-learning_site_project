<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include_once '../includes/db.php';
include_once '../models/settings_model.php';

$settingsModel = new SettingsModel($conn);
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
   case 'GET':
       echo json_encode($settingsModel->getSettings());
       break;

   case 'PUT':
       parse_str(file_get_contents("php://input"), $_PUT); // Parse PUT data from request body
       echo json_encode(['success' => $settingsModel->updateSettings($_PUT)]);
       break;

   default:
       echo json_encode(['message' => 'Method not allowed']);
       break;
}
?>
