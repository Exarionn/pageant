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
                                                <span class="fw-bold" style="font-size: small;">ADD JUDGE</span> 
                                            </div>
                                            <form action="superCode.php" method="POST">
                                                <div class="row mb-3">
                                                        <input type="hidden" name="judgeGenerated" value="<?= generateKey(judgeLast, 6)?>"/>
                                                        <input type="hidden" name="addedBy" value="<?= $super?>"/>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <input class="form-control" id="judgeUserName" name="judgeUserName" type="text" placeholder="" data-maxlength="255" maxlength="255" required/>
                                                                <label for="label">User Name</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <input class="form-control" id="judgePassword" name="judgePassword" type="text" placeholder="" data-maxlength="255" maxlength="255" required/>
                                                                <label for="label">Password</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <input class="form-control" id="judgeName" name="judgeName" type="text" placeholder="" data-maxlength="255" maxlength="255" required/>
                                                                <label for="label">Name</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <select class="form-select p-3" id="judgeCategoryType" name="judgeCategoryType" required>
                                                                    <option value="" selected disabled>~Select Category~</option>
                                                                    <option value="FE">FE - Female</option>
                                                                    <option value="MA">MA - Male</option>  
                                                                    <option value="B">B - Both Female/Male</option>
                                                                    <option value="LGBTQ-LES">LGBTQ-LES - Lesbian</option>
                                                                    <option value="LGBTQ-GAY">LGBTQ-GAY - Gay</option>
                                                                    <option value="LGBTQ-B">LGBTQ-B - Lesbian/Gay (Both)</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        
                                                </div>
                                                    <div><hr class="dropdown-divider"/></div>
                                                        <div class="mt-3 mb-0 d-flex bd-highlight">
                                                            <button class="btn btn-outline-success btn-block ms-auto btn-sm" type="submit" name="addJudge" id="addJudge" style="text-decoration:none; -bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Submit</button>
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
                                                <span class="fw-bold" style="font-size: small;">JUDGE</span> 
                                            </div>

                                            <!-- ----DATA TABLE---- -->
                                            <div class="card-body table-responsive-sm">
                                                <table class="table table-hover" id="data">
                                                <?php  
                                                $sqlLogs = judgeAccountList;

                                                        $resultLogs = mysqli_query($db,$sqlLogs);
                                                        if(mysqli_num_rows($resultLogs) > 0){
                                                    ?>
                                                    <thead>
                                                        <tr>
                                                            <th>CODE</th>
                                                            <th>USERNAME</th>
                                                            <th>PASSWORD</th>
                                                            <th>NAME</th>
                                                            <th>CATEGORY</th>  
                                                            <!-- SCORING PRIVILEGE removed -->
                                                            <th>ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                        while($rowLogs = mysqli_fetch_assoc($resultLogs)){    
                                                        ?>
                                                    <tr>
                                                        <td>
                                                            <?=$rowLogs['code']; ?>
                                                        </td>

                                                        <td>
                                                            <?=$rowLogs['username']; ?>
                                                        </td>

                                                        <td>
                                                            <?=$rowLogs['password']; ?>
                                                        </td>
                                                        
                                                        <td>
                                                            <?=$rowLogs['name']?>
                                                        </td>

                                                        <td>
                                                            <?Php
                                                            $categoryCode = $rowLogs['category']; 
                                                            
                                                            switch ($categoryCode) {
                                                                case 'FE':
                                                                    echo 'Female';
                                                                    break;
                                                                case 'MA':
                                                                    echo 'Male';
                                                                    break;
                                                                case 'LGBTQ-GAY':
                                                                    echo 'Gay';
                                                                    break;
                                                                case 'LGBTQ-LES':
                                                                    echo 'Lesbian';
                                                                    break;
                                                                case 'B':
                                                                    echo 'Both Male & Female';
                                                                    break;
                                                                case 'LGBTQ-B':
                                                                    echo 'Both Gay & Lesbian';
                                                                    break;
                                                                default:
                                                                    echo 'Unknown'; // Default for other categories
                                                            }
                                                            ?>

                                                            
                                                        </td>

                                                        <!-- is_both display removed -->

                                                        <td>
                                                            <button data-code='<?= $rowLogs['code']; ?>' class="updateJudgeCode btn btn-outline-warning btn-sm rounded-circle"><i class="fa-solid fa-pen"></i></button>
                                                            
                                                            <button data-code='<?= $rowLogs['code']; ?>' class="deleteJudgeCode btn btn-outline-danger btn-sm rounded-circle"><i class="fa-solid fa-trash"></i></button>
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
        <div class="modal fade" id="ModalUpdateJudget" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Judge</h5>
        </div>
            <div class="modal-body bg-light rounded">
                <div class="updateJudge"></div>
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
            //update view contestant
            $(document).ready(function(){
            var updateJudge = $('.updateJudge');

            $(document).on('click', '.updateJudgeCode', function(e){
                e.preventDefault();
                var updateJudgeCode = $(this).data('code');
                var updateUpdatedBy = "<?= $super?>";
                $.ajax({
                    url: '../include/modal.php',
                    type: 'POST',
                    data: {updateJudgeCode: updateJudgeCode,
                        updateUpdatedBy: updateUpdatedBy},
                    success: function(response){
                        updateJudge.html(response);
                        $('#ModalUpdateJudget').modal('show');
                    },
                    error: function(xhr, status, error){
                        console.error('AJAX error:', error);
                    }
                });
            });
        });

        
            // Delete Contestant
            $(document).on('click', '.deleteJudgeCode', function(e){
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will Delete this Contestant. Continue?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Contestant Deleted',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.preventDefault();
                        var deleteJudgeCode = $(this).data('code');
                        $.ajax({
                            url: 'superCode.php',
                            type: 'POST',
                            data: {deleteJudgeCode: deleteJudgeCode},
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
                                                window.location.reload();
                                            }
                                        })
                                    },
                            error: function(xhr, status, error) {
                                console.error("Error:", error);
                            }
                        });
                    }
                });
            });


        </script>
</body>
</html>
<?php include "../include/footerSwal.php";?>