<?php 
    require '../include/connector/dbconn.php';
    require '../include/superinclude/superSession.php';
    
    include "../include/generatedKey.php"; 
    include "../include/query.php"; 
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
        <link rel="icon" type="image/x-icon" href="../assets/img/<?= $logo ?>" />
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
                            <fieldset>
                                <div class="card">
                                    <div class="card-body">
                                        <ul>
                                            <li><strong>Backup Database:</strong> Click this button to create a backup of the database.</li>
                                            <li><strong>Clear Score:</strong> Click this button to clear the current score.</li>
                                        </ul>

                                        <div class="" align="center">
                                            <button class="btn btn-outline-success btn-sm me-5" onclick="backupButton()">Backup Database</button>
                                            <button class="btn btn-outline-warning btn-sm ms-5 active" onclick="clearScoreButton()">Clear Score</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </section>

                            <section class="mb-3">
                                <div class="card">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <i class="fas fa-table"></i>
                                                <span class="fw-bold" style="font-size: small;">PAGEANT SETTINGS</span> 
                                            </div>

                                            <!-- ----DATA TABLE---- -->
                                            <div class="card-body table-responsive-sm">
                                                <table class="table table-hover" id="data">
                                                <?php  
                                                $sqlLogs = settingList;

                                                        $resultLogs = mysqli_query($db,$sqlLogs);
                                                        if(mysqli_num_rows($resultLogs) > 0){
                                                    ?>
                                                    <thead>
                                                        <tr>
                                                            <th>Program Name</th>
                                                            <th>Condition</th>
                                                            <th>Status</th>
                                                            <th>Weighted Scoring</th>
                                                            <th>Logo</th>
                                                            <th>Cover Photo</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                        while($rowLogs = mysqli_fetch_assoc($resultLogs)){      
                                                    
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?=$rowLogs['pageant_name']; ?>
                                                        </td>
                                                    
                                                        <td>
                                                            <?=$rowLogs['condition_final']; ?>
                                                        </td>

                                                        <td>
                                                        <?php
                                                        if ($rowLogs['isGeneral'] == 0) {
                                                            ?>
                                                            WITH CATEGORY
                                                            <?php
                                                        } else {
                                                            ?>
                                                            GENERAL
                                                            <?php
                                                        }
                                                        ?>
                                                        </td>

                                                        <td>
                                                        <?php
                                                        if ($rowLogs['weighted_scoring'] == 0) {
                                                            ?>
                                                            POINT SYSTEM
                                                            <?php
                                                        } else {
                                                            ?>
                                                            PERCENTAGE SYSTEM
                                                            <?php
                                                        }
                                                        ?>
                                                        </td>

                                                        <td>
                                                            <img src="../assets/img/<?=$rowLogs['logo']; ?>" style="width: 3.5rem; height: 3.5rem;" alt="Progam Logo">
                                                        </td>

                                                        <td>
                                                            <img src="../assets/img/<?=$rowLogs['cover_photo']; ?>" class="rounded" style="width: 5.5rem; height: 3.5rem;" alt="Progam Logo">
                                                        </td>

                                                        <td>
                                                            <button data-code='<?= $rowLogs['id']; ?>' class="updateSettingCode btn btn-outline-warning btn-sm rounded-circle"><i class="fa-solid fa-pen"></i></button>
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

        <div class="modal fade" id="ModalUpdateSettings" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Setting</h5>
        </div>
            <div class="modal-body bg-light rounded">
                <div class="updateSettings"></div>
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


        <script>
            // Backup js
            function backupButton() {
                $.ajax({
                        url: 'superCode.php',
                        method: 'POST',
                        data: { backupButton: 'backupButton' },
                        success: function(response) {

                            let timerInterval
                            Swal.fire({
                            title: response,
                            icon: 'info',
                            timer: 2000,
                            showConfirmButton: false,
                            timerProgressBar: true,
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                            })
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                        }
                    });
            }
            
            // Clear Score js
            function clearScoreButton() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will clear all scores. Continue?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, clear scores',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed, proceed with AJAX request
                        $.ajax({
                            url: 'superCode.php',
                            method: 'POST',
                            data: { clearScoreButton: 'clearScoreButton' },
                            success: function(response) {
                                let timerInterval
                                Swal.fire({
                                    title: response,
                                    icon: 'success',
                                    timer: 1800,
                                    showConfirmButton: false,
                                    timerProgressBar: true,
                                    willClose: () => {
                                        clearInterval(timerInterval)
                                    }
                                })
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", error);
                            }
                        });
                    }
                });
            }
        </script>
        <script>

            //update view setting
            $(document).ready(function(){
                        var updateSettings = $('.updateSettings');

                        $(document).on('click', '.updateSettingCode', function(e){
                            e.preventDefault();
                            var updateSettingCode = $(this).data('code');
                            $.ajax({
                                url: '../include/modal.php',
                                type: 'POST',
                                data: {updateSettingCode: updateSettingCode},
                                success: function(response){
                                    updateSettings.html(response);
                                    $('#ModalUpdateSettings').modal('show');
                                },
                                error: function(xhr, status, error){
                                    console.error('AJAX error:', error);
                                }
                            });
                        });
                    });

        </script>

        <script>
            $(document).ready(function() {
                $('.condition').on('input', function() {
                    var value = this.value;
                    value = value.replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1');
                    this.value = value;
                });
            });
        </script>
</body>
</html>
<?php include "../include/footerSwal.php";?>