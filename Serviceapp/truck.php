<?php
include 'config/conn.php';
if (!$conn) {
    die("DB connection failed");
}
$plate = $_GET['plate'] ?? '';
if (!$plate) {
    die("No plate specified");
}
// Get truck_id
$stmt = $conn->prepare("SELECT truck_id FROM trucks WHERE number_plate = ?");
$stmt->bind_param("s", $plate);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    die("Truck not found");
}
$truck = $result->fetch_assoc();
$truck_id = $truck['truck_id'];
$stmt->close();
// Handle POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $odometer = $_POST['kilometer'];
    $date = $_POST['date'];
    $jc_number = $_POST['jc_number'];
    $mechanic = $_POST['mechanic'];
    $next_due = $odometer + 10000; // assume next service at +10k km
    $stmt = $conn->prepare("INSERT INTO service_records (truck_id, service_date, service_kilometers, next_due_kilometers, jobcard_number, created_by) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isiiis", $truck_id, $date, $odometer, $next_due, $jc_number, $mechanic);
    $stmt->execute();
    $stmt->close();
    // Redirect to keep GET
    header("Location: truck.php?plate=" . urlencode($plate));
    exit;
}
// Query records
$query = "SELECT sr.service_date, sr.jobcard_number, sr.service_kilometers, sr.next_due_kilometers, m.mechanic_name as mechanic
          FROM service_records sr
          JOIN mechanic m ON sr.created_by = m.mechanic_id
          WHERE sr.truck_id = ?
          ORDER BY sr.service_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $truck_id);
$stmt->execute();
$records = $stmt->get_result();
$stmt->close();

// Query mechanics for select
$mechanics_query = "SELECT mechanic_id, mechanic_name FROM mechanic ORDER BY mechanic_name";
$mechanics_result = $conn->query($mechanics_query);
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

<body style="background: var(--bs-gray-400);text-align: center;">
    <?php include 'nav.php'; ?>

    <div class="container" style="height: 71px;">
        <div></div>
    </div>
    <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);text-align: center;margin-top: 10px;margin-bottom: 51px;">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div>
                    <div class="card">
                        <h1 class="d-md-flex flex-column-reverse justify-content-center align-items-center align-content-center justify-content-md-center" style="height: 69.2px;background: var(--bs-black);color: var(--bs-gray-400);"><?php echo htmlspecialchars($plate); ?></h1>
                        <div class="card-body" style="width: 708PX;">
                            <form style="display: block;position: relative;width: 708PX;" method="post">
                                <div style="width: 708px;display: flex;position: relative;"><label class="form-label d-md-flex align-items-md-center" style="padding-top: 0px;margin-right: 15px;">ODOMETER</label><input class="form-control" type="number" name="kilometer" max="100000" min="0" placeholder="000000" style="height: 38px;margin-right: 0px;width: 350.7px;"></div>
                                <div style="display: flex;margin: 0px;margin-top: 18px;"><label class="form-label d-md-flex align-items-md-center" style="width: 88.3px;padding-bottom: 0px;margin-bottom: 0px;padding-left: 0px;padding-right: 0px;padding-top: 0px;margin-right: 15px;">JC NUMBER</label><input class="form-control" type="text" style="width: 350PX;" name="jc_number" placeholder="JC/N/1234" autocomplete="off"></div>
                                <div style="display: flex;margin: 0px;margin-top: 18px;"><label class="form-label d-md-flex align-items-md-center" style="width: 88.3px;padding-bottom: 0px;margin-bottom: 0px;padding-left: 0px;padding-right: 0px;padding-top: 0px;margin-right: 15px;">DATE</label><input class="form-control" type="date" style="width: 350PX;" name="date" required></div>
                                <div style="display: flex;margin: 0px;margin-top: 18px;"><label class="form-label d-md-flex align-items-md-center" style="width: 88.3px;padding-bottom: 0px;margin-bottom: 0px;padding-left: 0px;padding-right: 0px;margin-right: 15px;">MECHANIC</label><select class="form-select" style="width: 352px;margin-left: -1px;" name="mechanic">
                                    <?php while ($mech = $mechanics_result->fetch_assoc()): ?>
                                    <option value="<?php echo $mech['mechanic_id']; ?>"><?php echo htmlspecialchars($mech['mechanic_name']); ?></option>
                                    <?php endwhile; ?>
                                    </select></div>
                                <div style="margin-top: 25px;margin-bottom: 25px;"><input class="btn btn-success" type="submit" style="margin: 0px;width: 140px;background: var(--bs-success);" value="ADD SERVICE" name="submit"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
    <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);">
        <div class="table-responsive" style="background: var(--bs-table-border-color);margin-top: 0px;border-style: none;border-color: #d92323;border-bottom-style: none;box-shadow: 0px 0px 20px 5px var(--bs-gray-600);padding-top: 0px;overflow: scroll;">
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
                    <?php while ($row = $records->fetch_assoc()): ?>
                    <tr>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($row['service_date']); ?></td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($row['jobcard_number']); ?></td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($row['service_kilometers']); ?></td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($row['next_due_kilometers']); ?></td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($row['mechanic']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>