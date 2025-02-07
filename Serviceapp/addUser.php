<?php 
session_start();
require "config/conn.php";
require "verify.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $role = htmlspecialchars(trim($_POST["role"]));
    $password = $_POST["password"];

    if (!empty($name) && !empty($role) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (user_name, role, password) VALUES (:name, :role, :password)";
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":role", $role, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                echo "<script>alert('User added successfully!');</script>";
            } else {
                echo "<script>alert('Error adding user.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
    
    $conn = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <section class="py-4 py-xl-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>ADD NEW USER</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center">
                            <form class="text-center" method="post">
                                <div class="mb-3"><input class="form-control" type="text" name="name" placeholder="User Name" required></div>
                                <div class="mb-3">
                                    <select class="form-select" name="role" required>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                                <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password" required></div>
                                <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Add User</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
