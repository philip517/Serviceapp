<?php
session_start();
require "config/conn.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $password = $_POST['password'];

    // Check if name and password are not empty
    if (!empty($name) && !empty($password)) {
        try {
            // Query to fetch user by name
            $sql = "SELECT * FROM users WHERE user_name = :name";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();

            // Fetch user details
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Successful login
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'role' => $user['role']
                ];
                
                echo "<div class='alert alert-success text-center'>Login successful! Welcome, " . htmlspecialchars($user['name']) . "</div>";
                
                // Redirect based on role
                if ($user['role'] == 'admin') {
                    $_SESSION['msg'] = "WELCOME ADMIN";
                    header("Location: home.php");
                    exit;
                } else {
                    header("Location: dashboard.php");
                    exit;
                }
            } else {
                // Invalid credentials
                echo "<div class='alert alert-danger text-center'>Invalid username or password. Please try again.</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger text-center'>Error: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning text-center'>Please fill in both username and password.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
</head>

<body>
    <section class="py-4 py-xl-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h1>Login to Your Account</h1>
                    <p>Please enter your name and password to log in.</p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="bs-icon-xl bs-icon-circle bs-icon-primary bs-icon my-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"></path>
                                </svg>
                            </div>
                            <form class="text-center" method="post">
                                <div class="mb-3"><input class="form-control" type="text" name="name" placeholder="Name" required></div>
                                <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password" required></div>
                                <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Login</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>
