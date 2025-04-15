<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include_once '../includes/db.php';
include_once '../models/PaymentModel.php';
include_once '../controllers/PaymentController.php';

$paymentModel = new PaymentModel($conn);
$paymentController = new PaymentController($paymentModel);

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        // Get JSON input
        $input = json_decode(file_get_contents("php://input"), true);
        
        // Process the payment
        echo json_encode($paymentController->processPayment($input));
        break;

    default:
         echo json_encode(['message' => 'Method not allowed']);
         break;
}
?>
