<?php
         $select = mysqli_query($db, "SELECT * FROM user WHERE code = '$admin' ") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }

?>
<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav category-buttons">

                        <div class="sb-sidenav-menu-heading">Judge Summary Panel</div>
                            <a class="event_category nav-link" href="adminJudgeAjax.php">
                                Judge Scores
                            </a>

                        <div class="sb-sidenav-menu-heading">Preliminary Summary Panel</div>
                            <?php
                                $eventCategoryQuery = eventListPreliminary;
                                $resultEventCategory = mysqli_query($db, $eventCategoryQuery);

                                if ($resultEventCategory->num_rows > 0) {
                                    foreach ($resultEventCategory as $eventCategoryResult) {
                                        $eventCode = htmlspecialchars($eventCategoryResult['code']);
                                        $event_name = htmlspecialchars($eventCategoryResult['event_name']);
                                        ?>  
                                        <a class="event_category nav-link" href="adminHome.php#"
                                                data-code='<?= $eventCode?>'>
                                            <?= $event_name ?>
                                        </a>
                                        <?php
                                    }
                                }
                            ?>

                            <div class="sb-sidenav-menu-heading">Special Event Panel</div>
                            <?php
                                $eventCategorySpecialQuery = eventListSpecial;
                                $resultEventCategorySpecial = mysqli_query($db, $eventCategorySpecialQuery);

                                if ($resultEventCategorySpecial->num_rows > 0) {
                                    foreach ($resultEventCategorySpecial as $eventCategoryResultSpecial) {
                                        $eventCodeSpecial = htmlspecialchars($eventCategoryResultSpecial['code']);
                                        $event_nameSpecial = htmlspecialchars($eventCategoryResultSpecial['event_name']);
                                        ?>  
                                        <a class="event_categorySpecial nav-link" href="adminHome.php#"
                                                data-code='<?= $eventCodeSpecial?>'>
                                            <?= $event_nameSpecial ?>
                                        </a>
                                        <?php
                                    }
                                }
                            ?>
                            
                            <div class="sb-sidenav-menu-heading">Overall Summary Panel</div>
                            <a class="event_category nav-link" href="adminSummary.php">
                                Preliminary Summary
                            </a>


                            <div class="sb-sidenav-menu-heading">Finalist Panel</div>
                            <?php
                                $eventFinalQuery = eventListFinal;
                                $resultEventFinal = mysqli_query($db, $eventFinalQuery);

                                if ($resultEventFinal->num_rows > 0) {
                                    foreach ($resultEventFinal as $eventCategoryFinalResult) {
                                        $eventFinalCode = htmlspecialchars($eventCategoryFinalResult['code']);
                                        $event_name_final = htmlspecialchars($eventCategoryFinalResult['event_name']);
                                        ?>
                                        <a class="event_category_final nav-link" href="adminHome.php#"
                                                data-code='<?= $eventFinalCode?>'>
                                            <?= $event_name_final ?>
                                        </a>
                                        <?php
                                    }
                                }
                            ?>
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer py-3">
                        <div class="small">Logged in as :
                            <small class="fw-bold"><?php echo $fetch['name']; ?></small>
                        </div>
                    </div>
                </nav>
            </div>