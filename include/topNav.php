<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-3 me-lg-0 ms-2 border border-secondary" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <a class="navbar-brand ms-2 mb-2" href="../tri.judge/judgeHome.php"><b class="text-warning" style="font-size: small;"><?= $fetchSettings['pageant_name']?></b></a>
            <!-- Navbar-->
            <ul class="navbar-nav me-2 ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item fw-bolder" href="../tri.login/logout.php">
                                <i class="fa-solid fa-right-from-bracket"></i>    
                                LOG OUT
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
</nav>