<?php
session_start();
$title = "Register";
// include_once 'includes/header.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure Composer's autoloader is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'includes/db.php'; // Corrected path to db.php

    // Check if OTP is being verified or registration is being processed
    if (isset($_POST['verify_otp'])) {
        $enteredOtp = $_POST['otp'];

        // Validate the entered OTP
        if (isset($_SESSION['otp']) && $enteredOtp == $_SESSION['otp']) {
            // Hash the password and insert new user into the database
            $name = $_SESSION['name']; // Retrieve name from session
            $email = $_SESSION['email']; // Retrieve email from session
            $hashedPassword = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
            
            // Insert user into the database
            $insertQuery = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bindParam(':name', $name);
            $insertStmt->bindParam(':email', $email);
            $insertStmt->bindParam(':password', $hashedPassword);

            if ($insertStmt->execute()) {
                echo "<p id='success'>Registration successful! Welcome, {$name}.</p>";
                unset($_SESSION['otp']); // Clear OTP from session
                unset($_SESSION['email']); // Clear email from session
                unset($_SESSION['name']); // Clear name from session
                unset($_SESSION['password']); // Clear password from session
            } else {
                echo "<p id='failed'>Registration failed. Please try again.</p>";
            }
        } else {
            echo "<p id='failed'>Invalid OTP! Please try again.</p>";
        }
    } else {
        // Registration process
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Store user data in session for later use
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;

        // Check if the email already exists in the database
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<p id='failed'>Email already exists.</p>";
        } else {
            // Generate a 6-digit OTP
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp; // Store OTP in session

            // Send OTP email
            if (sendOtpEmail($email, $otp)) {
                echo "<p id='success'>An OTP has been sent to your email. Please verify to complete registration.</p>";
            } else {
                echo "<p id='failed'>Failed to send OTP. Please try again.</p>";
            }
        }
    }
}

function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'gaganshriwas5@gmail.com'; // SMTP username
        $mail->Password   = 'csiczfntjofbkcjy'; // SMTP password (consider using environment variables)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('gaganshriwas5@gmail.com', 'LearnToCode');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}

function sendOtpEmail($userEmail, $otp) {
    $subject = "Your Registration OTP";
    $message = "<h1>Your OTP for registration</h1>";
    $message .= "<p>Your One-Time Password (OTP) is: <strong>$otp</strong></p>";
    
    return sendEmail($userEmail, $subject, $message);
}
?>

<style>

#success{
    
    position: absolute;
    top: 10vh;
    left: 40vw;
    /* z-index: 999; */
    text-align: center;
    color: #27e0b3;
}
#failed{
    position: absolute;
    top: 10vh;
    left: 45vw;
    z-index: 999;
    text-align: center;
    color: red;
}
/* Main Heading */
h1 {
    font-size: 5rem;
    margin-top: 20vh;
    color: #27e0b3; /* Dark color for the heading */
    text-align: center; /* Center the heading */
    margin-bottom: 20px; /* Space below the heading */
}


/* Form Styles */
form {
    height: auto;
    max-width: 60dvw; /* Limit form width for better readability */
    margin: 0 auto; /* Center the form on the page */
    background-color: transparent; /* White background for contrast */
    backdrop-filter: blur(2px);
    color: #fff;
    padding: 20px; 
    border: 2px solid rgba(255, 255, 255, .2);
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
    margin-bottom: 3dvh;
    gap: 3dvh;
}

form label {
    font-size: 2rem;
    display: block; /* Make labels block elements */
    margin-bottom: 3dvh; /* Space below labels */
}

form input[type="text"],
form input[type="email"],
form input[type="password"] {
    font-size: 1.5rem;
    width: 100%; /* Full width inputs */
    padding: 10px; /* Padding inside inputs */
    border: 2px solid rgba(255, 255, 255, .2);
    background-color: transparent;
    color: #fff;
    border-radius: 5px; /* Rounded corners for inputs */
    border: 1px solid #ccc; /* Border color */
    margin-bottom: 15px; /* Space below inputs */
}

/* Button Styles */
form button {
    font-size: 2.3rem;
    margin-top: 20px;
    padding: 10px 15px;
    background-color: transparent; /* Green button color */
    color: white;
    border: 2px solid rgba(255, 255, 255, .2);
    border-radius: 5px;
    cursor: pointer; /* Pointer cursor on hover */
    width: 100%; /* Full width button */
}

form button:hover {
    background-color: #4CAF50; /* Darker green on hover */
}

/* Error Message Styles */
.error-message {
    color: red;
    font-weight: bold;
}

/* Links Styles */
a {
    font-size: 2rem;
    display: block; /* Block display for links to stack vertically */
    text-align: center; /* Center align text in links */
    margin-top: 10px; /* Space above links */
    color: #fff;
    text-decoration: none;
}
a:hover{
        text-decoration: underline;

    }
body{
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

/* Responsive Design for Registration Page */
@media (max-width: 480px) {
   form {width: 90dvw;
       padding: 15px; /* Reduce padding on smaller screens */
   }

   form input[type="text"],
   form input[type="email"],
   form input[type="password"] {
       margin-bottom: 10px; /* Adjust spacing for smaller screens */
   }
}

</style>

<body>
<h1>Register</h1>
<form method="POST" action="" id="register">
    <label for="name">Name:</label>
    <input type="text" name="name" required>
    
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    
    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <button type="submit" id="registerButton">Register</button>
</form>

<form method="POST" action="" id="verify">
    <label for="otp">Enter OTP:</label>
    <input type="text" name="otp" required maxlength="6">
    
    <button type="submit" name="verify_otp">Verify OTP</button>
</form>

<a href="login.php">Already have an account? Login here.</a>
</body>
<script>
    const registerButton=document.getElementById('registerButton');


const verifyForm=document.getElementById('verify');
const registerForm=document.getElementById('register');

registerButton.addEventListener('click',function(){
    registerForm.style.display="none";
    verifyForm.style.display="block";
})

</script>
