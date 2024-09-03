<?php
// Start session if needed
session_start();

// Database connection details
$servername = "localhost";
$dbname = "bdams_db";
$username_db = "root";  // Replace with your DB username
$password_db = "";      // Replace with your DB password

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve POST data
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Sanitize input to prevent SQL injection
$username = $conn->real_escape_string($username);
$password = $conn->real_escape_string($password);

// You should hash the password using password_hash() during registration and verify using password_verify()
// In this example, assuming the password is stored in plain text (which is not recommended in real-life apps)
$sql = "SELECT * FROM security WHERE username = '$username' AND password = '$password'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Successful login, set session variable
    $_SESSION['username'] = $username;
    echo json_encode(['success' => true]);
} else {
    // Invalid credentials
    echo json_encode(['success' => false]);
}

// Close the database connection
$conn->close();
?>
