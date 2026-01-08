<?php
         $select = mysqli_query($db, "SELECT * FROM user WHERE code = '$super' ") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }

?>
<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav category-buttons">
                        <div class="sb-sidenav-menu-heading">Manage System Panel</div>
                            <a class="event_category nav-link" href="superBackup.php">
                                Configure Pageant
                            </a>

                            <a class="event_category nav-link" href="superEvent.php">
                                Manage Events
                            </a>

                            <a class="event_category nav-link" href="superCriteria.php">
                                Manage Criterias
                            </a>

                            <a class="event_category nav-link" href="superContestant.php">
                                Manage Contestants
                            </a>

                            <a class="event_category nav-link" href="superjudge.php">
                                Manage Judges
                            </a>

                            <div class="sb-sidenav-menu-heading">User Manager</div>
                            <a class="event_category nav-link" href="superUser.php">
                                Manage User
                            </a>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer py-3">
                        <div class="small text-center mb-2">Logged in as:
                            <div class="fw-bold"><?php echo $fetch['name']; ?></div>
                        </div>
                        <a href="../tri.login/logout.php" class="btn btn-danger btn-sm w-100">
                            <i class="fa-solid fa-right-from-bracket"></i> LOG OUT
                        </a>
                    </div>
                </nav>
            </div>