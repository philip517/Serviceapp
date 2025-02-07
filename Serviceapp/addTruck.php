<?php
session_start();
require "config/conn.php"; 
require "verify.php";
// Insert truck data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate form data
    $truck_plate = strtoupper(trim($_POST['truck_plate']));  // Convert to uppercase
    $model = strtoupper(trim($_POST['model']));  // Convert to uppercase
    $country = strtoupper($_POST['country']);  // Convert country to uppercase
    
    // Validate country-specific number plate
    if ($country == 'ZAMBIA') {
        if (!preg_match("/^[A-Za-z]{3}[0-9]{3,4}$/", $truck_plate)) {
            $error = "For Zambia, the number plate must start with three letters followed by three or four digits.";
        }
    }

    // Check if the truck plate already exists in the database
    if (!isset($error)) {
        $query = "SELECT COUNT(*) FROM trucks WHERE truck_plate = ? AND country = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$truck_plate, $country]);
        $exists = $stmt->fetchColumn();

        // If the truck already exists, show an error
        if ($exists > 0) {
            $error = "This truck plate already exists for the selected country.";
        } else {
            // Insert into database if valid and no duplicates
            $query = "INSERT INTO trucks (truck_plate, model, country) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$truck_plate, $model, $country]);

            // After successful submission, redirect to avoid resubmission on page refresh
            header("Location: " . $_SERVER['PHP_SELF']);
            exit(); // Ensure the script stops executing after redirect
        }
    }
}

// Fetch trucks to display in the table
$query = "SELECT id, truck_plate, model, country FROM trucks";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" style="background: var(--bs-gray-400);">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
</head>

<body style="background: var(--bs-gray-400); text-align: center; height: 690.2px;">
    <nav class="navbar navbar-light navbar-expand-md py-3" style="background: var(--bs-gray-100); border-color: var(--bs-blue); border-bottom-width: 32px; border-bottom-color: var(--bs-danger);">
        <div class="container">
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-3" style="background: var(--bs-white); color: var(--bs-gray-700);">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="home.php" style="color: var(--bs-gray-700); font-weight: bold;">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="viewtrucks.php" style="color: var(--bs-gray-700); font-weight: bold;">SERVICE LOG</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="font-weight: bold;font-size: 16px;color: var(--bs-navbar-active-color);">MORE</a>
                        <div class="dropdown-menu"><a class="dropdown-item" href="addTruck.php">Add Truck</a><a class="dropdown-item" href="profile.">Profile</a><a class="dropdown-item" href="#">Third Item</a></div>
                    </li>
                </ul>
                <button class="btn btn-primary" type="button" style="background: #f05757; border-style: none;">Button</button>
            </div>
        </div>
    </nav>

    <div class="container" style="background: rgba(8,6,6,0); width: 800px; padding-bottom: 18px; border-style: none; box-shadow: 0px 0px var(--bs-indigo); text-align: center; margin-top: 10px; margin-bottom: 51px;">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div>
                    <div class="card" style="margin-bottom: 0px;padding-bottom: 0px;">
                        <form method="POST" action="addTruck.php" style="width: 708px; display: block; height: 100%;">
                            <h4 style="height: 53.2px; font-weight: bold; font-size: 37.7px; margin-top: 25px; margin-bottom: 25px;">ADD TRUCK</h4>
                            <div style="width: 708px; text-align: left; padding-left: 50px; margin-bottom: 10px; display: flex;">
                                <label class="form-label d-md-flex align-items-md-center" style="padding-right: 0px; margin-right: 10px; height: 36px; padding-top: 5px;">Truck Number Plate</label>
                                <input class="form-control" type="text" name="truck_plate" value="" style="margin-bottom: 13px; position: relative; display: inline; width: 300px;" required>
                                <div style="position: relative; display: flex; width: 180px; margin-left: 20px;">
                                    <div class="form-check" style="padding-top: 10px;">
                                        <input class="form-check-input" type="radio" id="formCheck-2" name="country" value="tanzania" required>
                                        <label class="form-check-label" for="Tanzania">TZ</label>
                                    </div>
                                    <div class="form-check" style="padding-top: 10px; margin-left: 15px;">
                                        <input class="form-check-input" type="radio" id="formCheck-1" name="country" value="zambia" required>
                                        <label class="form-check-label" for="Zambia">ZAM</label>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: left; padding-left: 50px;">
                                <label class="form-label" style="padding-right: 0px; margin-right: 31px;">Model</label>
                                <select class="form-select" name="model" style="width: 300px; display: inline; position: relative; height: 40px;">
                                    <option value="faw" selected="">FAW</option>
                                    <option value="sino">SINO</option>
                                </select>
                            </div>
                            <div style="height: 51px;"></div>
                            
                            <!-- Error Alert with Close Button -->
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error: </strong> <?= $error ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary" style="width: 150px; font-size: 16px;">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>

    <div class="container" style="background: rgba(8,6,6,0); width: 732px; padding-bottom: 18px; border-style: none; box-shadow: 0px 0px var(--bs-indigo);">
        <div class="table-responsive" style="background: var(--bs-table-border-color); margin-top: 0px; border-style: none; border-color: #d92323; border-bottom-style: none; box-shadow: 0px 0px 20px 5px var(--bs-gray-600); padding-top: 0px;">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center; background: var(--bs-black); color: #d7d7d7; width: 136.3px;">TRUCK MODEL</th>
                        <th style="text-align: center; background: var(--bs-black); color: #d7d7d7;">NUMBER PLATE</th>
                        <th style="text-align: center; background: var(--bs-black); color: #d7d7d7;">COUNTRY</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row): ?>
                        <tr onclick="window.location.href='truck.php?id=<?= $row['id'] ?>'">
                            <td style="text-align: center;"><?= strtoupper(htmlspecialchars($row['model'])) ?></td> <!-- Uppercase model -->
                            <td style="text-align: center;"><?= strtoupper(htmlspecialchars($row['truck_plate'])) ?></td> <!-- Uppercase number plate -->
                            <td style="text-align: center;"><?= strtoupper(htmlspecialchars($row['country'])) ?></td> <!-- Uppercase country -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>
</html>
