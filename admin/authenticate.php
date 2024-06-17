<?php
session_start();
require_once('db_connection.php');

// Function to sanitize inputs
function sanitize_input($input) {
    // Implement your sanitization logic here
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to authenticate user
function authenticate_user($username, $password) {
    global $conn;
    
    // Sanitize inputs
    $username = sanitize_input($username);
    $password = sanitize_input($password);
    
    // Query database for user credentials
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);
    
    if ($result->num_rows == 1) {
        // User found, set session variables or perform other actions
        $_SESSION['username'] = $username;
        return true;
    } else {
        // User not found or credentials incorrect
        return false;
    }
}

// Example usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (authenticate_user($username, $password)) {
        // Authentication successful, redirect or perform actions
        header("Location: dashboard.php");
        exit();
    } else {
        // Authentication failed, handle error
        echo "Invalid username or password";
    }
}
?>
