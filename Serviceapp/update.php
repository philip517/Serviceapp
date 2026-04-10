<?php
// update.php - Password Hash Generator Script
// This script generates a secure password hash for use in the database

// Display header information
echo "Password Hash Generator\n";
echo "======================\n\n";

// Define the password to be hashed
$password = "admin123";

// Generate a secure hash using PASSWORD_DEFAULT algorithm
$hash = password_hash($password, PASSWORD_DEFAULT);

// Display the original password and its hash
echo "Password: " . $password . "\n";
echo "Hash: " . $hash . "\n\n";

// Provide instructions for copying the hash
echo "Copy this hash for your database:\n";
echo "----------------------------------\n";
echo $hash . "\n";
echo "----------------------------------\n\n";

// Test verification of the hash
if (password_verify($password, $hash)) {
    echo "✓ Verification successful! The hash works correctly.\n";
} else {
    echo "✗ Verification failed! Something went wrong.\n";
}

// Generate an alternative hash using PASSWORD_BCRYPT
echo "\n\nAlternative hash (if the above doesn't work):\n";
$hash_alt = password_hash($password, PASSWORD_BCRYPT);
echo $hash_alt . "\n";
?>