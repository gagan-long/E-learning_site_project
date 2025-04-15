<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../user/login.php'); // Redirect to login if not an admin
    exit;
}

include_once '../includes/db.php'; // Include database connection

// Fetch existing notifications
$query = "SELECT * FROM notifications ORDER BY created_at DESC";
$notifications = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

$title = "Manage Notifications";
include_once '../includes/header_admin.php'; // Include admin header
?>
<style>

/* Container Styles */
.container {
    max-width: 1200px; /* Max width for the content */
    margin: 20px auto; /* Center the container */
    padding: 20px; /* Padding inside the container */
    background-color: white; /* White background for content area */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

/* Heading Styles */
h1, h2 {
    color: #333; /* Dark text color for headings */
}

/* Add Notification Button Styles */
.add-notification {
    display: inline-block; /* Make it a block element for padding */
    margin-bottom: 20px; /* Space below the button */
    padding: 10px 15px; /* Padding inside the button */
    background-color: #5FCF80; /* Green background for button */
    color: white; /* White text color */
    text-decoration: none; /* Remove underline from link */
    border-radius: 5px; /* Rounded corners for button */
}

.add-notification:hover {
    background-color: #4CAF50; /* Darker green on hover */
}

/* Table Styles */
table {
    width: 100%; /* Full width table */
    border-collapse: collapse; /* Remove space between borders */
}

th, td {
    padding: 12px; /* Padding inside table cells */
    text-align: left; /* Align text to the left */
    border-bottom: 1px solid #ddd; /* Light gray border between rows */
}

th {
    background-color: #5FCF80; /* Green background for header */
    color: white; /* White text color for header */
}

tr:hover {
    background-color: #f1f1f1; /* Light gray background on row hover */
}

/* Link Styles */
.delete-link {
    color: #dc3545; /* Red color for delete link to indicate action */
}

.delete-link:hover {
    text-decoration: underline; /* Underline on hover for visibility */
}

</style>
<div class="container">
    <h1>Manage Notifications</h1>

    <a href="send_notification.php" class="add-notification">Add Notification</a>

    <h2>Existing Notifications</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Message</th>
                <th>User ID</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notifications as $notification): ?>
                <tr>
                    <td><?php echo htmlspecialchars($notification['id']); ?></td>
                    <td><?php echo htmlspecialchars($notification['message']); ?></td>
                    <td><?php echo htmlspecialchars($notification['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($notification['created_at']); ?></td>
                    <td><a href="delete_notification.php?id=<?php echo $notification['id']; ?>" class="delete-link">Delete</a></td> <!-- Add delete functionality -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once '../includes/footer.php'; // Include footer ?>
