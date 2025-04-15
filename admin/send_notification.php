<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not an admin
    exit;
}

$title = "Send Notification";
include_once '../includes/header_admin.php'; // Include admin header
include_once '../includes/db.php'; // Include database connection
include_once 'email.php'; // Include email functions

// Fetch all courses for selection
$coursesQuery = "SELECT id, title FROM courses";
$coursesStmt = $conn->prepare($coursesQuery);
$coursesStmt->execute();
$courses = $coursesStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle notification sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'], $_POST['course_id'])) {
    $courseId = intval($_POST['course_id']);
    $message = htmlspecialchars(trim($_POST['message']));

    // Fetch all users enrolled in the selected course
    $usersQuery = "SELECT user_id FROM enrollments WHERE course_id = :course_id";
    $usersStmt = $conn->prepare($usersQuery);
    $usersStmt->bindParam(':course_id', $courseId);
    $usersStmt->execute();
    $enrolledUsers = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

    // Insert notification for each enrolled user and send email
    foreach ($enrolledUsers as $user) {
        // Insert notification into database
        $insertQuery = "INSERT INTO notifications (course_id, user_id, message) VALUES (:course_id, :user_id, :message)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':course_id', $courseId);
        $insertStmt->bindParam(':user_id', $user['user_id']);
        $insertStmt->bindParam(':message', $message);
        $insertStmt->execute();

        // Fetch user's email address (assuming you have a users table)
        $emailQuery = "SELECT email FROM users WHERE id = :user_id";
        $emailStmt = $conn->prepare($emailQuery);
        $emailStmt->bindParam(':user_id', $user['user_id']);
        $emailStmt->execute();
        $userEmail = $emailStmt->fetchColumn();

        // Send email notification using the new function
        if ($userEmail) {
            sendNotificationEmail($userEmail, nl2br($message));
        }
    }

    echo "<p style='color:green; text-anign:center;'>Notification sent successfully!</p>";
}
?>
<style>
/* General Styles */

/* Dashboard Container */
.dashboard-container {
    height: 60vh;
    max-width: 1200px; /* Limit width for better readability */
    margin: 50px auto; /* Center the container vertically and horizontally */
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
    display: flex;
    flex-direction: column; /* Stack form elements vertically */
    margin-bottom: 4vh;
    gap: 2vh;
}

form label {
    color: #ccc;
    margin-bottom: 5px; /* Space below labels */
}

form select,
form textarea {
    width: 100%; /* Full width inputs */
    padding: 10px; /* Padding inside inputs */
    border-radius: 5px; /* Rounded corners for inputs */
    border: 1px solid #ccc; /* Border color */
    margin-bottom: 15px; /* Space below inputs */
}
form textarea {
    height: 20vh;
}

/* Button Styles */
button {
    /* width: 60%; */
    padding: 10px;
    background-color: #5FCF80; /* Green button color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer; /* Pointer cursor on hover */
}

button:hover {
    background-color: #4CAF50; /* Darker green on hover */
}

/* Success Message Styles */
.success-message {
   color: green;
   font-weight: bold;
   text-align: center; /* Center align success message */
}

/* Error Message Styles (if needed) */
.error-message {
   color: red;
   font-weight: bold;
   text-align: center; /* Center align error message */
}

/* Responsive Design Adjustments */
@media (max-width: 768px) {
   .dashboard-container {
       padding: 15px; /* Reduce padding on smaller screens */
   }
}
</style>
<div class="dashboard-container">
<h1>Send Notification</h1>

<?php if (isset($successMessage)): ?>
<p class="success-message"><?php echo htmlspecialchars($successMessage); ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label for="course">Select Course:</label>
    <select name="course_id" required>
        <?php foreach ($courses as $course): ?>
            <option value="<?php echo htmlspecialchars($course['id']); ?>"><?php echo htmlspecialchars($course['title']); ?></option>
        <?php endforeach; ?>
    </select>

    <label for="message">Message:</label>
    <textarea name="message" required></textarea>

    <button type="submit" class="btn btn-success">Send Notification</button>
</form>

<a href="admin_dashboard.php">Back to Dashboard</a>
</div>

<?php include_once '../includes/footer.php'; // Include footer ?>
