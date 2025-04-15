<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../user/login.php'); // Redirect to login if not an admin
    exit;
}

include_once '../includes/db.php'; // Include database connection

// Fetch existing categories for display
$categoriesQuery = "SELECT * FROM categories";
$categories = $conn->query($categoriesQuery)->fetchAll(PDO::FETCH_ASSOC);

// Handle course addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $category_id = $_POST['category_id'];

    // Check if category ID exists
    $checkCategoryQuery = "SELECT id FROM categories WHERE id = :category_id";
    $checkStmt = $conn->prepare($checkCategoryQuery);
    $checkStmt->bindParam(':category_id', $category_id);
    $checkStmt->execute();

    if ($checkStmt->rowCount() === 0) {
        $errorMessage = "Invalid category ID.";
    } else {
        // Handle file uploads
        $imagePath = null;
        $pdfPath = null;
        $videoPath = null;

        // Upload course image
        if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = '../uploads/images/' . basename($_FILES['course_image']['name']);
            move_uploaded_file($_FILES['course_image']['tmp_name'], $imagePath);
        }

        // Upload course PDF
        if (isset($_FILES['course_pdf']) && $_FILES['course_pdf']['error'] === UPLOAD_ERR_OK) {
            $pdfPath = '../uploads/pdfs/' . basename($_FILES['course_pdf']['name']);
            move_uploaded_file($_FILES['course_pdf']['tmp_name'], $pdfPath);
        }

        // Upload course video
        if (isset($_FILES['course_video']) && $_FILES['course_video']['error'] === UPLOAD_ERR_OK) {
            $videoPath = '../uploads/videos/' . basename($_FILES['course_video']['name']);
            move_uploaded_file($_FILES['course_video']['tmp_name'], $videoPath);
        }
        // Insert course data into the database
        $query = "INSERT INTO courses (title, description, category_id, image_path, pdf_path, video_path) VALUES (:title, :description, :category_id, :image_path, :pdf_path, :video_path)";
        $stmt = $conn->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        
        // Bind multimedia paths (or NULL if not uploaded)
        $stmt->bindParam(':image_path', $imagePath);
        $stmt->bindParam(':pdf_path', $pdfPath);
        $stmt->bindParam(':video_path', $videoPath);
        
        if ($stmt->execute()) {
            $successMessage = "Course added successfully!";
        } else {
            $errorMessage = "Failed to add course.";
        }
    }
}

// Handle course deletion
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    try {
        // Delete course from the database
        $deleteQuery = "DELETE FROM courses WHERE id = :id";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bindParam(':id', $deleteId);

        if ($deleteStmt->execute()) {
            header("Location: manage_courses.php"); // Redirect after deletion
            exit;
        } else {
            $errorMessage = "Failed to delete course.";
        }
    } catch (PDOException $e) {
        error_log("Deletion error: " . $e->getMessage());
        $errorMessage = "There was an error deleting the course.";
    }
}

// Fetch existing courses for display
$query = "SELECT * FROM courses";
$courses = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

$title = "Manage Courses";
include_once '../includes/header_admin.php'; // Include admin header
?>

<style>

/* Dashboard Container */
.dashboard-container {
    max-width: 1000px; /* Limit width for better readability */
    margin: 20px auto; /* Center the container */
    padding: 20px; /* Padding inside the container */
    background-color: white; /* White background for contrast */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
}

/* Main Heading */
h1 {
    color: #333; /* Dark color for the heading */
}

/* Form Styles */
form {
    margin-bottom: 20px; /* Space below the form */
}

form label {
    display: block; /* Make labels block elements */
    margin-bottom: 5px; /* Space below labels */
}

form input[type="text"],
form input[type="file"],
form select,
form textarea {
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

/* Table Styles */
table {
   width: 100%; /* Full width table */
   border-collapse: collapse; /* Collapse borders between cells */
}

th, td {
   padding: 10px;
   text-align: left;
   border-bottom: 1px solid #ccc; /* Bottom border between rows */
}

th {
   background-color: #5FCF80; /* Green background for header cells */
   color: white;
}
</style>

<div class="dashboard-container">
<h1>Manage Courses</h1>

<?php if (isset($successMessage)): ?>
<p class="success-message"><?php echo htmlspecialchars($successMessage); ?></p>
<?php endif; ?>

<?php if (isset($errorMessage)): ?>
<p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
<?php endif; ?>

<h2>Add New Course</h2>
<form method="POST" action="" enctype="multipart/form-data">
    <label for="title">Course Title:</label>
    <input type="text" name="title" required>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea>

    <label for="category_id">Category:</label>
    <select name="category_id" required>
       <?php foreach ($categories as $category): ?>
           <option value="<?php echo htmlspecialchars($category['id']); ?>"><?php echo htmlspecialchars($category['name']); ?></option>
       <?php endforeach; ?>
    </select>

    <label for="course_image">Course Image:</label>
    <input type="file" name="course_image" accept="image/*">

    <label for="course_pdf">Course PDF:</label>
    <input type="file" name="course_pdf" accept=".pdf">

    <label for="course_video">Course Video:</label>
    <input type="file" name="course_video" accept="video/*">

   <button type="submit" name="add_course">Add Course</button>
</form>

<h2>Existing Courses</h2>
<table>
<tr>
<th>ID</th><th>Title</th><th>Description</th><th>Actions</th></tr>

<?php foreach ($courses as $course): ?>
<tr>
<td><?php echo htmlspecialchars($course['id']); ?></td>
<td><?php echo htmlspecialchars($course['title']); ?></td>
<td><?php echo htmlspecialchars($course['description']); ?></td>
<td>
<a href="edit_course.php?id=<?php echo htmlspecialchars($course['id']); ?> "style=" color:blue;">Edit</a> |
<a href="?delete_id=<?php echo htmlspecialchars($course['id']); ?> "style=" color:red;"  onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
</td>
</tr>
<?php endforeach; ?>

</table>

</div>

<?php include_once '../includes/footer.php'; // Include footer ?>
