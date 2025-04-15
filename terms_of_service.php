<?php
$title = "Terms of Service";
include_once 'includes/header_user.php'; 
?>
<style>
h1 {
    margin-top: 30vh;
    color:rgb(79, 201, 152);
    font-size: 3rem;
    text-align: center;
    margin-bottom: 20px;
}

/* Paragraph styles */
p {
    color: #555;
    margin-bottom: 15px;
}

/* Link styles */
a {
    color: #007BFF; /* Bootstrap primary color */
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Container for the policy content */
.policy-container {

    height: 80vh;
    width: 100%; /* Limit the width for better readability */
    margin: auto; /* Center the container */
    background-color: transparent; /* White background for contrast */
    padding: 20px; /* Inner padding */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
    text-align: center;
    /* justify-content: center; */
}

/* List styles */
ul {
    margin-left: 20px; /* Indent list items */
}

li {
    margin-bottom: 10px; /* Space between list items */
}

</style>
<div class="policy-container">
<h1>Terms of Service</h1>
<p>Welcome to LearnToCode! By using our platform, you agree to the following terms...</p>
</div>

<!-- Add detailed terms of service content here -->

<?php include_once 'includes/footer.php'; // Include footer ?>
