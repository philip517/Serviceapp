<?php
include 'config/conn.php';
if (!$conn) {
    die("DB connection failed");
}
$search = trim($_GET['search'] ?? '');
$search_type = $_GET['search_type'] ?? 'mechanic';
$where = '';
$params = [];
if ($search !== '') {
    $like = "%{$search}%";
    switch ($search_type) {
        case 'jobcard':
            $where = "AND sr.jobcard_number LIKE ?";
            $params = [$like];
            break;
        case 'plate':
            $where = "AND t.number_plate LIKE ?";
            $params = [$like];
            break;
        default:
            $where = "AND m.mechanic_name LIKE ?";
            $params = [$like];
            break;
    }
}
$sql = "SELECT sr.service_date, t.number_plate, sr.jobcard_number, sr.service_kilometers, sr.next_due_kilometers, m.mechanic_name
        FROM service_records sr
        JOIN trucks t ON sr.truck_id = t.truck_id
        LEFT JOIN mechanic m ON sr.created_by = m.mechanic_id
        WHERE 1=1 $where
        ORDER BY sr.service_date DESC";
$stmt = $conn->prepare($sql);
if ($search !== '') {
    $stmt->bind_param('s', $params[0]);
}
$stmt->execute();
$records = $stmt->get_result();
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

    <div class="container" style="height: 131px;">
        <div></div>
    </div>
    <div class="container" style="background: rgba(8,6,6,0);width: 100%;max-width: 1100px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);">
        <form method="get" class="d-flex justify-content-center mb-3" style="gap: 10px; flex-wrap: wrap;">
            <select name="search_type" class="form-select" style="max-width: 180px;">
                <option value="mechanic" <?php echo $search_type === 'mechanic' ? 'selected' : ''; ?>>Mechanic</option>
                <option value="jobcard" <?php echo $search_type === 'jobcard' ? 'selected' : ''; ?>>Jobcard</option>
                <option value="plate" <?php echo $search_type === 'plate' ? 'selected' : ''; ?>>Plate</option>
            </select>
            <input type="search" name="search" class="form-control" style="max-width: 300px;" placeholder="Search value" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="service_log.php" class="btn btn-secondary">Clear</a>
        </form>
        <div class="table-responsive" style="background: var(--bs-table-border-color);margin-top: 0px;border-style: none;border-color: #d92323;border-bottom-style: none;box-shadow: 0px 0px 20px 5px var(--bs-gray-600);padding-top: 0px;">
            <table class="table" style="white-space: nowrap;">
                <thead>
                    <tr>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 98.8px;">DATE</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 136.3px;">PLATE NUMBER</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">JC NUMBER</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">CURRENT KM</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 172.9px;padding-right: 10px;margin-right: -8px;">NEXT SERVICE KM</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 135.8px;">MECHANIC</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($records->num_rows === 0): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">No records found.</td>
                    </tr>
                    <?php else: ?>
                        <?php while ($row = $records->fetch_assoc()): ?>
                    <tr>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($row['service_date']); ?></td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($row['number_plate']); ?></td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($row['jobcard_number']); ?></td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($row['service_kilometers']); ?></td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($row['next_due_kilometers']); ?></td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($row['mechanic_name'] ?? ''); ?></td>
                    </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>