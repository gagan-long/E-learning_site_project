<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

$title = "Profile";
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
$userEmail = $user['email'];
$currentProfileImage = $user['profile_image'];

// Handle profile update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $newName = htmlspecialchars(trim($_POST['name']));
    $newEmail = htmlspecialchars(trim($_POST['email']));

    // Update the user information in the database
    $updateQuery = "UPDATE users SET name = :name, email = :email WHERE id = :id";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(':name', $newName);
    $updateStmt->bindParam(':email', $newEmail);
    $updateStmt->bindParam(':id', $userId);

    if ($updateStmt->execute()) {
        echo "<p class='success-message'>Profile updated successfully!</p>";
        // Refresh user data after update
        $userName = $newName;
        $userEmail = $newEmail;
    } else {
        echo "<p class='error-message'>Failed to update profile. Please try again.</p>";
    }
}

// Handle password update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    
    // Fetch the current password hash from the database
    $passwordQuery = "SELECT password FROM users WHERE id = :id";
    $passwordStmt = $conn->prepare($passwordQuery);
    $passwordStmt->bindParam(':id', $userId);
    $passwordStmt->execute();
    $userData = $passwordStmt->fetch(PDO::FETCH_ASSOC);

    if ($userData && password_verify($currentPassword, $userData['password'])) {
        // Update password if current password is correct
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updatePasswordQuery = "UPDATE users SET password = :password WHERE id = :id";
        $updatePasswordStmt = $conn->prepare($updatePasswordQuery);
        $updatePasswordStmt->bindParam(':password', $hashedPassword);
        $updatePasswordStmt->bindParam(':id', $userId);

        if ($updatePasswordStmt->execute()) {
            echo "<p class='success-message'>Password updated successfully!</p>";
        } else {
            echo "<p class='error-message'>Failed to update password. Please try again.</p>";
        }
    } else {
        echo "<p class='error-message'>Current password is incorrect.</p>";
    }
}

// Handle profile image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    // Handle file upload
    if ($_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        // Check file type and size (you may want to add more validation)
        if (in_array($_FILES['profile_image']['type'], ['image/jpeg', 'image/png', 'image/gif', 'image/webp']) && $_FILES['profile_image']['size'] < 2000000) { // Limit size to 2MB
            // Define upload directory and file name
            $uploadDir = '../uploads/images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
            }
            $fileName = uniqid() . '-' . basename($_FILES['profile_image']['name']);
            $targetFilePath = $uploadDir . $fileName;

            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFilePath)) {
                // Update the database with new profile image path
                $updateImageQuery = "UPDATE users SET profile_image = :profile_image WHERE id = :id";
                $updateImageStmt = $conn->prepare($updateImageQuery);
                $updateImageStmt->bindParam(':profile_image', $targetFilePath);
                $updateImageStmt->bindParam(':id', $userId);

                if ($updateImageStmt->execute()) {
                    echo "<p class='success-message'>Profile image updated successfully!</p>";
                    // Refresh current profile image variable
                    $currentProfileImage = htmlspecialchars($targetFilePath);
                } else {
                    echo "<p class='error-message'>Failed to update profile image in database.</p>";
                }
            } else {
                echo "<p class='error-message'>Failed to upload image. Please try again.</p>";
            }
        } else {
            echo "<p class='error-message'>Invalid file type or size. Please upload a JPEG, PNG, or GIF image under 2MB.</p>";
        }
    }
}
?>
<style>


/* Profile Container */
.profile-container {
   max-width: 900px; /* Limit width for better readability */
   margin: 20px auto; /* Center the container */
   padding: 20px; /* Padding inside the container */
   background-color: transparent; /* White background for contrast */
   backdrop-filter: blur(8px);
   background-color: white; /* White background for contrast */
   border-radius: 8px; /* Rounded corners */
   box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
}

/* Main Heading */
h1 {
   color: #000; /* Dark color for the heading */
}

/* Form Styles */
form {
    color: #fff;
    background-color: transparent; /* White background for contrast */
    backdrop-filter: blur(8px);
   margin-bottom: 20px; /* Space below forms */
}

form label {
    color: gray;
   display: block; /* Make labels block elements */
   margin-bottom: 5px; /* Space below labels */
}

form input[type='text'],
form input[type='email'],
form input[type='password'],
form input[type='file'],
form select,
form textarea {
   width: 94%; /* Full width inputs */
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
.error-message,
.success-message {
   font-weight: bold;
}

.error-message {
   color: red;
}

.success-message {
   color: green;
}
.profile-container a{
    padding: 10px 20px 10px 20px ;
    border-radius: 5px;
    margin-left: 15vw;
    color: #fff;
    background-color: red;
    text-decoration: none;
}

/* Responsive Design Adjustments */
@media (max-width: 768px) {
   .profile-container {
       padding: 15px; /* Reduce padding on smaller screens */
   }
}

</style>
<div class="profile-container">
<h1>Your Profile</h1>
<form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($userName); ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($userEmail); ?>" required>

    <button type="submit" name="update_profile">Update Profile</button>
</form>

<h2>Change Password</h2>
<form method="POST" action="">
    <label for="current_password">Current Password:</label>
    <input type="password" name="current_password" required>

    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" required>

    <button type="submit" name="update_password">Update Password</button>
</form>

<h2>Upload Profile Image</h2>
<form method="POST" action="" enctype="multipart/form-data">
    <input type="file" name="profile_image" accept="image/*" required>
    
    <button type="submit">Upload Image</button>
</form>

<?php if ($currentProfileImage): ?>
<h3>Your Current Profile Image:</h3>
<img src="<?php echo htmlspecialchars($currentProfileImage); ?>" alt="Profile Image" style="max-width: 200px; height: auto;">
<?php endif; ?>

<a href="logout.php">Logout</a>
</div>

<?php include_once '../includes/footer.php'; // Include footer ?>
