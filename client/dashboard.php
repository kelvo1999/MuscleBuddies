<?php
session_start();
include '../db/db_connection.php'; // Include the database connection file

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: client.php");
    exit();
}

// Fetch user details
$email = $_SESSION['email'];
$sql = "SELECT first_name, last_name, last_login FROM client WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
    $last_login = $user['last_login'];
} else {
    // If user not found, redirect to login
    header("Location: client.php");
    exit();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function showNotification(message, isSuccess) {
            var notification = document.getElementById('notification');
            notification.innerText = message;
            notification.className = isSuccess ? 'notification success' : 'notification error';
            notification.style.display = 'block';
            setTimeout(function() {
                notification.style.display = 'none';
            }, 5000);
        }

        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var isVisible = sidebar.classList.contains('visible');
            sidebar.classList.toggle('visible', !isVisible);
            document.body.classList.toggle('sidebar-open', !isVisible); // Add class to body to adjust main content
        }
    </script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            transition: margin-left 0.3s ease; /* Smooth transition for content */
        }

        .dashboard {
            position: relative;
            min-height: 100vh;
            padding-top: 60px; /* Adjust based on header height */
            padding-bottom: 40px; /* Adjust based on footer height */
        }

        .dashboard::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('../img/client.jpg') no-repeat center center/cover;
            opacity: 0.5; /* Adjust opacity as needed */
            z-index: -1; /* Make sure it stays behind the content */
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            top: 0;
            width: 100%;
            position: fixed;
            left: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        .menu-toggle {
            display: block;
            cursor: pointer;
            font-size: 1.5em;
            padding: 10px;
            background: #444;
            border: none;
            color: white;
            border-radius: 5px;
            z-index: 2; /* Ensure it's above the sidebar */
        }

        .menu-toggle:hover {
            background: #555;
        }

        .sidebar {
            position: fixed;
            left: -200px; /* Start hidden off-screen */
            top: 60px; /* Adjust based on header height */
            width: 200px;
            /* height: calc(100vh - 60px - 40px); Adjust based on header and footer height */
            height: 400px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: left 0.3s ease; /* Smooth transition */
            z-index: 1;
        }

        .sidebar.visible {
            left: 0; /* Show sidebar */
        }

        .sidebar ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            padding: 10px;
            display: block;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #f0f0f0;
        }

        .main-content {
            margin-left: 220px; /* Adjust based on sidebar width */
            padding: 20px;
            transition: margin-left 0.3s ease; /* Smooth transition for main content */
        }

        .sidebar-open .main-content {
            margin-left: 0; /* Adjust content margin when sidebar is open */
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 1px;
            position: fixed;
            bottom: 0;
            width: 100%;
            left: 0;
        }

        #notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px;
            border-radius: 5px;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            display: none;
            z-index: 9999;
        }

        .notification.success {
            background: rgba(0, 128, 0, 0.8);
        }

        .notification.error {
            background: rgba(255, 0, 0, 0.8);
        }
    </style>
</head>
<body>
    <header>
        <button class="menu-toggle" onclick="toggleSidebar()">&#9776;</button>
        <div class="logo">Kiboko Body Builders</div>
    </header>

    <main class="dashboard">
        <div id="notification"></div>

        <aside id="sidebar" class="sidebar">
            <ul>
                <li><a href="change_password.php">Change Password</a></li>
                <li><a href="delete_account.php">Delete Account</a></li>
                <li><a href="contact_trainee.php">Contact Another Trainee</a></li>
                <li><a href="contact_instructor.php">Contact Instructor</a></li>
                <li><a href="sign_out.php">Sign Out</a></li>
            </ul>
        </aside>

        <div class="main-content">
            <h1>Welcome, <?php echo htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name); ?>!</h1>
            <p>Last login: <?php echo htmlspecialchars($last_login); ?></p>
            <!-- Add more content here -->
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Kiboko Body Builders. All rights reserved.</p>
    </footer>
</body>
</html>
