<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../user/login.php'); // Redirect to login if not an admin
    exit;
}

include_once '../includes/db.php'; // Include database connection

// Handle notification deletion
if (isset($_GET['id'])) {
    $notificationId = intval($_GET['id']);
    // Prepare and execute delete query
    $deleteQuery = "DELETE FROM notifications WHERE id = :id";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bindParam(':id', $notificationId);

    if ($stmt->execute()) {
        header('Location: notifications.php'); // Redirect after successful deletion
        exit;
    } else {
        die("Failed to delete notification.");
    }
} else {
    die("Invalid notification ID.");
}
?>
