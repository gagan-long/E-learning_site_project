<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not an admin
    exit;
}

$title = "Admin Dashboard";
include_once '../includes/db.php'; // Include database connection
include_once '../includes/header_admin.php'; // Include admin header
?>

<!-- Link to Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
body {
    background-color: #34495e; /* Dark background for contrast */
    color: white; /* White text for readability */
    font-family: Arial, sans-serif;
}

.home {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh; /* Full viewport height */
    text-align: center;
}

h1 {
    margin-top: 20px;
    color: #2ecc71; /* Bright green color */
}

p {
    margin-top: 10px;
    color: #ecf0f1; /* Light grey color */
}

ul {
    list-style-type: none; /* Remove default list styling */
    padding: 0; /* Remove padding */
    display: flex; /* Use flexbox for the list */
    flex-wrap: wrap; /* Allow items to wrap */
    justify-content: center; /* Center items horizontally */
}

.home-li {
    background-color: #2980b9; /* Box background color */
    border-radius: 8px; /* Rounded corners for boxes */
    margin: 15px; /* Space around each box */
    padding: 20px; /* Padding inside each box */
    width: 200px; /* Fixed width for boxes */
    transition: background-color 0.3s ease; /* Smooth transition for hover effect */
}

li:hover {
    background-color: #3498db; /* Change color on hover for better visibility */
}

a {
    text-decoration: none; /* Remove underline from links */
    color: white; /* White text color for links */
    font-size: 18px; /* Increase font size */
}

.icon {
    margin-right: 10px; /* Space between icon and text */
}
</style>

<div class="home">
<h1>Welcome to the Admin Dashboard</h1>
<p>Manage your courses and users from here.</p>
<ul>
    <li class="home-li"><a href="manage_courses.php"><i class="fas fa-book icon"></i>Manage Courses</a></li>
    <li class="home-li"><a href="manage_users.php"><i class="fas fa-users icon"></i>Manage Users</a></li>
    <li class="home-li"><a href="view_messages.php"><i class="fas fa-users icon"></i>feadback / contact</a></li>
    <li class="home-li"><a href="notifications.php"><i class="fas fa-bell icon"></i>Manage Notifications</a></li>
    <!-- <li class="home-li"><a href="settings.php"><i class="fas fa-cog icon"></i>Site Settings</a></li> -->
    <li class="home-li"><a href="manage_enrollments.php"><i class="fas fa-list-alt icon"></i>Enrollment Details</a></li>
</ul>
</div>

<?php include_once '../includes/footer.php'; // Include footer ?>
