<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../user/login.php'); // Redirect to login if not an admin
    exit;
}

include_once '../includes/db.php'; // Include database connection

// Fetch the user to be edited
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        die("User not found.");
    }
} else {
    die("Invalid user ID.");
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update user details
    $updateQuery = "UPDATE users SET name = :name, email = :email, role = :role WHERE id = :id";
    
    $updateStmt = $conn->prepare($updateQuery);
    
    $updateStmt->bindParam(':name', $name);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':role', $role);
    $updateStmt->bindParam(':id', $userId);

    if ($updateStmt->execute()) {
        header('Location: manage_users.php'); // Redirect after successful update
        exit;
    } else {
        $errorMessage = "Failed to update user.";
    }
}

$title = "Edit User";
include_once '../includes/header_admin.php'; // Include admin header
?>


<style>
/* General Styles */

/* Dashboard Container */
.dashboard-container {
    max-width: 800px; /* Limit width for better readability */
    margin: 20px auto; /* Center the container */
    padding: 20px; /* Padding inside the container */
    background-color: transparent; /* White background for contrast */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
}

/* Main Heading */
h1 {
    color: #fff; /* Dark color for the heading */
}

/* Form Styles */
form {
    margin-bottom: 20px; /* Space below the form */
}

form label {
    color: #ccc;
    display: block; /* Make labels block elements */
    margin-bottom: 5px; /* Space below labels */
}

form input[type="text"],
form input[type="email"],
form select {
    width: 100%; /* Full width inputs */
    padding: 10px; /* Padding inside inputs */
    border-radius: 5px; /* Rounded corners for inputs */
    border: 1px solid #ccc; /* Border color */
    margin-bottom: 15px; /* Space below inputs */
}

/* Button Styles */
button {
    padding: 10px 15px;
    background-color: #5FCF80; /* Green button color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer; /* Pointer cursor on hover */
}

button:hover {
    background-color: #4CAF50; /* Darker green on hover */
}

/* Error Message Styles */
.error-message {
   color: red;
   font-weight: bold;
   text-align: center; /* Center align error message */
}

/* Success Message Styles (if needed) */
.success-message {
   color: green;
   font-weight: bold;
   text-align: center; /* Center align success message */
}

/* Responsive Design Adjustments */
@media (max-width: 768px) {
   .dashboard-container {
       padding: 15px; /* Reduce padding on smaller screens */
   }
}

</style>
<div class="dashboard-container">
<h1>Edit User</h1>

<?php if (isset($errorMessage)): ?>
<p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

    <label for="role">Role:</label>
    <select name="role">
        <option value="student" <?php echo ($user['role'] == 'student') ? 'selected' : ''; ?>>Student</option>
        <option value="instructor" <?php echo ($user['role'] == 'instructor') ? 'selected' : ''; ?>>Instructor</option>
        <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
    </select>

    <button type="submit">Update User</button>
</form>
</div>


<?php include_once '../includes/footer.php'; // Include footer ?>
