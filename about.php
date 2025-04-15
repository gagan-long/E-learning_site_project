<?php
session_start();
$title = "About Us";
include_once 'includes/header_user.php'; // Include header
?>
<style>

/* Main Heading */
#about-h1 {
    outline-color: #555;
    font-size: 5rem;
    color: #27E0B3; /* Dark color for the heading */
    text-align: center; /* Center the heading */
    margin-bottom: 20px; /* Space below the heading */
}

/* Paragraph Styles */
.about-p {
    text-align: center;
    color: #fff; /* Slightly lighter color for text */
    line-height: 1.6; /* Increase line height for readability */
    max-width: 800px; /* Set a max width for better readability */
    margin: 0 auto 20px auto; /* Center align with margin at bottom */
    padding: 10px; /* Add padding around paragraphs */
    /* background-color: white; White background for contrast */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
}

/* Container for Full Width Content */
.container {
    background-color: rgba(0, 0, 0, 0.1);
    display: flex; /* Use flexbox for alignment */
    flex-direction: column; /* Stack items vertically */
    align-items: center; /* Center items horizontally */
    justify-content: center; /* Center items vertically if height is defined */
    max-width: 100%;
    height: 85vh;
    padding: 0 20px; /* Add side padding to container */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
}

/* Responsive Design for About Page */
@media (max-width: 768px) {
    .about-p {
        padding: 5px; /* Reduce padding on paragraphs for smaller screens */
        font-size: 14px; /* Adjust font size for better readability on mobile */
        margin-bottom: 15px; /* Space between paragraphs on mobile view */
    }

    #about-h1 {
        font-size: 24px; /* Adjust heading size on smaller screens */
    }
    .about-p{
        color: #ccc;
    }
}

</style>
<div class="container">
    <h1 id="about-h1">About LearnToCode</h1>
    <p class="about-p">LearnToCode is a platform dedicated to helping individuals learn programming and coding skills. We provide a variety of courses designed to cater to different skill levels, from beginners to advanced programmers. Our mission is to empower learners with the knowledge and tools they need to succeed in their coding journey.</p>
    
    <p class="about-p">Our courses are developed by experienced instructors who are passionate about teaching and sharing their expertise. We believe in hands-on learning, so our courses include practical exercises and projects that help reinforce concepts and skills.</p>
    
    <p class="about-p">Join us today and take your first step towards mastering coding!</p>
</div>

<?php include_once 'includes/footer.php'; // Include footer ?>
