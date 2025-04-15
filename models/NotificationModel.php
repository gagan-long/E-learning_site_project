<?php

class NotificationModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllNotifications() {
        // Fetch all notifications
        return [];
    }

    public function addNotification($data) {
       // Add a new notification
       return true;
    }

    public function deleteNotification($id) {
       // Delete notification by ID
       return true;
    }
}
?>
