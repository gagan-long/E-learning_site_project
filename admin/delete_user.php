<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
   header('Location: ../user/login.php'); // Redirect to login if not an admin
   exit;
}

include_once '../includes/db.php'; // Include database connection

// Handle user deletion
if (isset($_GET['id'])) {
   $userId = intval($_GET['id']);
   // Prepare and execute delete query
   $deleteQuery = "DELETE FROM users WHERE id = :id";
   $stmt = $conn->prepare($deleteQuery);
   $stmt->bindParam(':id', $userId);

   if ($stmt->execute()) {
       header('Location: manage_users.php'); // Redirect after successful deletion
       exit;
   } else {
       die("Failed to delete user.");
   }
} else {
   die("Invalid user ID.");
}
?>
