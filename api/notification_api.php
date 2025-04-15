<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include_once '../includes/db.php';
include_once '../models/notification_model.php';

$notificationModel = new NotificationModel($conn);
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
   case 'GET':
       echo json_encode($notificationModel->getAllNotifications());
       break;

   case 'POST':
       echo json_encode(['success' => $notificationModel->addNotification(json_decode(file_get_contents("php://input"), true))]);
       break;

   case 'DELETE':
       echo json_encode(['success' => $notificationModel->deleteNotification($_GET['id'])]);
       break;

   default:
       echo json_encode(['message' => 'Method not allowed']);
       break;
}
?>
