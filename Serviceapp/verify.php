<?php
session_start();
require "config/conn.php";

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Verify session key
$user_id = $_SESSION['user']['id'];
$session_key = $_SESSION['user']['session_key'];

$sql = "SELECT session_key FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$db_user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$db_user || $db_user['session_key'] !== $session_key) {
    // Logout user if session key does not match
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
