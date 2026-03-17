<?php
// Database connection (XAMPP defaults)
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'truck';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
	error_log('Database connection failed: ' . $conn->connect_error);
	$conn = false;
} else {
	$conn->set_charset('utf8mb4');
}

?>
