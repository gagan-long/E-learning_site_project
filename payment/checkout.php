<?php 
session_start();
include_once '../includes/db.php';
include_once '../models/payment_model.php';

$paymentModel = new PaymentModel($conn);

// Assuming course ID is passed via GET request or session variable after selection.
$courseId = $_GET['course_id'] ?? null; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission here, e.g., process payment with a payment gateway
    
    $paymentData = [
        'course_id' => $courseId,
        'user_id' => $_SESSION['user_id'], // Assuming user is logged in and their ID is stored in session.
        'amount' => $_POST['amount'], // Amount should be calculated based on the selected course.
        'payment_method' => $_POST['payment_method'] // e.g., credit card, PayPal, etc.
    ];

    // Process the payment (this function should handle interaction with a payment gateway)
    if ($paymentModel->processPayment($paymentData)) {
        header('Location: payment_success.php');
        exit;
    } else {
        header('Location: payment_failure.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>
    <form method="POST" action="">
        <input type="hidden" name="amount" value="100"> <!-- Replace with dynamic amount -->
        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" id="payment_method">
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <!-- Add more payment methods as needed -->
        </select>
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
