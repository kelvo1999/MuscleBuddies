<?php
require_once('db_connection.php');

// Function to add a new user
function add_user($username, $password, $role) {
    global $conn;
    
    // Sanitize inputs
    $username = sanitize_input($username);
    $password = sanitize_input($password);
    $role = sanitize_input($role);
    
    // Hash password before storing in database (consider using PHP's password_hash() function)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user into database
    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
    
    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Example usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    if (add_user($username, $password, $role)) {
        echo "User added successfully";
    } else {
        echo "Error adding user";
    }
}
?>
