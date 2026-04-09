<?php
require_once __DIR__ . '/config/conn.php';

$number_plate = '';
$model = 'faw';
$success_message = '';
$error_message = '';
$trucks = [];

if ($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $number_plate = strtoupper(trim($_POST['number_plate'] ?? ''));
        $model = trim($_POST['model'] ?? 'faw');

        if ($number_plate === '') {
            $error_message = 'Please enter a truck number plate.';
        } elseif (!preg_match('/^[A-Z]{3}\d{3,4}$/', $number_plate)) {
            $error_message = 'Number plate must be three letters followed by three or four digits.';
        } elseif (!in_array($model, ['faw', 'sino'], true)) {
            $error_message = 'Invalid truck model.';
        } else {
            $stmt = $conn->prepare('SELECT truck_id FROM trucks WHERE number_plate = ? LIMIT 1');
            if ($stmt) {
                $stmt->bind_param('s', $number_plate);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $error_message = 'A truck with this number plate already exists.';
                } else {
                    $insert = $conn->prepare('INSERT INTO trucks (number_plate, model) VALUES (?, ?)');
                    if ($insert) {
                        $insert->bind_param('ss', $number_plate, $model);
                        if ($insert->execute()) {
                            $success_message = 'Truck added successfully.';
                            $number_plate = '';
                            $model = 'faw';
                        } else {
                            $error_message = 'Unable to save truck: ' . $insert->error;
                        }
                        $insert->close();
                    } else {
                        $error_message = 'Unable to save truck: ' . $conn->error;
                    }
                }
                $stmt->close();
            } else {
                $error_message = 'Unable to validate truck plate: ' . $conn->error;
            }
        }
    }

    $result = $conn->query('SELECT truck_id, number_plate, model, created_at FROM trucks ORDER BY truck_id DESC');
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $trucks[] = $row;
        }
        $result->free();
    }
}
?>

<!DOCTYPE >
< lang="en" style="background: var(--bs-gray-400);">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
</head>

<body style="background: var(--bs-gray-400);text-align: center;height: 690.2px;">
    <nav class="navbar navbar-light navbar-expand-md py-3" style="background: var(--bs-gray-100);border-color: var(--bs-blue);border-bottom-width: 32px;border-bottom-color: var(--bs-danger);">
        <div class="container"><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-3" style="background: var(--bs-white);color: var(--bs-gray-700);">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="home.php" style="color: var(--bs-gray-700);font-weight: bold;">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="viewtrucks." style="color: var(--bs-gray-700);font-weight: bold;">SERVICE LOG</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="font-weight: bold;font-size: 16px;color: var(--bs-navbar-active-color);">MORE</a>
                        <div class="dropdown-menu"><a class="dropdown-item" href="addTruck.">Add Truck</a><a class="dropdown-item" href="profile.">Profile</a><a class="dropdown-item" href="#">Third Item</a></div>
                    </li>
                </ul><button class="btn btn-primary" type="button" style="background: #f05757;border-style: none;">Button</button>
            </div>
        </div>
    </nav>
    <div class="container" style="height: 71px;">
        <div></div>
    </div>
    <div class="container" style="background: rgba(8,6,6,0);width: 800px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);text-align: center;margin-top: 10px;margin-bottom: 51px;">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div>
                    <div class="card" style="margin-bottom: 0px;padding-bottom: 0px;">
                        <form method="post" action="addTruck.php" style="width: 708px;display: block;height: 100%;">
                            <h4 style="height: 53.2px;font-weight: bold;font-size: 37.7px;margin-top: 25px;margin-bottom: 25px;">ADD TRUCK</h4>
                            <div style="width: 708px;text-align: left;padding-left: 50px;margin-bottom: 10px;display: flex;"><label class="form-label d-md-flex align-items-md-center" style="padding-right: 0px;margin-right: 10px;height: 36px;padding-top: 5px;">Truck Number Plate</label><input class="form-control" type="text" name="number_plate" value="" style="margin-bottom: 13px;position: relative;display: inline;width: 300px;">
                                <div style="position: relative;display: flex;width: 180px;margin-left: 20px;">
                                </div>
                            </div>
                            <div style="text-align: left;padding-left: 50px;"><label class="form-label" style="padding-right: 0px;margin-right: 31px;">Model</label><select name="model" class="form-select" style="width: 300px;display: inline;position: relative;height: 40px;">
                                    <option value="faw" <?php echo $model === 'faw' ? 'selected' : ''; ?>>FAW</option>
                                    <option value="sino" <?php echo $model === 'sino' ? 'selected' : ''; ?>>SINO</option>
                                </select></div>
                            <div style="text-align: center;padding-top: 20px;">
                                <button type="submit" class="btn btn-success" style="background: #28a745; border: none; color: #fff;">Submit</button>
                            </div>
                            <div style="height: 51px;"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
        </div>
    </div>
    <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);">
        <div class="table-responsive" style="background: var(--bs-table-border-color);margin-top: 0px;border-style: none;border-color: #d92323;border-bottom-style: none;box-shadow: 0px 0px 20px 5px var(--bs-gray-600);padding-top: 0px;">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 136.3px;">TRUCK MODEL</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">NUMBER PLATE</th>
                        <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">DATE ADDED</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($trucks)): ?>
                        <?php foreach ($trucks as $truck): ?>
                            <tr>
                                <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars(strtoupper($truck['model'])); ?></td>
                                <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars($truck['number_plate']); ?></td>
                                <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;"><?php echo htmlspecialchars(date('Y-m-d', strtotime($truck['created_at']))); ?></td>
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