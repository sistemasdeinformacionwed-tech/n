<?php
session_start();

// Database connection parameters
$host = 'localhost';
$dbname = 'your_db_name';
$username = 'your_db_username';
$password = 'your_db_password';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Validate user credentials
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $stmt->bind_param('ss', $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User found, create session
        $_SESSION['username'] = $user;
        header('Location: dashboard.php'); // Redirect to dashboard
        exit();
    } else {
        echo 'Invalid username or password';
    }
}

$conn->close();
?>