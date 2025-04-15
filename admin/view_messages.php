<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not an admin
    exit;
}

$title = "View Messages";
include_once '../includes/header_admin.php'; // Include admin header
include_once '../includes/db.php'; // Include database connection

// Fetch all contact messages from the database
$query = "SELECT * FROM contact_messages ORDER BY created_at DESC"; // Assuming you have a created_at column
$stmt = $conn->prepare($query);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
h1 {
    color: #333; /* Dark text color for headings */
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
.back-link {
    display: inline-block; /* Make it a block element for padding */
    margin-top: 20px; /* Space above the link */
    padding: 10px 15px; /* Padding inside the link */
    background-color: #007bff; /* Blue background for button-like appearance */
    color: white; /* White text color */
    text-decoration: none; /* Remove underline from link */
    border-radius: 5px; /* Rounded corners for button-like appearance */
}

.back-link:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

</style>
<div class="container">
    <h1>Contact Messages</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($messages) > 0): ?>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($message['name']); ?></td>
                        <td><?php echo htmlspecialchars($message['email']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                        <td><?php echo htmlspecialchars($message['created_at']); ?></td> <!-- Assuming you have a created_at column -->
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No messages found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="index.php" class="back-link">Back to Dashboard</a>
</div>

<?php include_once '../includes/footer.php'; // Include footer ?>
