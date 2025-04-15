<?php
session_start();
$title = "Contact Us";
include_once 'includes/header_user.php'; // Include header
include_once 'includes/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color:red;'>Invalid email format.</p>";
    } else {
        // Save message to the database
        $query = "INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            echo "<p>Thank you, $name! Your message has been sent.</p>";
        } else {
            echo "<p style='color:red;'>Failed to send your message. Please try again later.</p>";
        }
    }
}
?>

<style>
/* General Styles */


/* Main Heading */
h1 {
    font-size: 3rem;
    margin-top: 40px;
    color: #4CAF50; /* Dark color for the heading */
    text-align: center; /* Center the heading */
    margin-bottom: 40px; /* Space below the heading */
}

/* Form Styles */
form {
  
    max-width: 600px; /* Limit form width for better readability */
    margin: 0 auto; /* Center the form on the page */
    background-color: white; /* White background for contrast */
    padding: 20px; /* Padding inside the form */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
    margin-bottom: 16vh;
}

form label {
    color: gray;
    display: block; /* Make labels block elements */
    margin-bottom: 5px; /* Space below labels */
}

form input[type="text"],
form input[type="email"],
form textarea {
    width: 95%; /* Full width inputs */
    padding: 10px; /* Padding inside inputs */
    border-radius: 5px; /* Rounded corners for inputs */
    border: 1px solid #ccc; /* Border color */
    margin-bottom: 15px; /* Space below inputs */
}

form textarea {
    height: 100px; /* Fixed height for textarea */
}

/* Button Styles */
form button {
    padding: 10px 15px;
    background-color: #5FCF80; /* Green button color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer; /* Pointer cursor on hover */
}

form button:hover {
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
}
.contact{
    background-color: rgba(0, 0, 0, 0.1);
}
/* Responsive Design for Contact Page */
@media (max-width: 768px) {
   form {
       padding: 15px; /* Reduce padding on smaller screens */
   }

   form input[type="text"],
   form input[type="email"],
   form textarea {
       margin-bottom: 10px; /* Adjust spacing for smaller screens */
   }
   h1{
    font-size: 2rem;
    color: black;
   }
}

</style>
<div class="contact">
<h1>Contact Us /  Any Feedback For Us</h1>
<form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" name="name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <label for="message">Message:</label>
    <textarea name="message" required></textarea>

    <button type="submit">Send Message</button>
</form>
</div>

<?php include_once 'includes/footer.php'; // Include footer ?>
