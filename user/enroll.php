<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php'); // Redirect to login if not logged in
    exit;
}

$title = "Enroll in Course";
include_once '../includes/user_header.php'; // Include header
include_once '../includes/db.php'; // Include database connection

// Fetch course details based on ID from the database
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
    error_log("Database error: " . $e->getMessage());
    die("Unable to fetch course details at this time. Please try again later.");
}

// Check if the user is already enrolled in this course
$userId = $_SESSION['user_id'];
$checkEnrollmentQuery = "SELECT * FROM enrollments WHERE user_id = :user_id AND course_id = :course_id";
$checkEnrollmentStmt = $conn->prepare($checkEnrollmentQuery);
$checkEnrollmentStmt->bindParam(':user_id', $userId);
$checkEnrollmentStmt->bindParam(':course_id', $courseId);
$checkEnrollmentStmt->execute();
$isEnrolled = $checkEnrollmentStmt->fetch(PDO::FETCH_ASSOC);

// Initialize variable for success message
$successMessage = ""; // Variable to hold success message

// Handle enrollment logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll'])) {
    if ($isEnrolled) {
        echo "<p class='error-message'>You are already enrolled in this course.</p>";
    } else {
        try {
            // Save enrollment to the database
            $enrollmentQuery = "INSERT INTO enrollments (user_id, course_id) VALUES (:user_id, :course_id)";
            $enrollmentStmt = $conn->prepare($enrollmentQuery);
            $enrollmentStmt->bindParam(':user_id', $userId);
            $enrollmentStmt->bindParam(':course_id', $courseId);

            if ($enrollmentStmt->execute()) {
                // Update success message to indicate successful enrollment
                $successMessage = "You have successfully enrolled in " . htmlspecialchars($course['title']) . "!";
            } else {
                echo "<p class='error-message'>Failed to enroll in the course. Please try again.</p>";
            }
        } catch (PDOException $e) {
            error_log("Enrollment error: " . $e->getMessage());
            echo "<p class='error-message'>There was an error processing your enrollment. Please try again later.</p>";
        }
    }
}
?>

<style>
.enroll-container {
    max-width: 800px;
    margin: auto;
    margin-top: 20px;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 { color: #333; }
.course-description { color: #555; line-height: 1.6; }
form { margin-bottom: 20px; }

form label { display: block; margin-bottom: 5px; }
form input[type='text'], form select { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-bottom: 15px; }

button { padding: 10px 15px; background-color: #5FCF80; color: white; border: none; border-radius: 5px; cursor: pointer; }
button:hover { background-color: #4CAF50; }

.error-message { text-align: center; color: red; font-weight: bold; }
.success-message { text-align: center; color: green; font-weight: bold; }

@media (max-width: 768px) { .enroll-container { padding: 15px; } }
</style>

<div class="enroll-container">
    <h1>Enroll in <?php echo htmlspecialchars($course['title']); ?></h1>
    <p class="course-description"><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>

    <form method="POST" action="">
        <button type="submit" name="enroll">Enroll Now</button>
    </form>

    <?php if ($successMessage): ?>
        <p class='success-message'><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <a href="../courses.php">Back to Courses</a>
</div>

<?php include_once '../includes/footer.php'; // Include footer ?>
