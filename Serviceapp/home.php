<?php
// Include the database connection file
require_once __DIR__ . '/config/conn.php';

// Initialize variables for search and truck data
$search_plate = '';
$trucks = [];

// Check if database connection is established
if ($conn) {
    // Get search query from GET parameter and sanitize it
    $search_plate = isset($_GET['search']) ? strtoupper(trim($_GET['search'])) : '';
    
    // If search is provided, query trucks matching the plate
    if ($search_plate !== '') {
        $truck_query = 'SELECT t.truck_id, t.number_plate, t.model, COUNT(sr.service_id) as service_count 
                        FROM trucks t 
                        LEFT JOIN service_records sr ON t.truck_id = sr.truck_id 
                        WHERE t.number_plate LIKE ? 
                        GROUP BY t.truck_id';
        $stmt = $conn->prepare($truck_query);
        if ($stmt) {
            $like_plate = '%' . $search_plate . '%';
            $stmt->bind_param('s', $like_plate);
            $stmt->execute();
            $result = $stmt->get_result();
            // Fetch and store truck data
            while ($row = $result->fetch_assoc()) {
                $trucks[] = $row;
            }
            $stmt->close();
        }
    } else {
        // If no search, fetch all trucks with service counts
        $query = 'SELECT t.truck_id, t.number_plate, t.model, COUNT(sr.service_id) as service_count 
                  FROM trucks t 
                  LEFT JOIN service_records sr ON t.truck_id = sr.truck_id 
                  GROUP BY t.truck_id 
                  ORDER BY t.created_at DESC';
        $result = $conn->query($query);
        if ($result) {
            // Fetch and store all truck data
            while ($row = $result->fetch_assoc()) {
                $trucks[] = $row;
            }
            $result->free();
        }
    }
}
?>

<!DOCTYPE >

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
    <style>
        tbody tr:hover {
            background-color: #d0d0d0 !important;
            transition: background-color 0.2s ease;
        }
        tbody tr:hover td {
            background-color: #d0d0d0 !important;
        }
    </style>
</head>

<body style="background: var(--bs-gray-400);text-align: center;height: 690.2px;">
    
      <?php include 'nav.php'; ?>

    <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);margin-top: 20px;">
        <form method="get" action="home.php" style="text-align: center;">
            <input type="text" name="search" placeholder="Search by number plate..." value="<?php echo htmlspecialchars($search_plate); ?>" style="width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <button type="submit" class="btn btn-sm" style="background: #f05757; border: none; color: white; padding: 8px 16px; margin-left: 10px;">Search</button>
            <?php if ($search_plate !== ''): ?>
                <a href="home.php" class="btn btn-sm" style="background: #6c757d; border: none; color: white; padding: 8px 16px; margin-left: 5px;">Clear</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);">
        <div class="table-responsive" style="background: var(--bs-table-border-color);margin-top: 0px;border-style: none;border-color: #d92323;border-bottom-style: none;box-shadow: 0px 0px 20px 5px var(--bs-gray-600);padding-top: 0px;">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 136.3px;">NUMBER PLATE</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">MODEL</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">NUMBER OF SERVICES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($trucks)): ?>
                        <?php foreach ($trucks as $truck): ?>
                            <tr onclick="window.location.href='truck.php?plate=<?php echo urlencode($truck['number_plate']); ?>';" style="cursor: pointer;">
                                <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($truck['number_plate']); ?></td>
                                <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars(strtoupper($truck['model'])); ?></td>
                                <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($truck['service_count']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">No trucks found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</>