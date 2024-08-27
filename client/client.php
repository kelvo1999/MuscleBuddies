<?php
session_start();
include '../db/db_connection.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email is registered and the user is verified
    $sql = "SELECT password, verified FROM client WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Check if the user is verified
        if (!$user['verified']) {
            echo "<script>alert('Your email is not verified. Please verify your email to log in.'); window.history.back();</script>";
            exit();
        }

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Start session
            $_SESSION['email'] = $email;

            // Update last login time
            $current_time = date('Y-m-d H:i:s');
            $update_sql = "UPDATE client SET last_login='$current_time' WHERE email='$email'";
            $conn->query($update_sql);

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Incorrect password.'); window.history.back();</script>";
        }
    } else {
        // Email not found or unverified
        echo "<script>alert('Email not registered or not verified.'); window.history.back();</script>";
    }

    // Close connection
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client | Login</title>
    <link rel="stylesheet" href="style.css">
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

        window.onload = function() {
            <?php if (!empty($error_message)): ?>
                showNotification('<?php echo $error_message; ?>', false);
            <?php elseif (!empty($success_message)): ?>
                showNotification('<?php echo $success_message; ?>', true);
            <?php endif; ?>
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Kiboko Body Builders</div>
            <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="instructor.php">Instructor</a></li>
                <li><a href="client.php">Client</a></li>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div id="notification" style="display: none;"></div>
        <h2>Login</h2>
        <form method="post" action="client.php">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Login">
            <a href="register.php">Not a member? Register</a>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Kiboko Body Builders. All rights reserved.</p>
    </footer>
</body>
</html>
