<?php
session_start();
include_once '../includes/db.php'; // Include database connection

// Fetch chat messages
$query = "SELECT * FROM chat_messages ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($messages as $message) {
    echo "<div class='" . ($message['is_admin'] ? 'adchatmsg' : 'chatmsg') . "'>";
    echo "<strong>" . htmlspecialchars($message['user_id'] == $_SESSION['user_id'] ? 'You' : 'Admin') . ":</strong> ";
    echo nl2br(htmlspecialchars($message['message'])) . " ";
    echo "<span class='time'>" . htmlspecialchars(substr($message['created_at'], 0, 16)) . "</span>";
    echo "</div>";
}
?>
