<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not an admin
    exit;
}

include_once '../includes/db.php'; // Include database connection

// Handle search functionality
$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = htmlspecialchars(trim($_POST['search']));
}

// Fetch enrolled students with optional search filter
$query = "SELECT u.id AS user_id, u.name AS student_name, c.title AS course_title, e.enrollment_date
          FROM enrollments e
          JOIN users u ON e.user_id = u.id
          JOIN courses c ON e.course_id = c.id";

if (!empty($searchQuery)) {
    $query .= " WHERE u.name LIKE :search OR c.title LIKE :search ORDER BY u.name";
}

$stmt = $conn->prepare($query);
if (!empty($searchQuery)) {
    $likeSearch = '%' . $searchQuery . '%';
    $stmt->bindParam(':search', $likeSearch);
}
$stmt->execute();
$enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$title = "Manage Enrollments";
include_once '../includes/header_admin.php'; // Include admin header
?>

<style>
/* Styles for Manage Enrollments Page */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}

table td {
    color: #fff;
}

table th {
    background-color: #f4f4f4;
}

/* Form Styles */
form {
    margin-bottom: 20px; /* Space below the form */
}

form input[type="text"] {
    padding: 10px;
    width: calc(100% - 110px); /* Full width minus button width */
    border-radius: 5px;
    border: 1px solid #ccc;
}

form button {
    padding: 10px 20px;
    background-color: #5FCF80; /* Green button color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer; /* Pointer cursor on hover */
}

form button:hover {
    background-color: #4CAF50; /* Darker green on hover */
}

h1 {
    margin-top: 5vh;
    text-align: center;
    color: #4CAF50;
    margin-bottom: 5vh;
}

.enrollment {
    width: 100%;
    height: auto; /* Adjust height */
    align-items: center;
    justify-content: center;
    padding: 20px;
}
</style>

<div class="enrollment">
<h1>Manage Enrollments</h1>

<form method="POST" action="">
    <input type="text" name="search" placeholder="Search by student or course name" value="<?php echo htmlspecialchars($searchQuery); ?>">
    <button type="submit">Search</button>
</form>

<!-- Print Button -->
<button onclick="printTable()" style="margin-bottom: 20px; padding: 10px; background-color: #007BFF; color: white; border:none; border-radius:5px; cursor:pointer;">Print Details</button>

<table id="enrollmentTable">
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Course Title</th>
            <th>Enrollment Date</th> <!-- New column for enrollment date -->
        </tr>
    </thead>
    <tbody>
        <?php if ($enrollments): ?>
            <?php foreach ($enrollments as $enrollment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($enrollment['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($enrollment['course_title']); ?></td>
                    <td><?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($enrollment['enrollment_date']))); ?></td> <!-- Format date -->
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No enrollments found.</td> <!-- Adjusted colspan -->
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
function printTable() {
    var printContents = document.getElementById("enrollmentTable").outerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>

</div>

<?php include_once '../includes/footer.php'; // Include footer ?>
