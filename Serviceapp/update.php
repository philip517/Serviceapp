<?php
// create_hash.php
echo "Password Hash Generator\n";
echo "======================\n\n";

// The password you want to hash
$password = "admin123";

// Generate hash
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: " . $password . "\n";
echo "Hash: " . $hash . "\n\n";

echo "Copy this hash for your database:\n";
echo "----------------------------------\n";
echo $hash . "\n";
echo "----------------------------------\n\n";

// Verification test
if (password_verify($password, $hash)) {
    echo "✓ Verification successful! The hash works correctly.\n";
} else {
    echo "✗ Verification failed! Something went wrong.\n";
}

// Show different hash options
echo "\n\nAlternative hash (if the above doesn't work):\n";
$hash_alt = password_hash($password, PASSWORD_BCRYPT);
echo $hash_alt . "\n";
?>