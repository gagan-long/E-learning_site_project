<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <title><?php echo isset($title) ? $title : 'LearnToCode'; ?></title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            /* background-image: url("bgimg.svg"); */
            background-image: url(bgimg.svg);
            background-size: cover;
            overflow-x: hidden;
            overflow-y: auto;
            height: 100%;
            width: 100%;
            font-family: Arial, sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        /* Header Styles */
        header {
            width: 100%;
            background-color: transparent;
            padding: 10px 20px;
        }

        .navbar-brand {
            text-decoration: none;
            font-size: 2.5rem;
            color: #27E0B3;
        }

        nav {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Navigation Menu */
        nav ul {
            list-style-type: none; 
            padding: 0; 
            margin: 0; 
        }

        nav li {
            display: inline; 
            margin-right: 15px; 
        }

        nav a {
            text-decoration: none; 
            color: #fff; 
            font-weight: bold; 
        }

        nav a:hover {
            color: #27E0B3;
            text-decoration: underline; 
        }

        /* Mobile Styles */
        #mobile_menu {
            display: none; /* Hidden by default */
            font-size: 2.5rem; /* Adjust size as needed */
            cursor: pointer; /* Pointer cursor for interaction */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav ul {
                display: none; /* Hide menu links by default */
                flex-direction: column; 
                align-items: flex-start; 
                width: 100%; 
                padding-left: 0; 
                background-color: rgba(255, 255, 255, 0.6); 
                /* color: #000; */
                /* color: #000; */
                position: absolute; /* Position it absolutely */
                top: 60px; /* Below the navbar */
                left: 0; 
                right: 0; 
                box-shadow: 0px 4px 10px rgba(0,0,0,0.1); /* Optional shadow */
                z-index: 1000; /* Ensure it appears above other content */
            }

            nav li {
                color: #000;
                margin-bottom: 10px; 
                margin-right: 0; 
                width: 100%; /* Full width for mobile links */
                text-align: left; /* Align text to the left */
                padding-left: 20px; /* Add some padding to the left */
            }

            #mobile_menu {
                color: #ccc;
                display: block; /* Show the mobile menu icon */
            }
            
            nav.active ul {
                color: #27E0B3;
                display: flex; /* Show menu links when active */
            }
            #nav_links a{
                color: #000;
            }

            /* body{
                height: 100dvh;
                width: 100dvw;
            } */
        }
    </style>
</head>
<body>
    <header>
        <nav id="navbar">
            <a class="navbar-brand" href="index.php"><span>Learn to Code</span></a>
            
            <div id="mobile_menu" onclick="toggleMenu()">☰</div>

            <ul id="nav_links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="courses.php">Courses</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="user/user_dashboard.php">Dashboard</a></li>
                    <li><a href="user/profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <script>
      function toggleMenu() {
          const navbar = document.getElementById('navbar');
          navbar.classList.toggle('active'); // Toggle 'active' class to show/hide the menu
      }
    </script>

