<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

$title = "User Dashboard";
include_once '../includes/user_header.php'; // Include header
include_once '../includes/db.php'; // Include database connection

// Fetch user data from the database
$userId = $_SESSION['user_id'];
$query = "SELECT name, email, profile_image FROM users WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Initialize user data
$userName = $user['name'];
$currentProfileImage = $user['profile_image'];

// Fetch enrolled courses for the user
$coursesQuery = "SELECT c.id, c.title, c.pdf_path, c.video_path 
                 FROM enrollments e 
                 JOIN courses c ON e.course_id = c.id 
                 WHERE e.user_id = :user_id";
$coursesStmt = $conn->prepare($coursesQuery);
$coursesStmt->bindParam(':user_id', $userId);
$coursesStmt->execute();
$enrolledCourses = $coursesStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<style>


/* Dashboard Container */
.dashboard-container {
    max-width: 900px; /* Limit width for better readability */
    margin: 20px auto; /* Center the container */
    padding: 20px; /* Padding inside the container */
    background-color: transparent; /* White background for contrast */
    backdrop-filter: blur(8px);
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
}

/* Main Heading */
h1,h2,p {
    text-align: center;
    color: #fff; /* Dark color for the heading */
}
#notic{
    text-align: left;
    color: black;
}

/* Profile Section */
.profile-section {
    text-align: center; /* Center align profile image and text */
}

.profile-image {
    max-width: 200px; /* Limit profile image size */
    height: auto;
    border-radius: 50%; /* Make it circular */
}

/* Notifications Section */
#notifications {
    border: 1px solid #ccc; /* Border around notifications */
    padding: 10px;
    margin-bottom: 20px;
}

.notification {
    background-color: #e7f3fe; /* Light blue background for notifications */
    border-left: 5px solid #2196F3; /* Blue left border for emphasis */
    padding: 10px;
    margin-bottom: 10px;
}

/* General Styles */



/* Course Container */
.course-container {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 900px;
    margin: auto;
}

/* Heading */
.course-container h2 {
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
}

/* Course List */
.course-list {
    list-style-type: none;
    padding-left: 0;
}

/* Course List Items */
.course-list li {
    background-color: #e9ecef;
    border-radius: 5px;
    margin-bottom: 15px;
    padding: 15px;
    transition: background-color 0.3s ease;
}

/* Hover Effect for Course Items */
.course-list li:hover {
    background-color: #d1d1d1; /* Change color on hover */
}

/* Course Links */
.course-list a {
    text-decoration: none;
    color: #007bff; /* Bootstrap primary color */
    font-weight: bold;
}

.course-list a:hover {
    text-decoration: underline; /* Underline on hover */
}

/* Course Details List */
.course-details {
    list-style-type: none;
    padding-left: 0;
    margin-top: 10px; /* Space above details */
}

/* Course Details Links */
.course-details a {
    color: #28a745; /* Green color for download/video links */
}

.course-details a:hover {
    text-decoration: underline; /* Underline on hover */
}

/* Logout Button */
.logout-button {
    display: inline-block;
    background-color: #dc3545; /* Bootstrap danger color */
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    margin-top: 20px; /* Space above button */
}

.logout-button:hover {
    background-color: #c82333; /* Darker red on hover */
}

/* Responsive Design Adjustments */
@media (max-width: 768px) {
   .dashboard-container {
       padding: 15px; /* Reduce padding on smaller screens */
   }

   .profile-image {
       max-width: 150px; /* Smaller image on mobile screens */
   }
}

</style>
<div class="dashboard-container">
    <h1>Welcome, <?php echo htmlspecialchars($userName); ?>!</h1>

    <div class="profile-section">
        <?php if ($currentProfileImage): ?>
            <h3>Your Profile Image:</h3>
            <img src="<?php echo htmlspecialchars($currentProfileImage); ?>" alt="Profile Image" class="profile-image">
        <?php else: ?>
            <h3>No Profile Image Available</h3>
        <?php endif; ?>
    </div>

    <p>This is your dashboard.</p>

    <h2>Your Notifications</h2>
    <div id="notifications">
        <?php
        // Fetch notifications for the logged-in user based on their enrollments
        if (isset($_SESSION['user_id'])) {
            // Fetch user enrolled courses
            $enrolledCoursesQuery = "SELECT course_id FROM enrollments WHERE user_id = :user_id";
            $enrolledCoursesStmt = $conn->prepare($enrolledCoursesQuery);
            $enrolledCoursesStmt->bindParam(':user_id', $userId);
            $enrolledCoursesStmt->execute();
            $enrolledCoursesIds = $enrolledCoursesStmt->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($enrolledCoursesIds)) {
                // Fetch notifications for these courses
                $placeholders = implode(',', array_fill(0, count($enrolledCoursesIds), '?'));
                $notificationsQuery = "SELECT * FROM notifications WHERE course_id IN ($placeholders) ORDER BY created_at DESC";
                $notificationsStmt = $conn->prepare($notificationsQuery);
                $notificationsStmt->execute($enrolledCoursesIds);
                $notifications = $notificationsStmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($notifications as $notification) {
                    echo "<div class='notification'>";
                    echo "<p id='notic'>" . htmlspecialchars($notification['message']) . "</p>";
                    echo "<small>" . htmlspecialchars($notification['created_at']) . "</small>";
                    echo "</div>";
                }
            } else {
                echo "<p>No notifications available.</p>";
            }
        }
        ?>
    </div>

    <div class="course-container">
    <h2>Your Enrolled Courses</h2>
    <ul class="course-list">
        <?php if (count($enrolledCourses) > 0): ?>
            <?php foreach ($enrolledCourses as $course): ?>
                <li>
                    <a href="course_detail.php?id=<?php echo htmlspecialchars($course['id']); ?>">
                        <?php echo htmlspecialchars($course['title']); ?>
                    </a>
                    <ul class="course-details">
                        <?php if (!empty($course['pdf_path'])): ?>
                            <li><a href="<?php echo htmlspecialchars($course['pdf_path']); ?>" target="_blank">Download PDF</a></li>
                        <?php endif; ?>
                        <?php if (!empty($course['video_path'])): ?>
                            <li><a href="<?php echo htmlspecialchars($course['video_path']); ?>" target="_blank">Watch Video</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>You are not enrolled in any courses.</li>
        <?php endif; ?>
    </ul>

    <a href="logout.php" class="logout-button">Logout</a>
</div>


<?php include_once '../includes/footer.php'; // Include footer ?>





