<?php
// Start session to access current session data
session_start();

// Clear all session variables
$_SESSION = [];

// If session uses cookies, remove the session cookie by setting it to expire
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'], $params['secure'], $params['httponly']
    );
}

// Destroy the session completely
session_destroy();

// Redirect user to the login page after logout
header('Location: index.php');
exit;
