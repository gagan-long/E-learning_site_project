<?php
session_start();
$title = "Login";
// include_once 'includes/header_user.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'includes/db.php'; // Corrected path to db.php

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check credentials against the database
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; // Set session user ID
            header('Location: user/user_dashboard.php'); // Redirect to user dashboard after login
            exit;
        } else {
            $errorMessage = "Invalid email or password.";
        }
    } else {
        $errorMessage = "Invalid email or password.";
    }
}
?>
<style>
    /* Main Heading */
    h1 {
        font-size: 6rem;
        margin-top: 5dvh;
        color: #27e0b3;
        /* Dark color for the heading */
        text-align: center;
        /* Center the heading */
        margin-bottom: 20px;
        /* Space below the heading */
    }

    /* Form Styles */
    form {
        height: auto;
        max-width: 60dvw;
        /* Limit form width for better readability */
        margin: 0 auto;
        /* Center the form on the page */
        background-color: transparent;
        /* White background for contrast */
        backdrop-filter: blur(2px);
        color: #fff;
        padding: 20px;
        border: 2px solid rgba(255, 255, 255, .2);
        border-radius: 8px;
        /* Rounded corners */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        /* Subtle shadow effect */
        margin-bottom: 5dvh;
    }

    form label {
        font-size: 3rem;
        margin-top: 3dvh;
        display: block;
        /* Make labels block elements */
        margin-bottom: 9px;
        /* Space below labels */
    }

    form input[type="email"],
    form input[type="password"] {
        width: 100%;
        /* height: 7dvh; */
        font-size: 1.5rem;
        /* Full width inputs */
        padding: 10px;
        /* Padding inside inputs */
        border: 2px solid rgba(255, 255, 255, .2);
        background-color: transparent;
        color: #fff;
        border-radius: 5px;
        /* Rounded corners for inputs */
        border: 1px solid #ccc;
        /* Border color */
        margin-bottom: 15px;
        /* Space below inputs */
    }

    form button {
        font-size: 3rem;
        margin-top: 20px;
        padding: 10px 15px;
        background-color: transparent;
        /* Green button color */
        color: white;
        border: 2px solid rgba(255, 255, 255, .2);
        border-radius: 5px;
        cursor: pointer;
        /* Pointer cursor on hover */
        width: 100%;
        /* Full width button */
    }

    form button:hover {
        background-color: #4CAF50;
        /* Darker green on hover */
    }

    /* Error Message Styles */
    .error-message {
        color: red;
        font-weight: bold;
        text-align: center;
    }

    /* Links Styles */
    a {font-size: 2rem;
        display: block;
        /* Block display for links to stack vertically */
        text-align: center;
        /* Center align text in links */
        margin-top: 10px;
        /* Space above links */
        color: #fff;
        text-decoration: none;
        margin-bottom: 3dvh;
    }

    a:hover {
        text-decoration: underline;
        color: blue;

    }

    /* Responsive Design for Login Page */
    @media (max-width: 768px) {
        h1{
            font-size: 6rem;
        }
        form {
            width: 95dvh;
            height: auto;
            padding: 15px;
            gap: 5dvh;
            /* Reduce padding on smaller screens */
        }

        form input[type="email"],
        form input[type="password"] {
            margin-bottom: 10px;
            /* font-size: 2.3rem; */
            /* Adjust spacing for smaller screens */
        }
        .login-container{
            
            height: 100dvh;
            max-width: 100dvh;
        }
    }

    .login-container {
        height: 100dvh;
    width:  90dvw; /* Limit width for better readability */
    margin: 0 auto; /* Center the container vertically and horizontally */
    padding: 20px; /* Padding inside the container */
    /* background-color: white; White background for contrast */
    border-radius: 8px; /* Rounded corners */
    /* box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); Subtle shadow effect */
    margin-bottom: 10dvh;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-image: url(resouurces/css/bgimg.svg);

        background-size: cover;
        overflow-x: hidden;
        height: 100dvh;
        width: 100dvw;

        align-items: center;
        justify-content: center;
    }
</style>

<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php if (isset($errorMessage)): ?>
            <p style="color:red;"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <a href="password_reset.php">forgot?</a>
            <button type="submit">Login</button>
        </form>

        <a href="register.php">Don't have an account? Register here.</a>
        <a href="admin/login.php">Admin Login</a>
    </div>
</body>