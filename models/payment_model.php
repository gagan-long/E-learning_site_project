<?php

class PaymentModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addPayment($userId, $courseId, $amount, $paymentMethod, $status) {
        try {
            $query = "INSERT INTO payments (user_id, course_id, amount, payment_method, status) VALUES (:user_id, :course_id, :amount, :payment_method, :status)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':course_id', $courseId);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':payment_method', $paymentMethod);
            $stmt->bindParam(':status', $status);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Payment error: " . $e->getMessage());
            return false;
        }
    }
}
?>
