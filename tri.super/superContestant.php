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
                                                <span class="fw-bold" style="font-size: small;">ADD CONTESTANT</span> 
                                            </div>
                                            <form action="superCode.php" method="POST">
                                                <div class="row mb-3">
                                                        <input type="hidden" name="contestantGenerated" value="<?= generateKey(contestantLast, 3)?>"/>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <input class="form-control" id="contestantName" name="contestantName" type="text" placeholder="" data-maxlength="255" maxlength="255" required/>
                                                                <label for="criteriaName">Name</label>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <input class="filter form-control" id="contestantSequence" name="contestantSequence" type="text" placeholder="" data-maxlength="4" maxlength="4" required/>
                                                                <label for="criteriaName">Candidate Number</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <select class="form-select p-3" id="contestantCategoryType" name="contestantCategoryType" required>
                                                                    <option value="" selected disabled>~Select Category~</option>
                                                                    <option value="FE">FE - Female</option>
                                                                    <option value="MA">MA - Male</option>
                                                                    <option value="LGBTQ-LES">LGBTQ-LES - Lesbian</option>
                                                                    <option value="LGBTQ-GAY">LGBTQ-GAY - Gay</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <select class="form-select p-3" id="contestantGender" name="contestantGender">
                                                                    <option value="" selected disabled>~Select Gender~</option>
                                                                    <option value="F">Female</option>
                                                                    <option value="M">Male</option>
                                                                    <option value="LGBTQ-F">LGBTQ-Female</option>
                                                                    <option value="LGBTQ-M">LGBTQ-Male</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3 mt-2">
                                                            <div class="form-floating">
                                                                <select class="form-select p-3" id="contestantIsBoth" name="contestantIsBoth">
                                                                    <option value="" selected disabled>~Select Category Privilege~</option>
                                                                    <option value="0">No Condition</option>
                                                                    <option value="1">Both Male/Female</option>
                                                                    <option value="2">Both LGBTQ-Gay/Lesbian</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                </div>
                                                    <div><hr class="dropdown-divider"/></div>
                                                        <div class="mt-3 mb-0 d-flex bd-highlight">
                                                            <button class="btn btn-outline-success btn-block ms-auto btn-sm" type="submit" name="addContestants" id="addContestants" style="text-decoration:none; -bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Submit</button>
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
                                                <span class="fw-bold" style="font-size: small;">CONTESTANT</span> 
                                            </div>

                                            <!-- ----DATA TABLE---- -->
                                            <div class="card-body table-responsive-sm">
                                                <table class="table table-hover" id="data">
                                                <?php  
                                                $sqlLogs = contestantTblList;

                                                        $resultLogs = mysqli_query($db,$sqlLogs);
                                                        if(mysqli_num_rows($resultLogs) > 0){
                                                    ?>
                                                    <thead>
                                                        <tr>
                                                            <th>CODE</th>
                                                            <th>CANDIDATE NO.</th>
                                                            <th>NAME</th>
                                                            <th>CATEGORY</th>
                                                            <th>GENDER</th>
                                                            <th>BOTH</th>
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
                                                            <?=$rowLogs['sequence']?>
                                                        </td>

                                                        <td>
                                                            <?=$rowLogs['name']; ?>
                                                        </td>

                                                        <td>
                                                            <?php
                                                            $categoryCode = $rowLogs['category_code'];

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
                                                                default:
                                                                    echo 'Unknown'; // Default for other categories
                                                            }
                                                            ?>
                                                        </td>

                                                        <td>
                                                            <?php
                                                            $genderCode = $rowLogs['gender'];

                                                            switch ($genderCode) {
                                                                case 'F':
                                                                    echo 'Female';
                                                                    break;
                                                                case 'M':
                                                                    echo 'Male';
                                                                    break;
                                                                case 'LGBTQ-B':
                                                                    echo 'Gay';
                                                                    break;
                                                                case 'LGBTQ-F':
                                                                    echo 'Lesbian';
                                                                    break;
                                                                default:
                                                                    echo 'Unknown'; // Default for other categories
                                                            }
                                                            ?>
                                                        </td>

                                                        <td>

                                                            <?php
                                                            if($rowLogs['is_both'] == 1) {
                                                                echo "Both Male/Female";
                                                            }
                                                            else if ($rowLogs['is_both'] == 2){
                                                                echo "Both Gay/Lesbian";
                                                            }
                                                            else{
                                                                echo "No Condition";
                                                            }
                                                            ?>
                                                        </td>

                                                        <td>
                                                            <button data-code='<?= $rowLogs['code']; ?>' class="updateContestantCode btn btn-outline-warning btn-sm rounded-circle"><i class="fa-solid fa-pen"></i></button>
                                                            
                                                            <button data-code='<?= $rowLogs['code']; ?>' class="deleteContestCode btn btn-outline-danger btn-sm rounded-circle"><i class="fa-solid fa-trash"></i></button>
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
        <div class="modal fade" id="ModalUpdateContestant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Contestant</h5>
        </div>
            <div class="modal-body bg-light rounded">
                <div class="updateContestant"></div>
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
            var updateContestant = $('.updateContestant');

            $(document).on('click', '.updateContestantCode', function(e){
                e.preventDefault();
                var updateContestantCode = $(this).data('code');
                $.ajax({
                    url: '../include/modal.php',
                    type: 'POST',
                    data: {updateContestantCode: updateContestantCode},
                    success: function(response){
                        updateContestant.html(response);
                        $('#ModalUpdateContestant').modal('show');
                    },
                    error: function(xhr, status, error){
                        console.error('AJAX error:', error);
                    }
                });
            });
        });

        
            // Delete Contestant
            $(document).on('click', '.deleteContestCode', function(e){
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
                        var deleteContestCode = $(this).data('code');
                        $.ajax({
                            url: 'superCode.php',
                            type: 'POST',
                            data: {deleteContestCode: deleteContestCode},
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