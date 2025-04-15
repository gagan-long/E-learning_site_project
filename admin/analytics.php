<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../user/login.php'); // Redirect to login if not an admin
    exit;
}

include_once '../includes/db.php'; // Include database connection

// Example queries for analytics (you can customize these)
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$totalCoursesQuery = "SELECT COUNT(*) AS total_courses FROM courses";
$totalPaymentsQuery = "SELECT COUNT(*) AS total_payments FROM payments";

$totalUsers = $conn->query($totalUsersQuery)->fetch(PDO::FETCH_ASSOC);
$totalCourses = $conn->query($totalCoursesQuery)->fetch(PDO::FETCH_ASSOC);
$totalPayments = $conn->query($totalPaymentsQuery)->fetch(PDO::FETCH_ASSOC);

$title = "Analytics Dashboard";
include_once '../includes/header_admin.php'; // Include admin header
?>

<h1>Analytics Dashboard</h1>

<ul>
<li>Total Users: <?php echo htmlspecialchars($totalUsers['total_users']); ?></li>
<li>Total Courses: <?php echo htmlspecialchars($totalCourses['total_courses']); ?></li>
<li>Total Payments: <?php echo htmlspecialchars($totalPayments['total_payments']); ?></li>
<!-- Add more metrics as needed -->
</ul>

<?php include_once '../includes/footer.php'; // Include footer ?>
