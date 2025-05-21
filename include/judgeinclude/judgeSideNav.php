<?php
         $select = mysqli_query($db, "SELECT * FROM user WHERE code = '$judge' ") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
        $categoryOfJudge = $fetch['category'];

?>
<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav category-buttons">
                            <div class="sb-sidenav-menu-heading">Preliminary Event Panel</div>

                            <?php
                                $eventCategoryQuery = eventListPreliminary;
                                $resultEventCategory = mysqli_query($db, $eventCategoryQuery);

                                if ($resultEventCategory->num_rows > 0) {
                                    echo '<select class="event_category form-control">';
                                    echo '<option value="" selected>Select Event</option>';
                                    foreach ($resultEventCategory as $eventCategoryResult) {
                                        $eventCode = htmlspecialchars($eventCategoryResult['code']);
                                        $event_name = htmlspecialchars($eventCategoryResult['event_name']);
                                        echo '<option value="' . $eventCode . '">' . $event_name . '</option>';
                                    }
                                    echo '</select>';
                                }
                            ?>

                           
                            <?php
                                $eventCategoryQuery = eventListSpecial;
                                $resultEventCategory = mysqli_query($db, $eventCategoryQuery);

                                if ($resultEventCategory && mysqli_num_rows($resultEventCategory) > 0) {
                                    echo '<div class="sb-sidenav-menu-heading">Special Event Panel</div>';
                                    echo '<select class="event_categorySpecial form-control">';
                                    echo '<option value="" selected>Select Special Event</option>';
                                    
                                    while ($eventCategoryResult = mysqli_fetch_assoc($resultEventCategory)) {
                                        $eventCode = htmlspecialchars($eventCategoryResult['code']);
                                        $eventName = htmlspecialchars($eventCategoryResult['event_name']);
                                        echo '<option value="' . $eventCode . '">' . $eventName . '</option>';
                                    }
                                    
                                    echo '</select>';
                                } else {
                                    
                                }
                            ?>


                            <div class="sb-sidenav-menu-heading">Finalist Event Panel</div>
                            <?php
                                $eventFinalQuery = eventListFinal;
                                $resultEventFinal = mysqli_query($db, $eventFinalQuery);

                                if ($resultEventFinal->num_rows > 0) {
                                    echo '<select class="event_category_final form-control">';
                                    echo '<option value="" selected>Select Final Event</option>';
                                    foreach ($resultEventFinal as $eventCategoryFinalResult) {
                                        $eventFinalCode = htmlspecialchars($eventCategoryFinalResult['code']);
                                        $event_name_final = htmlspecialchars($eventCategoryFinalResult['event_name']);
                                        echo '<option value="' . $eventFinalCode . '">' . $event_name_final . '</option>';
                                    }
                                    echo '</select>';
                                }
                            ?>


                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer py-3 ">
                        <div class="small">Welcome :
                            <small class="fw-bold"><?= $fetch['name']; ?></small>
                        </div>
                    </div>
                </nav>
            </div>