<?php

class SettingsModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSettings() {
        // Fetch settings from the database
        $query = "SELECT * FROM settings WHERE id = 1"; // Assuming there's only one row for settings
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateSettings($data) {
        // Update site settings
        $query = "UPDATE settings SET site_name = :site_name, contact_email = :contact_email WHERE id = 1";
        
        $stmt = $this->conn->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':site_name', $data['site_name']);
        $stmt->bindParam(':contact_email', $data['contact_email']);

        return $stmt->execute(); // Return true if successful, false otherwise
    }
}
?>
