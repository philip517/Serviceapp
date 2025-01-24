<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
</head>

<body>
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
    <section class="py-4 py-xl-5">
        <div class="container" style="border-radius: 3px;">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>ADD NEW USER</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center" style="border-radius: 29px;">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center" style="border-top-style: solid;border-top-color: var(--bs-black);border-right-style: solid;border-right-color: var(--bs-black);border-bottom: 2.4px solid var(--bs-gray-900);border-left-style: solid;border-left-color: var(--bs-black);">
                            <header></header>
                            <form class="text-center" method="post">
                                <div class="mb-3"><input class="form-control" type="text" name="name" placeholder="User Name"></div>
                                <div class="mb-3"><select class="form-select">
                                        <option value="admin" selected="">Admin</option>
                                        <option value="user">User</option>
                                    </select></div>
                                <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password"></div>
                                <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Add User</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>