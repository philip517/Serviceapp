<?php
require "verify.php";
require "config/conn.php";
// Check if 'id' parameter is set in the URL, if not, redirect to home.php
if (!isset($_GET['truck_id'])) {
    header("Location: home.php");
    exit;
}
$truck_id = (int) $_GET['truck_id']; // Convert to integer for safety

try {
    $sql = "SELECT * FROM trucks WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $truck_id, PDO::PARAM_INT); // Use PARAM_INT for security
    $stmt->execute();
    $truck = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($truck) {
        $num_plate = $truck['truck_plate']; // Save truck plate as num_plate
        echo $num_plate;
    } else {
        die("Truck not found.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}


// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $job_card_number = 'JC/N/' . $_POST['jc_number'];  // Concatenate the 'JC/N/' prefix
    $odometer = $_POST['kilometer'];
    $mech_id = $_POST['mechanic'];

    // Validate job card number format: JC/N/1 to JC/N/9999
    if (!preg_match('/^JC\/N\/[1-9][0-9]{0,3}$/', $job_card_number)) {
        echo "Job Card Number must be in the format JC/N/1 to JC/N/9999.";
        exit;
    }

    // Validate odometer input (ensure it's a positive number)
    if ($odometer <= 0 || !is_numeric($odometer)) {
        echo "Odometer must be a positive number greater than 0.";
        exit;
    }

    // Check if the odometer is greater than the last service's odometer
    $stmt = $pdo->prepare("SELECT MAX(odometer) AS last_odometer FROM services WHERE truck_id = :truck_id");
    $stmt->bindParam(':truck_id', $truck_id);
    $stmt->execute();
    $last_service = $stmt->fetch(PDO::FETCH_ASSOC);

    // if ($last_service && $odometer <= $last_service['last_odometer']) {
    //     echo "Odometer value must be greater than the previous service's odometer.";
    //     exit;
    // }

    // Check if the odometer is within a valid range (optional)
    if ($odometer > 1000000) {
        echo "Odometer value cannot exceed 1,000,000 km.";
        exit;
    }

    // Check if the job card number already exists for the given truck ID
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM services WHERE truck_id = :truck_id AND job_card_number = :job_card_number");
    $stmt->bindParam(':truck_id', $truck_id);
    $stmt->bindParam(':job_card_number', $job_card_number);
    $stmt->execute();
    $existingRecord = $stmt->fetchColumn();

    if ($existingRecord > 0) {
        echo "This job card number already exists for the selected truck.";
        exit;
    }

    // Calculate next service mileage (add 20,000 to the current odometer value)
    $next_service = $odometer + 20000;

    // Get the current date (service date)
    $service_date = date("Y-m-d");

    try {
        // Insert the service data into the database
        $stmt = $pdo->prepare("INSERT INTO services (truck_id, job_card_number, service_date, odometer, next_service, mech_id) 
                                VALUES (:truck_id, :job_card_number, :service_date, :odometer, :next_service, :mech_id)");

        // Bind parameters to the prepared statement
        $stmt->bindParam(':truck_id', $truck_id);
        $stmt->bindParam(':job_card_number', $job_card_number);
        $stmt->bindParam(':service_date', $service_date);
        $stmt->bindParam(':odometer', $odometer);
        $stmt->bindParam(':next_service', $next_service);
        $stmt->bindParam(':mech_id', $mech_id);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Service record added successfully.";
        } else {
            echo "Error: Unable to add service record.";
        }

        // Redirect to the same page to prevent resubmission prompt
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Fetch mechanics from the database using PDO
try {
    $stmt = $pdo->prepare("SELECT id, name FROM mechanic");
    $stmt->execute();
    $mechanics = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
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
<body style="background: var(--bs-gray-400); text-align: center;">
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

    <!-- Navbar and content -->
    <div class="container" style="height: 71px;">
        <div></div>
    </div>
    <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);text-align: center;margin-top: 10px;margin-bottom: 51px;">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div>
                    <div class="card">
                        <h1 class="d-md-flex flex-column-reverse justify-content-center align-items-center align-content-center justify-content-md-center" style="height: 69.2px;background: var(--bs-black);color: var(--bs-gray-400);"><?php echo $num_plate;?></h1>
                        <div class="card-body" style="width: 708PX;">
                            <form method="POST" style="display: block;position: relative;width: 708PX;">
                                <!-- Form fields -->
                                <div style="width: 708px;display: flex;position: relative;">
                                    <label class="form-label d-md-flex align-items-md-center" style="padding-top: 0px;margin-right: 15px;">ODOMETER</label>
                                    <input class="form-control" type="number" name="kilometer" max="999999" min="0" placeholder="000000" style="height: 38px;margin-right: 0px;width: 350.7px;" required>
                                    <span class="text-uppercase d-md-flex align-items-md-center" style="margin-left: 10px;width: 200px;text-align: center;">Text</span>
                                </div>
                                <div style="display: flex;margin: 0px;margin-top: 18px;">
                                    <label class="form-label d-md-flex align-items-md-center" style="width: 88.3px;padding-bottom: 0px;margin-bottom: 0px;padding-left: 0px;padding-right: 0px;padding-top: 0px;margin-right: 15px;">JC NUMBER</label>
                                    <!-- Job card number field with the 'JC/N/' prefix already added -->
                                    <input class="form-control" type="text" style="width: 350PX;" name="jc_number" placeholder="1 to 999999" autocomplete="off" pattern="^[1-9][0-9]{0,3}$" required title="Enter the last part of JC/N/1 to JC/N/9999.">
                                </div>
                                <div style="display: flex;margin: 0px;margin-top: 18px;">
                                    <label class="form-label d-md-flex align-items-md-center" style="width: 88.3px;padding-bottom: 0px;margin-bottom: 0px;padding-left: 0px;padding-right: 0px;margin-right: 15px;">MECHANIC</label>
                                    <select class="form-select" name="mechanic" style="width: 352px;margin-left: -1px;" required>
                                        <?php foreach ($mechanics as $mechanic) { ?>
                                            <option value="<?php echo $mechanic['id']; ?>"><?php echo $mechanic['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div style="margin-top: 25px;margin-bottom: 25px;">
                                    <input class="btn btn-success" type="submit" style="margin: 0px;width: 140px;background: var(--bs-success);" value="ADD SERVICE" name="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>

    <!-- Service table -->
    <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);">
        <div class="table-responsive" style="background: var(--bs-table-border-color);margin-top: 0px;border-style: none;border-color: #d92323;border-bottom-style: none;box-shadow: 0px 0px 20px 5px var(--bs-gray-600);padding-top: 0px;">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 136.3px;">DATE</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">JC NUMBER</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">CURRENT KM</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 172.9px;padding-right: 10px;margin-right: -8px;">NEXT SERVICE KM</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 135.8px;">MECHANIC</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch the service records from the database and display them in the table
                    try {
                        $stmt = $pdo->prepare("SELECT * FROM services WHERE truck_id = :truck_id ORDER BY service_date DESC");
                        $stmt->bindParam(':truck_id', $truck_id);
                        $stmt->execute();
                        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($services as $service) {
                            // Fetch mechanic name
                            $stmt2 = $pdo->prepare("SELECT name FROM mechanic WHERE id = :mech_id");
                            $stmt2->bindParam(':mech_id', $service['mech_id']);
                            $stmt2->execute();
                            $mechanic = $stmt2->fetch(PDO::FETCH_ASSOC);

                            echo "<tr>
                                    <td style='text-align: center;'>{$service['service_date']}</td>
                                    <td style='text-align: center;'>{$service['job_card_number']}</td>
                                    <td style='text-align: center;'>{$service['odometer']}</td>
                                    <td style='text-align: center;'>{$service['next_service']}</td>
                                    <td style='text-align: center;'>{$mechanic['name']}</td>
                                  </tr>";
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>
</html>
