<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../user/login.php'); // Redirect to login if not an admin
    exit;
}

include_once '../includes/db.php'; // Include database connection

// Fetch existing categories for the dropdown
$categoriesQuery = "SELECT * FROM categories";
$categories = $conn->query($categoriesQuery)->fetchAll(PDO::FETCH_ASSOC);

// Fetch the course to be edited
if (isset($_GET['id'])) {
    $courseId = intval($_GET['id']);
    $query = "SELECT * FROM courses WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $courseId);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$course) {
        die("Course not found.");
    }
} else {
    die("Invalid course ID.");
}

// Handle course update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $category_id = $_POST['category_id'];

    // Handle file uploads
    $imagePath = null;
    $pdfPath = null;
    $videoPath = null;

    // Check if files are uploaded and process them
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Process image upload
        $imagePath = 'uploads/images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
        // Process PDF upload
        $pdfPath = '../uploads/pdfs/' . basename($_FILES['pdf']['name']);
        move_uploaded_file($_FILES['pdf']['tmp_name'], $pdfPath);
    }

    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        // Process video upload
        $videoPath = '../uploads/videos/' . basename($_FILES['video']['name']);
        move_uploaded_file($_FILES['video']['tmp_name'], $videoPath);
    }

    // Update course in the database
    $updateQuery = "UPDATE courses SET title = :title, description = :description, category_id = :category_id" .
                   ($imagePath ? ", image_path = :image_path" : "") .
                   ($pdfPath ? ", pdf_path = :pdf_path" : "") .
                   ($videoPath ? ", video_path = :video_path" : "") . 
                   " WHERE id = :id";

    $updateStmt = $conn->prepare($updateQuery);
    
    // Bind parameters
    $updateStmt->bindParam(':title', $title);
    $updateStmt->bindParam(':description', $description);
    $updateStmt->bindParam(':category_id', $category_id);
    
    if ($imagePath) {
        $updateStmt->bindParam(':image_path', $imagePath);
    }
    
    if ($pdfPath) {
        $updateStmt->bindParam(':pdf_path', $pdfPath);
    }
    
    if ($videoPath) {
        $updateStmt->bindParam(':video_path', $videoPath);
    }

    $updateStmt->bindParam(':id', $courseId);

    if ($updateStmt->execute()) {
        header('Location: manage_courses.php'); // Redirect after successful update
        exit;
    } else {
        $errorMessage = "Failed to update course.";
    }
}

$title = "Edit Course";
include_once '../includes/header_admin.php'; // Include admin header
?>

<style>
/* General Styles */

/* Dashboard Container */
.dashboard-container {
    max-width: 800px; /* Limit width for better readability */
    margin: 20px auto; /* Center the container */
    padding: 20px; /* Padding inside the container */
    background-color: transparent; 
    border-radius: 8px; /* Rounded corners */
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
form select,
form textarea,
form input[type="file"] {
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
}

/* Success Message Styles */
.success-message {
   color: green;
   font-weight: bold;
}
</style>

<div class="dashboard-container">
<h1>Edit Course</h1>

<?php if (isset($errorMessage)): ?>
<p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
<?php endif; ?>

<form method="POST" action="" enctype="multipart/form-data">
    <label for="title">Course Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo htmlspecialchars($course['description']); ?></textarea>

    <label for="category_id">Category:</label>
    <select name="category_id" required>
       <?php foreach ($categories as $category): ?>
           <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo ($category['id'] == $course['category_id']) ? 'selected' : ''; ?>>
               <?php echo htmlspecialchars($category['name']); ?>
           </option>
       <?php endforeach; ?>
   </select>

   <label for="image">Update Image:</label>
   <input type="file" name="image" accept="image/*">

   <label for="pdf">Update PDF:</label>
   <input type="file" name="pdf" accept=".pdf">

   <label for="video">Update Video:</label>
   <input type="file" name="video" accept="video/*">

   <button type="submit">Update Course</button>
</form>

<a href="manage_courses.php">Back to Manage Courses</a>
</div>

<?php include_once '../includes/footer.php'; // Include footer ?>
