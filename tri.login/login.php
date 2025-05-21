<?php 
require '../include/connector/dbconn.php';
require '../include/sessionChecker.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Diwata sang Bago <?= $currentYear?></title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/jquery-ui.min.css">
        <script src="../js/popper.min.js"></script>
        <script src="../js/sweetalert2.all.min.js"></script>
        <script src="../js/fontawesome.js" crossorigin="anonymous"></script>
        <?php 
        include "../include/logo.php";
        include "../include/date.php";
        ?>
    </head>
    <style>
        /* body{
            margin: cover;
            background-image: url("logo/home-bg.png");
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            } */
        
    </style>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a class="navbar-brand text-warning fs-6" href="../index.php"><b>Diwata sang Bago <?= $currentYear?> </b></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span></button>

                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>    
                    </ul>
                </div>
            </div>
        </nav>
    <body class="bg-black">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5 mt-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h5 class="text-center font-weight-light fw-bold"><span class="text-warning">Diwata sang Bago <?= $currentYear?></span></h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="loginCode.php" method="POST">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="username" name="username" type="text" placeholder="name@example.com" />
                                                <label for="inputEmail">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="myInput" id="password" name="password" type="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-5">
                                                <input class="form-check-input" onclick="myFunction()" id="showpassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="showpassword">Show Password</label>
                                            </div>
                                            <div class="position-absolute bottom-0 end-0 p-3">
                                                <button type="submit" class="btn btn-outline-primary btn-sm" name="login" style="text-decoration:none; -bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                    Login
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="../js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script>
            function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            } 
        </script>
    </body>
</html>
<?php include '../include/footerSwal.php';?>
