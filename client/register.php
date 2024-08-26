<?php
include '../db/db_connection.php'; // Include the database connection file

// Initialize variables for error messages
$error_message = '';
$success_message = '';
$duplicate_email = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm_password']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $location = $conn->real_escape_string($_POST['location']);
    $age = (int)$_POST['age'];

    // Check for duplicate email
    $email_check = "SELECT email FROM client WHERE email='$email'";
    $result = $conn->query($email_check);

    if ($result->num_rows > 0) {
        $duplicate_email = true;
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database
        $sql = "INSERT INTO client (first_name, last_name, email, phone, password, gender, location, age) 
                VALUES ('$first_name', '$last_name', '$email', '$phone', '$hashed_password', '$gender', '$location', '$age')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Registration successful!";
            // Redirect to login page
            header("Location: client.php");
            exit(); // Make sure to exit after redirecting
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            <?php if ($duplicate_email): ?>
                alert('The email is already registered.');
            <?php elseif (!empty($error_message)): ?>
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
        <h2>Register</h2>
        <form method="post" action="register.php">
            <label for="first_name">First Name:</label><br>
            <input type="text" id="first_name" name="first_name" required><br><br>

            <label for="last_name">Last Name:</label><br>
            <input type="text" id="last_name" name="last_name" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="phone">Phone:</label><br>
            <input type="text" id="phone" name="phone" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>

            <label for="gender">Gender:</label><br>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select><br><br>

            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location" required><br><br>

            <label for="age">Age:</label><br>
            <input type="number" id="age" name="age" required><br><br>

            <input type="submit" value="Register">
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Kiboko Body Builders. All rights reserved.</p>
    </footer>
</body>
</html>
