<!-- header_user.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
    <title><?php echo isset($title) ? $title : 'LearnToCode'; ?></title>

    <style>
        /* General Styles */
        body {
            /* background-image: url("bgimg.svg"); */
            background-image: url(bgimg.svg);
            background-size: cover;
            overflow-x: hidden;
            scroll-behavior: smooth;
            height: 100%;
            width: 100%;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            position: relative;
        }

        /* Header Styles */
        header {
            background-color: transparent; /* Green header background */
            padding: 10px 20px;
        }

        .navbar-brand {
            text-decoration: none;
            font-size: 2.5rem;
            color: #27E0B3;
        }

        nav {
            /* background-color: rgba(0, 0, 0, 0.7); */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Navigation Menu */
        nav ul {
            list-style-type: none; /* Remove bullet points */
            padding: 0; /* Remove default padding */
            margin: 0; /* Remove default margin */
            display: flex; /* Default to horizontal layout */
        }

        nav li {
            margin-right: 15px; /* Space between links */
        }

        nav a {
            text-decoration: none; /* Remove underline from links */
            color: white; /* White text color */
            font-weight: bold; /* Bold text */
        }

        nav a:hover {
            text-decoration: underline; /* Underline on hover */
        }

        /* Hamburger Menu Icon */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .bar {
            height: 3px;
            width: 25px;
            background-color: white;
            margin: 4px 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav ul {
                display: none; /* Hide menu by default on mobile */
                flex-direction: column; /* Stack links vertically on small screens */
                align-items: flex-start; /* Align items to the start */
                width: 100%; /* Full width for mobile view */
                padding-left: 0; /* No padding on left for mobile view */
                position: absolute; /* Positioning for dropdown effect */
                top: 60px; /* Adjust based on header height */
                left: 0; 
                background-color: rgba(0, 0, 0, 0.7); /* Background for dropdown menu */
                z-index: 1000; /* Ensure it appears above other elements */
            }

            nav li {
                margin-bottom: 10px; /* Space between links in mobile view */
                margin-right: 0; /* Remove right margin in mobile view */
                width: 100%; /* Full width for each link in mobile view */
                text-align: left; /* Align text to the left */
                padding-left: 20px; /* Padding for aesthetics */
            }

            .hamburger {
                display: flex; /* Show hamburger icon on mobile */
                z-index: 2000; /* Ensure it appears above other elements */
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a class="navbar-brand" href="../index.php"><span>Learn to Code</span></a>
            
            <!-- Hamburger Menu -->
            <div class="hamburger" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>

            <ul id="nav-links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="../about.php">About</a></li>
                <li><a href="../courses.php">Courses</a></li>
                <li><a href="../contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li><a href="../user/chat.php">Queries</a></li>
                    <li><a href="../user/profile.php">Profile</a></li>
                    <li><a href="../user/user_dashboard.php">Dashboard</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                <?php else : ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="../register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <script>
        function toggleMenu() {
            const navLinks = document.getElementById('nav-links');
            if (navLinks.style.display === 'flex') {
                navLinks.style.display = 'none';
            } else {
                navLinks.style.display = 'flex';
            }
        }
    </script>

