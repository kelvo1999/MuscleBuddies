<?php
session_start();
include '../db/db_connection.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    // Check if the OTP matches
    $check_otp_query = "SELECT * FROM client WHERE email='$email' AND otp='$otp'";
    $otp_result = $conn->query($check_otp_query);

    if ($otp_result->num_rows > 0) {
        // Update the user to set verified as true and clear the OTP
        $update_query = "UPDATE client SET verified=TRUE, otp=NULL WHERE email='$email'";
        if ($conn->query($update_query) === TRUE) {
            echo "<script>alert('Email verified successfully! You can now log in.'); window.location.href = 'client.php';</script>";
        } else {
            echo "<script>alert('Error verifying email. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Invalid OTP. Please try again.'); window.history.back();</script>";
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
    <title>Verify OTP</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Kiboko Body Builders</div>
        </nav>
    </header>

    <main>
        <form method="POST" action="verify_otp.php">
            <h2>Verify Your Email</h2>
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="otp">OTP:</label>
            <input type="text" name="otp" required>

            <button type="submit">Verify</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Kiboko Body Builders. All rights reserved.</p>
    </footer>
</body>
</html>
