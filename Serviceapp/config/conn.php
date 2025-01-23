<?php
// Database configuration
$host = 'localhost';     // Database host
$dbname = 'service';  // Database name
$username = 'philip';     // Database username
$password = 'test1234';     // Database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set PDO error mode to exception for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to the database successfully!";
} catch (PDOException $e) {
    // Handle connection error
    echo "Database connection failed: " . $e->getMessage();
}

?>
