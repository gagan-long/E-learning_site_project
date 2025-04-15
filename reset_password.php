<?php
session_start();
$title = "Reset Password";

// Include database connection and email functions
include_once 'includes/db.php';
include_once 'includes/email.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $token = $_GET['token'];

    // Validate token and email (this should be checked against your database)
    // For demonstration purposes, let's assume the token is valid
    $tokenIsValid = true; // Replace with actual token validation

    if ($tokenIsValid) {
        if ($newPassword === $confirmPassword) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            if ($stmt->execute([$hashedPassword, $email])) {
                echo "<p>Your password has been reset successfully. You can now <a href='login.php'>login</a>.</p>";
            } else {
                echo "<p>There was an error updating your password. Please try again.</p>";
            }
        } else {
            echo "<p>Passwords do not match. Please try again.</p>";
        }
    } else {
        echo "<p>Invalid token or email. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
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

input[type="password"], input[type="email"] {
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

<h1>Reset Password</h1>

<form method="POST" action="">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
    
    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" required>
    
    <label for="confirm_password">Confirm New Password:</label>
    <input type="password" name="confirm_password" required>
    
    <button type="submit">Reset Password</button>
</form>

<a href="login.php">Return to Login</a>

<?php include_once 'includes/footer.php'; // Include footer ?>

</body>
</html>
