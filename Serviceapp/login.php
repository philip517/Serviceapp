<?php
// Start session for user authentication
session_start();

// Load database connection configuration
require_once __DIR__ . '/config/conn.php';

// Check if request is POST, otherwise redirect to login page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Retrieve and sanitize username and password from POST data
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validate that both fields are provided
if ($username === '' || $password === '') {
    header('Location: index.php?error=1');
    exit;
}

// If database connection is not available, create a default connection
if (!isset($conn) || !$conn) {
    $dbHost = '127.0.0.1';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'truck';
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($conn->connect_error) {
        header('Location: index.php?error=db');
        exit;
    }
}

// Prepare SQL query to fetch user data by username
$stmt = $conn->prepare('SELECT user_id, username, password, user_type, email FROM users WHERE username = ? LIMIT 1');
if (!$stmt) {
    header('Location: index.php?error=db');
    exit;
}

// Bind username parameter and execute query
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Verify password and set session if valid
if ($user && password_verify($password, $user['password'])) {
    // Regenerate session ID for security
    session_regenerate_id(true);
    // Store user information in session
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['user_type'] = $user['user_type'];
    $_SESSION['email'] = $user['email'];
    // Redirect to home page after successful login
    header('Location: home.php');
    exit;
}

// If credentials are invalid, redirect back to login with error
header('Location: index.php?error=1');
exit;
