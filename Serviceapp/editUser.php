<?php
// editUser.php - Edit User Page
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "truck";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";
$success_message = "";
$user_data = null;

// Check if user ID is provided
if (isset($_GET['id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Fetch user data
    $sql = "SELECT user_id, username, email, user_type FROM users WHERE user_id = '$user_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
    } else {
        $error_message = "User not found!";
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    
    // Check if username already exists for another user
    $check_sql = "SELECT user_id FROM users WHERE username = '$username' AND user_id != '$user_id'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        $error_message = "Username already exists!";
    } else {
        // Update user information
        $update_sql = "UPDATE users SET username = '$username', email = '$email', user_type = '$user_type' WHERE user_id = '$user_id'";
        
        // If password is provided, update it too
        if (!empty($_POST['password'])) {
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET username = '$username', email = '$email', user_type = '$user_type', password = '$hashed_password' WHERE user_id = '$user_id'";
        }
        
        if ($conn->query($update_sql) === TRUE) {
            $success_message = "User updated successfully!";
            
            // Refresh user data
            $refresh_sql = "SELECT user_id, username, email, user_type FROM users WHERE user_id = '$user_id'";
            $refresh_result = $conn->query($refresh_sql);
            $user_data = $refresh_result->fetch_assoc();
        } else {
            $error_message = "Error updating user: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP - Edit User</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md py-3" style="background: var(--bs-gray-100);">
        <div class="container">
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-3">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php" style="font-weight: bold;">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="viewtrucks.php" style="font-weight: bold;">SERVICE LOG</a></li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link active" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="font-weight: bold;">MORE</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="addTruck.php">Add Truck</a>
                            <a class="dropdown-item" href="addUser.php">Add User</a>
                            <a class="dropdown-item" href="users.php">Manage Users</a>
                            <a class="dropdown-item" href="profile.php">Profile</a>
                        </div>
                    </li>
                </ul>
                <a href="logout.php" class="btn btn-primary" style="background: #f05757;border-style: none;">Logout</a>
            </div>
        </div>
    </nav>
    
    <section class="py-4 py-xl-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>EDIT USER</h2>
                    <p class="w-lg-50">Update user information and permissions</p>
                </div>
            </div>
            
            <!-- Display messages -->
            <?php if ($success_message): ?>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-xl-4">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $success_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-xl-4">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($user_data): ?>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-xl-4">
                        <div class="card mb-5">
                            <div class="card-body">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $user_data['user_id']); ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $user_data['user_id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">User ID</label>
                                        <input class="form-control" type="text" value="<?php echo $user_data['user_id']; ?>" disabled>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input class="form-control" type="text" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">User Type</label>
                                        <select class="form-select" name="user_type" required>
                                            <option value="admin" <?php echo ($user_data['user_type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                            <option value="driver" <?php echo ($user_data['user_type'] == 'driver') ? 'selected' : ''; ?>>Driver</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">New Password (leave blank to keep current)</label>
                                        <input class="form-control" type="password" name="password" placeholder="Enter new password">
                                        <small class="text-muted">Only fill this if you want to change the password</small>
                                    </div>
                                    
                                    <div class="mb-3 d-flex justify-content-between">
                                        <a href="users.php" class="btn btn-secondary">Cancel</a>
                                        <button class="btn btn-primary" type="submit" style="background: #f05757; border: none;">Update User</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 text-center">
                        <div class="alert alert-warning">
                            User not found. <a href="users.php">Return to user management</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>

<?php $conn->close(); ?>