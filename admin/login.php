<?php
session_start();
include_once '../includes/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check credentials (add your logic here)
    $query = "SELECT * FROM users WHERE email = :email AND role = 'admin'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = 'admin';
        header('Location: index.php'); // Redirect to admin dashboard
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
    /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4; /* Light background color */
    margin: 0; /* Remove default margin */
}

/* Login Container */
.login-container {
    max-width: 400px; /* Limit width for better readability */
    margin: 100px auto; /* Center the container vertically and horizontally */
    padding: 20px; /* Padding inside the container */
    background-color: white; /* White background for contrast */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
}

/* Main Heading */
h1 {
    color: #333; /* Dark color for the heading */
    text-align: center; /* Center align heading */
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column; /* Stack form elements vertically */
}

form label {
    margin-bottom: 5px; /* Space below labels */
}

form input[type='email'],
form input[type='password'] {
    padding: 10px; /* Padding inside inputs */
    border-radius: 5px; /* Rounded corners for inputs */
    border: 1px solid #ccc; /* Border color */
    margin-bottom: 15px; /* Space below inputs */
}

/* Button Styles */
button {
   padding: 10px;
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
   text-align: center; /* Center align error message */
}

    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
