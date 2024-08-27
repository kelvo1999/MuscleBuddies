<?php
include '../db/db_connection.php'; // Include the database connection file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = $_POST['gender'];
    $location = $_POST['location'];
    $age = $_POST['age'];

    // Validate that the password and confirm password match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit();
    }

    // Check if the email already exists
    $check_email_query = "SELECT * FROM client WHERE email='$email'";
    $email_result = $conn->query($check_email_query);

    if ($email_result->num_rows > 0) {
        echo "<script>alert('This email is already registered. Please use a different email.'); window.history.back();</script>";
        exit();
    }

    // Check if the phone number already exists
    $check_phone_query = "SELECT * FROM client WHERE phone='$phone'";
    $phone_result = $conn->query($check_phone_query);

    if ($phone_result->num_rows > 0) {
        echo "<script>alert('This phone number is already registered. Please use a different phone number.'); window.history.back();</script>";
        exit();
    }

    // Generate a 6-digit OTP
    $otp = rand(100000, 999999);

    // Insert the data into the database with unverified status and OTP
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security
    $sql = "INSERT INTO client (first_name, last_name, email, phone, password, gender, location, age, otp)
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$hashed_password', '$gender', '$location', '$age', '$otp')";

    if ($conn->query($sql) === TRUE) {
        // Send OTP to the user's email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'kelvoshisanya@gmail.com'; // Replace with your SMTP username
            $mail->Password   = 'djnk adyp wnta gnve'; // Replace with your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('kelvoshisanya@gmail.com', 'Kiboko Body Builders');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification - Kiboko Body Builders';
            $mail->Body    = "Your OTP code is: $otp";

            $mail->send();
            echo "<script>alert('Registration successful! Please check your email for the OTP to verify your account.'); window.location.href = 'verify_otp.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Failed to send OTP. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "'); window.history.back();</script>";
    }

    // Close the connection
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
                <!-- <option value="Other">Other</option> -->
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
