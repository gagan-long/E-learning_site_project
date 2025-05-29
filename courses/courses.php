<?php
session_start();


$title = "Available Courses";
include_once 'includes/header_user.php'; // Include header

// Fetch courses from the database
include_once 'includes/db.php';

// Initialize search variables
$searchTitle = '';
$searchCategory = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTitle = trim($_POST['title'] ?? '');
    $searchCategory = trim($_POST['category'] ?? '');
}

try {
    // Prepare the query with optional filters
    $query = "SELECT * FROM courses WHERE 1=1"; // Start with a base query

    // Append conditions based on user input
    if (!empty($searchTitle)) {
        $query .= " AND title LIKE :title";
    }
    if (!empty($searchCategory)) {
        $query .= " AND category = :category"; // Assuming 'category' is a column in your courses table
    }

    $stmt = $conn->prepare($query);

    // Bind parameters if they are set
    if (!empty($searchTitle)) {
        $stmt->bindValue(':title', '%' . $searchTitle . '%');
    }
    if (!empty($searchCategory)) {
        $stmt->bindValue(':category', $searchCategory);
    }

    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error and display a friendly message
    error_log("Database error: " . $e->getMessage());
    $errorMessage = "Unable to fetch courses at this time. Please try again later.";
}
?>

<style>

/* General Styles */


/* Container for Courses */
.course-container {
    height: auto; /* Allow height to adjust based on content */
    max-width: 1200px; /* Limit width for larger screens */
    margin: 20px auto; /* Center the container */
    padding: 20px; /* Padding inside the container */
    background-color: transparent; /* White background for contrast */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
}

/* Main Heading */
h1 {
    color: #5FCF80; /* Dark color for the heading */
    text-align: center;
}

/* Search Form Styles */
form {background-color: transparent;
    margin-top: 20px;
    display: flex;
    flex-direction: column; /* Stack elements vertically on small screens */
    align-items: center; /* Center align form elements */
}

form input[type="text"] {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-bottom: 10px; /* Space below inputs */
    width: calc(100% - 20px); /* Full width input fields with padding adjustment */
}

form button {
    padding: 10px 15px;
    background-color: #5FCF80; /* Green button color */
    color: white;
    border: none;
    border-radius: 5px;
}

/* Error message styles */
.error-message {
   color: red;
   font-weight: bold;
   text-align: center; /* Center align error message */
}

/* Course List Styles */
.course-list {
   display: flex;
   flex-wrap: wrap; /* Allow wrapping of course cards */
   gap: 20px; /* Space between cards */
   justify-content: center; /* Center align cards in the list */
   margin-bottom: 10vh;
}

/* Card styles */
.course-card {
   flex-basis: calc(33.333% - 20px); /* Three cards per row with gap adjustment */
   max-height: 400px; /* Limit height of cards */
   padding: 20px;
   text-align: center;
   background-image: url(resouurces/css/bgimg.svg);
   background-size: cover;
   overflow-y: auto;
   backdrop-filter: blur(8px);
   border-radius: 10px;
   box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
   transition: transform 0.3s ease;
}

.course-card:hover {
   transform: translateY(-5px); /* Lift effect on hover */
}

.course-image {
   height: auto; /* Allow images to scale proportionally */
   max-height: 150px; /* Set a max height for images to maintain layout consistency */
   border-radius: 5px; /* Rounded corners for images */
}

.course-content {
   padding-top: 10px;
}

.course-title {
    color: #fff; /* Darker color for better readability */
    margin-bottom: 2vh;
    font-size: 1.5em; 
}

.course-description {
   color: gray; 
}

/* Button Styles for Viewing Course */
.view-course-button {
   width: auto;
   display: inline-block;
   margin-top: 10px;
   padding: 10px 15px;
   background-color: #5FCF80; 
   color: black;
   text-decoration: none;
   border-radius: 5px;
}

.view-course-button:hover {
   background-color: #fff; 
}

/* Responsive adjustments */
@media (max-width: 768px) {
   .course-card {
       flex-basis: calc(50% - 20px); /* Two cards per row on smaller screens */
   }

   form {
       flex-direction: row; /* Align inputs and button in a row on medium screens */
       justify-content: center; 
       flex-wrap: wrap; 
       gap: 10px; 
       margin-bottom :20px ;
       
    
}
}

@media (max-width: 480px) {
   .course-card {
       flex-basis: calc(100% - 20px); /* One card per row on mobile screens */
       max-height : none ; 
       padding :10 px ; 
       box-shadow : none ; 
       backdrop-filter : none ;      
    }

    h1 {
    color: #000; /* Dark color for the heading */
    
    }
    }

</style>
<h1>Available Courses</h1>

<!-- Search Form -->
<form method="POST" action="" class="search-form">
   <input type="text" name="title" placeholder="Search by Title" value="<?php echo htmlspecialchars($searchTitle); ?>" />
   <input type="text" name="category" placeholder="Search by Category" value="<?php echo htmlspecialchars($searchCategory); ?>" />
   <button type="submit">Search</button>
</form>

<?php if (isset($errorMessage)): ?>
   <p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
<?php else: ?>
   <div class="course-list">
       <?php if (count($courses) > 0): ?>
           <?php foreach ($courses as $course): ?>
               <div class="course-card">
                   <?php if (!empty($course['image_path'])): ?>
                       <img src="<?php echo htmlspecialchars($course['image_path']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>" class="course-image">
                   <?php endif; ?>
                   <div class="course-content">
                       <h2 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h2>
                       <p class="course-description"><?php echo htmlspecialchars($course['description']); ?></p>
                       <a href="course_detail.php?id=<?php echo htmlspecialchars($course['id']); ?>" class="view-course-button">View Course</a>
                   </div>
               </div>
           <?php endforeach; ?>
       <?php else: ?>
           <p>No courses available at the moment.</p>
       <?php endif; ?>
   </div>
<?php endif; ?>

<?php include_once 'includes/footer.php'; // Include footer ?>
