<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <?php
                // Determine brand link safely based on session roles
                $brandLink = '../tri.judge/judgeHome.php';
                if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                    $brandLink = '../tri.admin/adminHome.php';
                } elseif (isset($_SESSION['super']) && $_SESSION['super']) {
                    $brandLink = '../tri.super/superBackup.php';
                }
                $pageantName = isset($fetchSettings['pageant_name']) && $fetchSettings['pageant_name'] !== '' ? htmlspecialchars($fetchSettings['pageant_name']) : 'Pageant';
            ?>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-3 me-lg-0 ms-2 border border-secondary" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <a class="navbar-brand ms-2 mb-2" href="<?= $brandLink ?>"><b class="text-warning" style="font-size: small;"><?= $pageantName ?></b></a>
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