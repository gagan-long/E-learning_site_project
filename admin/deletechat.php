<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
   header('Location: login.php'); // Redirect to login if not an admin
   exit;
}

include_once '../includes/db.php'; // Include database connection

// Delete all chat messages from the database
$query = "DELETE FROM chat_messages";
$stmt = $conn->prepare($query);
$stmt->execute();

header('Location: admin_chat.php'); // Redirect back to the admin chat page after deletion
exit;
?>
