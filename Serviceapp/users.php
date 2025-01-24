<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PHILIP</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/material-icons.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
</head>

<body style="height: 900px;background: var(--bs-gray-900);display: block;">
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
    <section style="width: 100%;background: var(--bs-gray-400);display: block;height: 800px;padding-top: 50px;">
        <div class="modal fade text-start" role="dialog" tabindex="-1" id="modal-1" style="padding-top: 167px;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete User ?</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>User Name</p>
                    </div>
                    <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="button">Yes</button></div>
                </div>
            </div>
        </div>
        <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);text-align: center;margin-top: 100px;">
            <div class="row">
                <div class="col"></div>
                <div class="col">
                    <form style="display: flex;"><input class="form-control" type="search" style="width: 276.9px;border-radius: 0px;" placeholder="User Name"><input class="btn btn-primary" type="submit" data-bss-hover-animate="pulse" style="border-radius: 0px;background: var(--bs-black);border-style: none;" value="Search"></form>
                </div>
                <div class="col"></div>
            </div>
        </div>
        <div style="padding-top: 40px;">
            <h1 class="text-center d-lg-flex justify-content-lg-center align-items-lg-start" style="text-align: center;margin-left: 20px;margin-bottom: 50px;"><span class="text-center">Users</span></h1>
            <div class="container" style="background: rgba(8,6,6,0);width: 732px;padding-bottom: 18px;border-style: none;box-shadow: 0px 0px var(--bs-indigo);text-align: center;">
                <div class="table-responsive" style="background: var(--bs-table-border-color);margin-top: 0px;border-style: none;border-color: #d92323;border-bottom-style: none;box-shadow: 0px 0px 20px 5px var(--bs-gray-600);padding-top: 0px;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 136.3px;">USERID</th>
                                <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">USER NAME</th>
                                <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;">ROLE</th>
                                <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 50px;"></th>
                                <th style="text-align: center;background: var(--bs-black);color: #d7d7d7;width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 1</td>
                                <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 1</td>
                                <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;">Cell 1</td>
                                <td class="d-lg-flex justify-content-lg-center align-items-lg-end" style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;width: 50px;"><button class="btn btn-primary" type="button" style="background: var(--bs-teal);height: 40px;border-style: none;border-color: rgb(255, 255, 255);border-top-color: rgb(255,;border-right-color: 255,;border-bottom-style: none;border-bottom-color: 255);border-left-color: 255,;"><i class="far fa-edit" style="font-size: 23px;"></i></button></td>
                                <td style="text-align: center;color: var(--bs-black);background: var(--bs-table-border-color);border-style: none;width: 50px;"><button class="btn btn-primary" type="button" style="height: 40px;background: #fc5e72;border-style: none;border-bottom-style: solid;border-bottom-color: var(--bs-btn-disabled-color);" data-bs-target="#modal-1" data-bs-toggle="modal"><i class="material-icons">delete</i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>