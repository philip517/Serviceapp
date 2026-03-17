<?php
// users.php - User Management Page
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

// Handle delete request
if (isset($_GET['delete'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['delete']);
    
    // Prevent deleting the main admin (optional)
    if ($user_id != 1) { // Assuming admin has user_id = 1
        $delete_sql = "DELETE FROM users WHERE user_id = '$user_id'";
        if ($conn->query($delete_sql) === TRUE) {
            $success_message = "User deleted successfully!";
        } else {
            $error_message = "Error deleting user: " . $conn->error;
        }
    } else {
        $error_message = "Cannot delete the main admin user!";
    }
}

// Fetch all users
$users_sql = "SELECT user_id, username, email, user_type, created_at FROM users ORDER BY user_id DESC";
$users_result = $conn->query($users_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP - User Management</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                            <a class="dropdown-item active" href="users.php">Manage Users</a>
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
                    <h2>USER MANAGEMENT</h2>
                    <p class="w-lg-50">Manage system users and their permissions</p>
                </div>
            </div>
            
            <!-- Display messages -->
            <?php if (isset($success_message)): ?>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-10">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $success_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-10">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">System Users</h5>
                            <a href="addUser.php" class="btn btn-primary btn-sm" style="background: #f05757; border: none;">
                                <i class="fas fa-plus"></i> Add New User
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>User Type</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($users_result->num_rows > 0): ?>
                                            <?php while($row = $users_result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo $row['user_id']; ?></td>
                                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td>
                                                        <?php if ($row['user_type'] == 'admin'): ?>
                                                            <span class="badge bg-danger">Admin</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-primary">Driver</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                    <td>
                                                        <a href="editUser.php?id=<?php echo $row['user_id']; ?>" class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <?php if ($row['user_id'] != 1): // Prevent deleting main admin ?>
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['user_id']; ?>)">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        <?php else: ?>
                                                            <span class="text-muted"><small>Protected</small></span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No users found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                pageLength: 10,
                order: [[0, 'desc']]
            });
        });
        
        function confirmDelete(userId) {
            document.getElementById('confirmDeleteBtn').href = 'users.php?delete=' + userId;
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>

</html>

<?php $conn->close(); ?>