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
     <?php include 'nav.php'; ?>

    <section style="padding-bottom: 100px;">
        <div class="container">
            <div class="row mb-5" style="height: 130px;">
                <div class="col d-lg-flex justify-content-lg-center align-items-lg-center" style="margin-top: 100px;">
                    <h1 style="text-align: center;">User Details</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-lg-5 col-xl-4" style="border-right-style: solid;border-right-color: var(--bs-dark);border-left-style: solid;border-left-color: var(--bs-dark);">
                    <div>
                        <form class="p-3 p-xl-4" method="post">
                            <div class="mb-3">
                                <p>User Name:<span>Text</span></p>
                                <p>User Password:<span>Text</span></p>
                            </div>
                            <div class="mb-3"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-4 py-xl-5" style="background: var(--bs-gray-400);">
        <div class="container">
            <div class="row mb-5" style="height: 130px;"></div>
            <h1 style="text-align: center;">Modify Details</h1>
            <div class="row d-flex justify-content-center" style="margin-top: 100px;padding-bottom: 200px;">
                <div class="col-md-6 col-lg-5 col-xl-4" style="border-right-style: solid;border-right-color: var(--bs-dark);border-left-style: solid;border-left-color: var(--bs-dark);">
                    <div>
                        <form class="p-3 p-xl-4" method="post">
                            <div class="mb-3"><input class="form-control" type="text" id="name-1" name="name" placeholder="Name"></div>
                            <div class="mb-3"><input class="form-control" type="email" id="email-1" name="password" placeholder="Password"></div>
                            <div class="mb-3"></div>
                            <div><button class="btn btn-primary d-block w-100" type="submit" style="background: var(--bs-green);border-left-style: none;">SAVE CHANGES</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>