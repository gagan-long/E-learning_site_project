<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
   header('Location: ../user/login.php'); // Redirect to login if not an admin
   exit;
}

include_once '../includes/db.php'; // Include database connection

// Handle course deletion
if (isset($_GET['id'])) {
   $courseId = intval($_GET['id']);
   // Prepare and execute delete query
   $deleteQuery = "DELETE FROM courses WHERE id = :id";
   $stmt = $conn->prepare($deleteQuery);
   $stmt->bindParam(':id', $courseId);

   if ($stmt->execute()) {
       header('Location: manage_courses.php'); // Redirect after successful deletion
       exit;
   } else {
       die("Failed to delete course.");
   }
} else {
   die("Invalid course ID.");
}
?>
