<?php
session_start();


include_once '../includes/db.php'; // Include database connection

// Delete all chat messages from the database
$query = "DELETE FROM chat_messages";
$stmt = $conn->prepare($query);
$stmt->execute();

header('Location: chat.php'); // Redirect back to the admin chat page after deletion
exit;
?>
