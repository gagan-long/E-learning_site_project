<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../user/login.php'); // Redirect to login if not an admin
    exit;
}

include_once '../includes/db.php'; // Include database connection

// Fetch existing users for display
$query = "SELECT * FROM users";
$users = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

$title = "Manage Users";
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
.edit-link, .delete-link {
    text-decoration: none; /* Remove underline from links */
}

.edit-link {
    color: #007bff; /* Blue color for edit link */
}

.delete-link {
    color: #dc3545; /* Red color for delete link */
}

.edit-link:hover,
.delete-link:hover {
    text-decoration: underline; /* Underline on hover for visibility */
}

</style>
<div class="container">
    <h1>Manage Users</h1>

    <h2>Existing Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="edit-link">Edit</a> |
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once '../includes/footer.php'; // Include footer ?>
