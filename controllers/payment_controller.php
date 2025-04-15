<?php

class PaymentController {
    private PaymentModel $paymentModel;

    public function __construct(PaymentModel $paymentModel) {
        $this->paymentModel = $paymentModel;
    }

    public function processPayment(array $data) {
        // Validate payment data
        if (!isset($data['user_id'], $data['course_id'], $data['amount'], $data['payment_method'])) {
            return ['success' => false, 'message' => 'Invalid payment data.'];
        }

        // Simulate payment processing (replace with actual payment gateway integration)
        // For demonstration purposes, we assume the payment is successful.
        
        // Here you would typically call a payment gateway API to process the payment.
        // For example:
        // $paymentGatewayResponse = $this->callPaymentGateway($data);

        // Assuming payment is successful for demonstration purposes
        $status = 'success';  // Change this based on actual payment processing result

        // Add payment record to the database
        if ($this->paymentModel->addPayment(
            $data['user_id'],
            $data['course_id'],
            floatval($data['amount']),
            htmlspecialchars($data['payment_method']),
            $status
        )) {
            return ['success' => true, 'message' => 'Payment processed successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to record payment.'];
        }
    }

    // Optional: Add a method to call the payment gateway
    /*
    private function callPaymentGateway(array $data) {
        // Implement actual payment gateway API call here
    }
    */
}
?>
