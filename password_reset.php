<?php
session_start();
$title = "Password Reset";

// Include necessary files
include_once 'includes/db.php'; // Ensure this file sets up $db
include_once 'includes/email.php'; // Include the email functions

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    // Handle password reset request
    $email = $_POST['email'];

    // Check if the email exists in your database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a password reset link
        $resetToken = bin2hex(random_bytes(16)); // Generate a random token

        // Store the token in the database with an expiration time (not shown here)
        // This should be implemented securely in your database

        // Create a reset link
        $resetLink = "https://explicitly-full-crawdad.ngrok-free.app/code/reset_password.php?token=$resetToken&email=" . urlencode($email);

        // Send the password reset email using the updated function
        if (sendPasswordResetEmail($email, $resetLink)) {
            echo "<p>A password reset link has been sent to $email.</p>";
        } else {
            echo "<p>There was an error sending the email. Please try again later.</p>";
        }
    } else {
        echo "<p>This email address is not registered.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
<style>
    /* General Styles */
body {
    background-image: url('resources/css/bgimg.svg'); /* Background image */
    background-size: cover; /* Cover the entire background */
    font-family: Arial, sans-serif; /* Font family */
    margin: 0; /* Remove default margin */
    padding: 20px; /* Add padding to the body */
    color: #333; /* Default text color */
}

h1 {
    text-align: center; /* Center the heading */
    color: #333; /* Heading color */
    margin-bottom: 20px; /* Space below the heading */
}

/* Form Styles */
form {
    background-color: rgba(255, 255, 255, 0.9); /* White background with slight transparency */
    border-radius: 5px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    max-width: 400px; /* Maximum width of the form */
    margin: 20px auto; /* Center the form horizontally */
    padding: 20px; /* Padding inside the form */
}

label {
    display: block; /* Block display for labels */
    margin-bottom: 10px; /* Space below each label */
    font-weight: bold; /* Bold font for labels */
}

input[type="email"] {
    width: calc(100% - 20px); /* Full width minus padding */
    padding: 10px; /* Padding inside input field */
    margin-bottom: 20px; /* Space below input field */
    border: 1px solid #ccc; /* Light gray border */
    border-radius: 4px; /* Rounded corners for input fields */
}

button {
    background-color: #5cb85c; /* Bootstrap success color */
    color: white; /* White text color for button */
    border: none; /* No border for button */
    border-radius: 4px; /* Rounded corners for button */
    padding: 10px; /* Padding inside button */
    cursor: pointer; /* Pointer cursor on hover */
    width: 100%; /* Full width button */
}

button:hover {
    background-color: #4cae4c; /* Darker green on hover for button */
}

/* Link Styles */
a {
    display: block; /* Block display for links to take full width */
    text-align: center; /* Center text in links */
    margin-top: 15px; /* Space above links */
    text-decoration: none; /* Remove underline from links */
    color: #007bff; /* Bootstrap primary color for links */
}

a:hover {
    text-decoration: underline; /* Underline on hover for links */
}

/* Message Styles (for success/error messages)*/
p {
    text-align: center; /* Center paragraphs for messages */
}

</style>
</head>
<body>

<h1>Password Reset</h1>

<!-- Password Reset Request Form -->
<form method="POST" action="">
    <label for="email">Enter your email:</label>
    <input type="email" name="email" required>
    <button type="submit">Send Reset Link</button>
</form>

<!-- Link to return to login -->
<a href="login.php">Return to Login</a>

<?php include_once 'includes/footer.php'; // Include footer ?>

</body>
</html>
