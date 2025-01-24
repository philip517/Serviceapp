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
    <div class="container" style="height: 131px;">
        <div></div>
    </div>
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
                    <tr>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 1</td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 1</td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 1</td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 2</td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 2</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 3</td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 3</td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 3</td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 4</td>
                        <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 4</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>