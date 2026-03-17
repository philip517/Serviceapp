<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP - Add User</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
</head>

<body>
    <?php
    // Start session to check if user is logged in and is admin
    session_start();
    
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "truck";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize message variables
    $success_message = "";
    $error_message = "";

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
        $password = $_POST['password'];
        
        // Validate input
        if (empty($name) || empty($user_type) || empty($password)) {
            $error_message = "All fields are required!";
        } else {
            // Check if username already exists
            $check_sql = "SELECT username FROM users WHERE username = '$name'";
            $check_result = $conn->query($check_sql);
            
            if ($check_result->num_rows > 0) {
                $error_message = "Username already exists!";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user (email is optional, set to empty string if not provided)
                $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
                
                $insert_sql = "INSERT INTO users (username, password, email, user_type) 
                               VALUES ('$name', '$hashed_password', '$email', '$user_type')";
                
                if ($conn->query($insert_sql) === TRUE) {
                    $success_message = "User added successfully!";
                } else {
                    $error_message = "Error: " . $conn->error;
                }
            }
        }
    }

    $conn->close();
    ?>

    <nav class="navbar navbar-light navbar-expand-md py-3" style="background: var(--bs-gray-100);border-color: var(--bs-blue);border-bottom-width: 32px;border-bottom-color: var(--bs-danger);">
        <div class="container"><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-3" style="background: var(--bs-white);color: var(--bs-gray-700);">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="home.php" style="color: var(--bs-gray-700);font-weight: bold;">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="viewtrucks.php" style="color: var(--bs-gray-700);font-weight: bold;">SERVICE LOG</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="font-weight: bold;font-size: 16px;color: var(--bs-navbar-active-color);">MORE</a>
                        <div class="dropdown-menu"><a class="dropdown-item" href="addTruck.php">Add Truck</a><a class="dropdown-item" href="profile.php">Profile</a><a class="dropdown-item" href="addUser.php">Add User</a></div>
                    </li>
                </ul>
                <a href="logout.php" class="btn btn-primary" style="background: #f05757;border-style: none;">Logout</a>
            </div>
        </div>
    </nav>
    
    <section class="py-4 py-xl-5">
        <div class="container" style="border-radius: 3px;">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>ADD NEW USER</h2>
                </div>
            </div>
            
            <!-- Display success or error messages -->
            <?php if ($success_message): ?>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-xl-4">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $success_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-xl-4">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="row d-flex justify-content-center" style="border-radius: 29px;">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center" style="border-top-style: solid;border-top-color: var(--bs-black);border-right-style: solid;border-right-color: var(--bs-black);border-bottom: 2.4px solid var(--bs-gray-900);border-left-style: solid;border-left-color: var(--bs-black);">
                            <header></header>
                            <form class="text-center" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3">
                                    <input class="form-control" type="text" name="name" placeholder="User Name" required>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="email" name="email" placeholder="Email (Optional)">
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" name="user_type" required>
                                        <option value="admin">Admin</option>
                                        <option value="driver" selected>Driver</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100" type="submit" style="background: #f05757; border: none;">Add User</button>
                                </div>
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