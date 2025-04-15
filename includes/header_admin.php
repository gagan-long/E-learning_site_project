<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Admin - LearnToCode'; ?></title>
    <style>
        /* Root Variables for Color Scheme */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }
        /* :root {
            color-scheme: light dark;
        } */

        /* General Body Styles */
        body {
            background-image: url(../resouurces/css/bgimg.svg);
            background-size: cover;
            overflow-y: auto;
            height: 100%;
            width: 100%;
            font-family: Arial, sans-serif;
            
        }

        /* Header Styles */
        header {
            background-color: transparent;
            padding: 10px 20px;
            color: white;
        }

        /* Navigation Styles */
        nav {
            display: flex;
            flex-wrap: wrap; /* Allow items to wrap */
            justify-content: space-between; /* Space between brand and menu */
            align-items: center; /* Center items vertically */
        }

        /* Navbar Brand Styles */
        .navbar-brand {
            text-decoration: none;
            font-size: 2.5rem;
            color: #27E0B3;
        }

        /* Unordered List Styles */
       nav>ul {
        gap: 10px;
            list-style-type: none; /* Remove bullet points */
            padding: 0; /* Remove default padding */
            margin: 0; /* Remove default margin */
            display: flex; /* Use flexbox for the list */
            flex-wrap: wrap; /* Allow items to wrap on smaller screens */
        }

        /* List Item Styles */
        li {
            margin-right: 15px; /* Space between links */
        }

        /* Link Styles */
        a {
            text-decoration: none; /* Remove underline from links */
            color: white; /* White text color for links */
            font-weight: bold; /* Bold text for links */
        }

        /* Link Hover Effects */
        a:hover {
            text-decoration: underline; /* Underline on hover for better visibility */
        }

        /* Logout Link Styles */
        a.logout-link {
            color: #f44336; /* Red color for logout link to indicate action */
        }

        /* Responsive Design Adjustments */
        @media (max-width: 768px) {
            nav {
                flex-direction: column; /* Stack items vertically on smaller screens */
                align-items: flex-start; /* Align items to the left */
                padding-top: 10px; /* Add padding on top for spacing */
            }

            ul {
                width: 100%; /* Full width for the list on small screens */
                padding-left: 0; /* Remove padding on the left side of the list */
                margin-top: 10px; /* Add some space above the list */
                justify-content: flex-start; /* Align items to the start of the container */
                display: block; /* Change display to block for better stacking behavior */
            }

            li {
                display: block; /* Stack list items vertically on small screens */
                margin-right: 0; /* Remove right margin on small screens */
                margin-bottom: 10px; /* Add space between items vertically */
                width: 100%; /* Make each item take full width on small screens */
                text-align: left; /* Align text to the left for better readability */
            }
        }
    </style>
</head>
<body>
<header>
    <nav>
        <a class="navbar-brand" href="../admin/index.php"><span>Learn to Code</span></a>
        <ul>
            <li><a href="../admin/index.php">Admin Dashboard</a></li>
            <li><a href="../admin/manage_courses.php"> Courses</a></li>
            <li><a href="../admin/manage_users.php"> Users</a></li>
            <li><a href="../admin/notifications.php"> Notifications</a></li> <!-- New link -->
            <li><a href="../admin/view_messages.php"> Messages</a></li> <!-- New link -->
            <li><a href="../admin/admin_chat.php">Chat </a></li> <!-- New link -->
            <li><a href="../index.php">View Site</a></li> <!-- New link -->
            <li><a href="../admin/logout.php" class="logout-link">Logout</a></li>
        </ul>
    </nav>
</header>
</body>
</html>

