<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}
$title = "Course Details";
include_once 'includes/header_user.php'; // Include header

// Fetch course details based on ID from the database
include_once 'includes/db.php';
$courseId = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($courseId === null) {
    die("Invalid course ID.");
}

try {
    $query = "SELECT * FROM courses WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $courseId);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        die("Course not found.");
    }
} catch (PDOException $e) {
    // Log the error and display a friendly message
    error_log("Database error: " . $e->getMessage());
    die("Unable to fetch course details at this time. Please try again later.");
}
?>
<style>




/* Course Detail Container */
.course-detail-container {
    max-width: 800px; /* Limit width for better readability */
    margin: auto; /* Center the container horizontally */
    margin-top: 20px; /* Space from top */
    padding: 20px; /* Padding inside the container */
    background-color: white; /* White background for contrast */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
    min-height: calc(100vh - 80px); /* Full height minus margins */
    display: flex;
    flex-direction: column;
    justify-content: center; /* Center content vertically */
}

/* Main Heading */
h1 {
    font-size: 4rem;
    color: #333; /* Dark color for the heading */
}

/* Course Image Styles */
.course-image {
    max-width: 100%; 
    height: 40vh;
    border-radius: 5px; /* Rounded corners for images */
}

/* Course Description Styles */
.course-description {
    margin-top: 5vh;
    color: #555; /* Slightly lighter color for description text */
    line-height: 1.6; /* Improved line height for readability */
}

/* Enroll Button Styles */
.enroll-button {
   display: inline-block;
   margin-top: 7vh;
   padding: 10px 15px;
   text-align: center;
   background-color: #5FCF80; /* Green button color */
   color: white;
   text-decoration: none;
   border-radius: 5px;
   transition: background-color 0.3s ease;
}

.enroll-button:hover {
   background-color: #4CAF50; /* Darker green on hover */
}

/* Responsive Design Adjustments */
@media (max-width: 768px) {
   .course-detail-container {
       padding: 15px; /* Reduce padding on smaller screens */
   }
}

</style>
<div class="course-detail-container">
    <h1><?php echo htmlspecialchars($course['title']); ?></h1>

    <?php if (!empty($course['image_path'])): ?>
        <img src="<?php echo htmlspecialchars($course['image_path']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>" class="course-image">
    <?php else: ?>
        <p>No image available for this course.</p>
    <?php endif; ?>

    <p class="course-description"><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>

    <a href="user/enroll.php?id=<?php echo htmlspecialchars($courseId); ?>" class="enroll-button">Enroll Now</a>
</div>

<?php include_once 'includes/footer.php'; // Include footer ?>
