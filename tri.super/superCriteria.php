<?php 
    require '../include/connector/dbconn.php';
    require '../include/superinclude/superSession.php';
    
    include "../include/generatedKey.php"; 
    include "../include/query.php"; 
    include "../include/comparator.php";
    include "../include/settings.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Tabulation | HOME</title>
        <link rel="icon" type="image/x-icon" href="../assets/img/<?= $logo ?>"/>
        <link href="../css/dataTable.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/jquery-ui.min.css">
        <script src="../js/all.js" crossorigin="anonymous"></script>
        <style>
            body{margin: 0;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                font-family: Arial;
                }
        </style>
    </head>

    <body class="sb-nav-fixed">
    <?php include "../include/topNav.php";?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
            <?php include "../include/superinclude/superSidenav.php";?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                <div class="container-fluid px-4">
                        <h1 class="mt-4 text-muted">Dashboard</h1>
                        
                            <section class="mb-3">
                                <div class="card">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <i class="fas fa-tasks"></i>
                                                <span class="fw-bold" style="font-size: small;">ADD CRITERIA</span> 
                                            </div>
                                            <form action="superCode.php" method="POST">
                                                <div class="row mb-3">
                                                        <input type="hidden" name="criteriaGenerated" value="<?= generateKey(criteriaLast, 3)?>"/>
                                                        <input type="hidden" name="addedBy" value="<?=$super?>"/>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <select class="form-select p-3" type="select" name="eventCode" id="eventCode" required>
                                                                <option value="" selected disabled>~Select Event~</option>
                                                                    <?php
                                                                    $eventNameColumn = 'event_name';
                                                                    $eventCodeColumn = 'code';
                                                                    $eventDropdownOptions = generateEventDropdownOptions(allEventList, $db, $eventCodeColumn, $eventNameColumn);
                                                                    echo $eventDropdownOptions;
                                                                    ?>
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <input class="form-control" id="criteriaName" name="criteriaName" type="text" placeholder="" data-maxlength="45" maxlength="45" required/>
                                                                <label for="criteriaName">Name</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <select class="form-select p-3" id="criteriaType" name="criteriaType" required>
                                                                    <option value="" selected disabled>~Select Type~</option>
                                                                    <option value="PR">Preliminary Event</option>
                                                                    <option value="F">Final Event</option>
                                                                    <option value="SP">Special Event</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <input class="filter form-control" id="criteriaPercentage" name="criteriaPercentage" type="text" placeholder="" data-maxlength="4" maxlength="4" required/>
                                                                <label for="criteriaName">Score Percentage</label>
                                                            </div>
                                                        </div>
                                                </div>
                                                    <div><hr class="dropdown-divider"/></div>
                                                        <div class="mt-3 mb-0 d-flex bd-highlight">
                                                            <button class="btn btn-outline-success btn-block ms-auto btn-sm" type="submit" name="addCriteria" id="addCriteria" style="text-decoration:none; -bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Submit</button>
                                                        </div>
                                            </form>
                                        </div>
                                </div>
                            </section>

                            <section class="mb-3">
                                <div class="card">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <i class="fas fa-table"></i>
                                                <span class="fw-bold" style="font-size: small;">CRITERIA</span> 
                                            </div>

                                            <!-- ----DATA TABLE---- -->
                                            <div class="card-body table-responsive-sm">
                                                <table class="table table-hover" id="data">
                                                <?php  
                                                $sqlLogs = criteriaTblList;

                                                        $resultLogs = mysqli_query($db,$sqlLogs);
                                                        if(mysqli_num_rows($resultLogs) > 0){
                                                    ?>
                                                    <thead>
                                                        <tr>
                                                            <th>CODE</th>
                                                            <th>EVENT NAME</th>
                                                            <th>CRITERIA NAME</th>
                                                            <th>PERCENTAGE</th>
                                                            <th>TYPE</th>
                                                            <th>ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                        while($rowLogs = mysqli_fetch_assoc($resultLogs)){      
                                                    
                                                        // get criteria list
                                                        $eventCriteriaListQuery = eventObjList;
                                                        $stmt = $db->prepare($eventCriteriaListQuery);
                                                        $stmt->bind_param("s", $rowLogs['event_code']);
                                                        $stmt->execute();
                                                        $resultEventCriteriaList = $stmt->get_result();
                                                        $fetchResultCriteria = $resultEventCriteriaList->fetch_assoc();
                                                        ?>
                                                    <tr>
                                                        <td>
                                                            <?=$rowLogs['code']; ?>
                                                        </td>
                                                        
                                                        <td>
                                                            <?=$fetchResultCriteria['event_name']?>
                                                        </td>

                                                        <td>
                                                            <?=$rowLogs['criteria_name']; ?>
                                                        </td>

                                                        <td>
                                                            <?=$rowLogs['percent']; ?>
                                                        </td>

                                                        <td>
                                                            <?=$rowLogs['criteria_type'] == "PR" ? "Preliminary Event" : ($rowLogs['criteria_type'] == "SP" ? "Special Event" : "Final Event");?>
                                                        </td>

                                                        <td>
                                                            <button data-code='<?= $rowLogs['code']; ?>' class="updateCriteriaCode btn btn-outline-warning btn-sm rounded-circle"><i class="fa-solid fa-pen"></i></button>
                                                            
                                                            <button data-code='<?= $rowLogs['code']; ?>' class="criteriaDeleteCode btn btn-outline-danger btn-sm rounded-circle"><i class="fa-solid fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php      
                                                            } 
                                                        } else {
                                                            echo "<h3 class='text-danger text-center mt-3'>No Existing Data Found!</h3>";
                                                        }
                                                    ?>
                                                </table>
                                                
                                            </div>
                                    </div>
                                </div>
                            </section>

                    </div>
                </main>
                <?php include "../include/footer.php";?>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="ModalUpdateCriteria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Criteria</h5>
        </div>
            <div class="modal-body bg-light rounded">
                <div class="updateCriteria"></div>
            </div>
        </div>
        </div>
        </div>

                <!-- Delete View Modal -->
        <div class="modal fade" id="ModalDeleteViewCriteria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body bg-light rounded">
                <div class="deleteViewCriteria"></div>
            </div>
        </div>
        </div>
        </div>

        <script src="../js/jquery-3.6.1.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/sweetalert2.all.min.js"></script>
        <script src="../js/fontawesome.js" crossorigin="anonymous"></script>
        <script src="../js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="../js/simple-datatables@latest.js"></script>
        <script src="../js/tableDisplay.js"></script>
        <script src="../js/stringFilter.js"></script>


        <script>
            //update view criteria
            $(document).ready(function(){
            var updateCriteria = $('.updateCriteria');

            $(document).on('click', '.updateCriteriaCode', function(e){
                e.preventDefault();
                var updateCriteriaCode = $(this).data('code');
                var addedByCode = '<?=$super?>';
                $.ajax({
                    url: '../include/modal.php',
                    type: 'POST',
                    data: {updateCriteriaCode: updateCriteriaCode, 
                        addedByCode: addedByCode},
                    success: function(response){
                        updateCriteria.html(response);
                        $('#ModalUpdateCriteria').modal('show');
                    },
                    error: function(xhr, status, error){
                        console.error('AJAX error:', error);
                    }
                });
            });
        });

            // Delete Criteria
            $(document).ready(function(){
            var deleteViewCriteria = $('.deleteViewCriteria');

            $(document).on('click', '.criteriaDeleteCode', function(e){
                e.preventDefault();
                var criteriaDeleteCode = $(this).data('code');
                $.ajax({
                    url: '../include/modal.php',
                    type: 'POST',
                    data: {criteriaDeleteCode: criteriaDeleteCode},
                    success: function(response){
                        deleteViewCriteria.html(response);
                        $('#ModalDeleteViewCriteria').modal('show');
                    },
                    error: function(xhr, status, error){
                        console.error('AJAX error:', error);
                    }
                });
            });
        });


        </script>
</body>
</html>
<?php include "../include/footerSwal.php";?>