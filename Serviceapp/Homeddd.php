<?php
require_once __DIR__ . '/config/conn.php';

$search_plate = '';
$service_records = [];

if ($conn) {
    $search_plate = isset($_GET['search']) ? strtoupper(trim($_GET['search'])) : '';
    
    if ($search_plate !== '') {
        $query = 'SELECT sr.service_id, sr.service_date, sr.service_kilometers, sr.next_due_kilometers, sr.jobcard_number, t.number_plate 
                  FROM service_records sr 
                  JOIN trucks t ON sr.truck_id = t.truck_id 
                  WHERE t.number_plate LIKE ? 
                  ORDER BY sr.service_date DESC';
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $like_plate = '%' . $search_plate . '%';
            $stmt->bind_param('s', $like_plate);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $service_records[] = $row;
            }
            $stmt->close();
        }
    } else {
        $query = 'SELECT sr.service_id, sr.service_date, sr.service_kilometers, sr.next_due_kilometers, sr.jobcard_number, t.number_plate 
                  FROM service_records sr 
                  JOIN trucks t ON sr.truck_id = t.truck_id 
                  ORDER BY sr.service_date DESC LIMIT 50';
        $result = $conn->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $service_records[] = $row;
            }
            $result->free();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" style="background: var(--bs-gray-400);">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
</head>

<body style="background: var(--bs-gray-400);text-align: center;">
    <nav class="navbar navbar-light navbar-expand-md py-3" style="background: var(--bs-gray-100);border-color: var(--bs-blue);border-bottom-width: 32px;border-bottom-color: var(--bs-danger);">
        <div class="container"><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-3" style="background: var(--bs-white);color: var(--bs-gray-700);">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="home.php" style="color: var(--bs-gray-700);font-weight: bold;">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="viewtrucks.php" style="color: var(--bs-gray-700);font-weight: bold;">SERVICE LOG</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="font-weight: bold;font-size: 16px;color: var(--bs-navbar-active-color);">MORE</a>
                        <div class="dropdown-menu"><a class="dropdown-item" href="addTruck.php">Add Truck</a><a class="dropdown-item" href="profile.php">Profile</a><a class="dropdown-item" href="#">Third Item</a></div>
                    </li>
                </ul><button class="btn btn-primary" type="button" style="background: #f05757;border-style: none;">Button</button>
            </div>
        </div>
    </nav>
    <section style="height: 600px;">
        <div class="container" style="height: 131px;">
            <div></div>
        </div>
        <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);text-align: center;margin-top: 10px;">
            <div class="row">
                <div class="col"></div>
                <div class="col">
                    <form method="get" action="home.php" style="display: flex;"><input class="form-control" type="search" name="search" style="width: 276.9px;border-radius: 0px;" placeholder="ABC123..........." value="<?php echo htmlspecialchars($search_plate); ?>"><input class="btn btn-primary" type="submit" data-bss-hover-animate="pulse" style="border-radius: 0px;background: var(--bs-black);border-style: none;" value="Search"></form>
                </div>
                <div class="col"></div>
            </div>
        </div>
        <div style="height: 200px;"></div>
        <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);">
            <div class="table-responsive" style="background: var(--bs-table-border-color);margin-top: 0px;border-style: none;border-color: #d92323;border-bottom-style: none;box-shadow: 0px 0px 20px 5px var(--bs-gray-600);padding-top: 0px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 98.8px;">DATE</th>
                            <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 136.3px;">PLATE NUMBER</th>
                            <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">JC NUMBER</th>
                            <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">CURRENT KM</th>
                            <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 172.9px;padding-right: 10px;margin-right: -8px;">NEXT SERVICE KM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($service_records)): ?>
                            <?php foreach ($service_records as $record): ?>
                                <tr onclick="window.location.href='truck.php?plate=<?php echo urlencode($record['number_plate']); ?>';" style="cursor: pointer;">
                                    <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars(date('Y-m-d', strtotime($record['service_date']))); ?></td>
                                    <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($record['number_plate']); ?></td>
                                    <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($record['jobcard_number'] ?: 'N/A'); ?></td>
                                    <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($record['service_kilometers']); ?></td>
                                    <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($record['next_due_kilometers']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">No service records found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>