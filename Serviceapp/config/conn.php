<?php
// config/conn.php - Database Connection Configuration
// This file establishes a connection to the MySQL database using mysqli

// Define database connection parameters (XAMPP defaults)
$DB_HOST = '127.0.0.1';  // Database host (localhost)
$DB_USER = 'root';      // Database username
$DB_PASS = '';          // Database password (empty for XAMPP default)
$DB_NAME = 'truck';     // Database name

// Create a new mysqli connection object
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Check if the connection was successful
if ($conn->connect_error) {
	// Log the error and set $conn to false for error handling
	error_log('Database connection failed: ' . $conn->connect_error);
	$conn = false;
} else {
	// Set the character set to UTF-8 for proper encoding
	$conn->set_charset('utf8mb4');
}

?>
