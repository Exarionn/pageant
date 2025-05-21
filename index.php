<?php
require './include/connector/dbconn.php';
include "./include/query.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pageant | Home</title> 
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/fontawesome.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./css/fontawesome.css">
    <link rel="stylesheet" href="./css/jquery-ui.min.css">
    <script src="./js/popper.min.js"></script>
    <script src="./js/sweetalert2.all.min.js"></script>
    <script src="./js/fontawesome.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="assets/img/logo.png" />
    <script src="./js/all.js"></script>
    <?php 
    include "include/logo.php";
    include "./include/settings.php";
    ?>
    <style>
	body{margin: 0;
		 background-image: url("assets/img/pageant-background.png");
		 background-size: cover;
         background-position: center;
         background-repeat: no-repeat;
         background-attachment: fixed;
         font-family: Arial;
         height: 100%;
         width: 100%;
		}

    .modal-content {
        border-radius: 10px;
    }
</style>
</head>



    <body class="bg-black" id="page-top ">
    
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a class="navbar-brand text-warning fs-6" href="index.php"><b> <?= $fetchSettings['pageant_name']?></b></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                	<span class="navbar-toggler-icon"></span></button>

                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="login nav-link" href="#">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Modal -->
        <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header align-items-center justify-content-center text-center">
                <img  src="./assets/img/logo.png" width="200" height="200">
                <h4 class="text-center font-weight-light fw-bold"><span class="text-warning">WELCOME</span></h4>
            </div>
            <div class="modal-body bg-light">
                <form action="./tri.login/loginCode.php" method="POST">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="username" name="username" type="text" placeholder="name@example.com" />
                        <label for="inputEmail">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="myInput" id="password" name="password" type="password" placeholder="Password" />
                        <label for="inputPassword">Password</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" onclick="myFunction()" id="showpassword" type="checkbox" value="" />
                        <label class="form-check-label" for="showpassword">Show Password</label>
                    </div>
                    
                    <div>
                        <button type="submit" class="btn btn-primary w-100" name="login" style="text-decoration:none; -bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>

        <!-- Footer-->

        <!-- Bootstrap core JS-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js">
        window.onscroll = function() {myFunction()};

            var navbar = document.getElementById("navbar");
            var sticky = navbar.offsetTop;

            function myFunction() {
                if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
                }  
                else {
                navbar.classList.remove("sticky");
            }
        }
        </script>
        <script>
            //view modal
            $(document).ready(function(){

                $('.login').click(function(e){
                    e.preventDefault();
                    $.ajax({
                        url: './tri.login/login.php',
                        type: 'POST',
                        success: function(response){
                            $('#modalLogin').modal('show');
                        }
                    });

                });

            });
        </script>

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

    <br><br>
    </body>
</html>
   <?php include('./include/footerSwal.php');?>