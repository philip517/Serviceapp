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
    // Start session to manage user login state
    session_start();
    
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "truck";

    // Establish database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize variables for success and error messages
    $success_message = "";
    $error_message = "";

    // Check if the form has been submitted via POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve and sanitize form input data
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
        $password = $_POST['password'];
        
        // Validate that all required fields are filled
        if (empty($name) || empty($user_type) || empty($password)) {
            $error_message = "All fields are required!";
        } else {
            // Check if the username already exists in the database
            $check_sql = "SELECT username FROM users WHERE username = '$name'";
            $check_result = $conn->query($check_sql);
            
            if ($check_result->num_rows > 0) {
                $error_message = "Username already exists!";
            } else {
                // Hash the password for secure storage
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Get email if provided, otherwise set to empty
                $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
                
                // Prepare SQL query to insert new user into database
                $insert_sql = "INSERT INTO users (username, password, email, user_type) 
                               VALUES ('$name', '$hashed_password', '$email', '$user_type')";
                
                // Execute the insert query and set appropriate message
                if ($conn->query($insert_sql) === TRUE) {
                    $success_message = "User added successfully!";
                } else {
                    $error_message = "Error: " . $conn->error;
                }
            }
        }
    }

    // Close the database connection
    $conn->close();
    ?>

    <?php include 'nav.php'; ?>
    
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