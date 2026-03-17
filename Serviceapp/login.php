<?php
session_start();
// Load DB connection if available
require_once __DIR__ . '/config/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username === '' || $password === '') {
    header('Location: index.php?error=1');
    exit;
}

// If config/conn.php didn't provide a $conn, create a default mysqli connection
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

$stmt = $conn->prepare('SELECT user_id, username, password, user_type, email FROM users WHERE username = ? LIMIT 1');
if (!$stmt) {
    header('Location: index.php?error=db');
    exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['user_type'] = $user['user_type'];
    $_SESSION['email'] = $user['email'];
    header('Location: home.php');
    exit;
}

// Invalid credentials
header('Location: index.php?error=1');
exit;
