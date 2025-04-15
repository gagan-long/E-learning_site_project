<!-- footer.php -->
<footer>
    <style>
    /* Footer Styles */
footer {
    
    background-color: transparent; /* Dark background color */
    /* color: white; White text color */
    text-align: center; /* Center text alignment */
    padding: 20px 0; /* Padding for top and bottom */
    position: relative; /* Positioning context for absolute elements */
    bottom: 0; /* Stick to the bottom of the page */
    width: 100%; /* Full width */
}

footer p {
    color: white;
    margin: 0; /* Remove default margin */
}

footer ul {
    list-style-type: none; /* Remove bullet points */
    padding: 0; /* Remove default padding */
    margin: 10px 0 0 0; /* Margin for spacing */
}

footer li {
    display: inline; /* Display items in a line */
    margin-right: 15px; /* Space between links */
}

footer a {
    color: #5FCF80; /* Green color for links */
    text-decoration: none; /* Remove underline from links */
}

footer a:hover {
    text-decoration: underline; /* Underline on hover */
}

/* Responsive Design for Footer Links */
@media (max-width: 768px) {
    footer ul {
        display: block; /* Stack links vertically on small screens */
        margin-top: 10px; /* Add space above stacked links */
    }

    footer li {
        display: block; /* Each link on a new line */
        margin-bottom: 5px; /* Space between links in mobile view */
        margin-right: 0; /* Remove right margin in mobile view */
    }
    footer p {
        color: #fff;
    }
}

    </style>
        <p>&copy; <?php echo date("Y"); ?> LearnToCode. All rights reserved.</p>
        <ul>
            <li><a href="privacy_policy.php">Privacy Policy</a></li>
            <li><a href="terms_of_service.php">Terms of Service</a></li>
        </ul>
    </footer>
</body>
</html>
