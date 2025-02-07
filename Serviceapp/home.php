<?php
require "config/conn.php";
require "verify.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $_SESSION['searchQuery'] = trim($_POST['search']);
  

}
// Check if a search term was submitted
$searchQuery = isset($_POST['search']) ? trim($_POST['search']) : "";

// Fetch data from the database with filtering
try {
    $stmt = $pdo->prepare("
        SELECT 
            services.id,
            services.truck_id,
            services.service_date,
            trucks.truck_plate,
            services.job_card_number,
            services.odometer,
            services.next_service,
            mechanic.name AS mechanic_name
        FROM services
        INNER JOIN trucks ON services.truck_id = trucks.id
        INNER JOIN mechanic ON services.mech_id = mechanic.id
        WHERE trucks.truck_plate LIKE :searchQuery
        ORDER BY services.service_date DESC
    ");
    
    $stmt->execute(['searchQuery' => "%$searchQuery%"]);
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['msg'] = "Error: " . $e->getMessage();
}

// Clear search when the page is refreshed
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    unset($_SESSION['searchQuery']);
    // Redirect to clear POST data and prevent resubmission alert
    header("Location: home.php?search=" );
    exit();
   
}
?>

<!DOCTYPE html>
<html lang="en" style="background: var(--bs-gray-400);">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>

<body style="background: var(--bs-gray-400);text-align: center;">
    <nav class="navbar navbar-light navbar-expand-md py-3" style="background: var(--bs-gray-100);border-bottom-width: 32px;border-bottom-color: var(--bs-danger);">
        <div class="container">
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-3">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="home.php">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="viewtrucks.php">SERVICE LOG</a></li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">MORE</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="addTruck.php">Add Truck</a>
                            <a class="dropdown-item" href="profile.php">Profile</a>
                        </div>
                    </li>
                </ul>
                <a href="index.php" class="btn btn-primary" type="button" style="background: #f05757;border-style: none;">LOGOUT</a>
            </div>
        </div>
    </nav>

    <section style="height: 600px;">
        <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px; margin-top: 10px;">
            <div class="row">
                <div class="col"></div>
                <div class="col">
                    <!-- Search Form -->
                    <form method="POST" action="" style="display: flex;">
                        <input class="form-control" type="search" name="search" style="width: 276.9px;" placeholder="Search by plate number..." value="<?= htmlspecialchars($searchQuery) ?>">
                        <input class="btn btn-primary" type="submit" value="Search">
                    </form>
                </div>
                <div class="col"></div>
            </div>
        </div>

        <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">DATE</th>
                            <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">PLATE NUMBER</th>
                            <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">JC NUMBER</th>
                            <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">CURRENT KM</th>
                            <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">NEXT SERVICE KM</th>
                            <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">MECHANIC</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php if (!empty($services)) : ?>
        <?php foreach ($services as $service) : ?>
            <tr style="border-bottom:solid 2px black; cursor: pointer;"
                onclick="window.location.href='truck.php?truck_id=<?= $service['truck_id'] ?>'">
                <td style="text-align: center;"><?= htmlspecialchars($service['service_date']) ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($service['truck_plate']) ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($service['job_card_number']) ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($service['odometer']) ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($service['next_service']) ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($service['mechanic_name']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="6" style="text-align: center;">No service records found.</td>
        </tr>
    <?php endif; ?>
</tbody>
                </table>
            </div>
        </div>
    </section>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
