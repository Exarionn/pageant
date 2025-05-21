<?php 
    require '../include/connector/dbconn.php';
    require '../include/judgeinclude/judgeSession.php';
    
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
        <title>Pageant | HOME</title>
        <link rel="icon" type="image/x-icon" href="../assets/img/<?= $logo ?>" />
        <link href="../css/dataTable.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/jquery-ui.min.css">
        <script src="../js/all.js" crossorigin="anonymous"></script>
        <style>
            body{margin: 0;
                /* background-image: url("assets/img/home-bg.png"); */
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
            <?php include "../include/judgeinclude/judgeSideNav.php";?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                <div class="container-fluid px-4">
                        <h1 class="mt-4 text-muted">Judge Dashboard</h1>
                        
                            <section class="mb-3">
                                <div class="card">
                                        <div class="card-body">
                                            <div class="criteria justify-content-center mt-4 mb-5">
                                                <div class="event_criteria"></div>
                                                
                                            </div>
                                                    
                                        </div>
                                </div>
                            </section>
                    </div>
                </main>
                <?php include "../include/footer.php";?>
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

            // get criteria
            let lastSelectedEventCategory;

            $(document).on('change', '.event_category', function() {
                var event_category = $(this).val();

                // Only proceed if the selected value is different
                if (event_category !== lastSelectedEventCategory) {
                    lastSelectedEventCategory = event_category; // Update last selected value

                    var event_judge = "<?=$fetch['code']?>";
                    var category_judge = "<?=$categoryOfJudge?>";
                    var conGeneral = "<?=$isGeneral?>";

                    // Show loading indication
                    $(".event_criteria").html('<p>Loading...</p>');

                    $.ajax({
                        url: "judgeAjax.php", 
                        type: 'POST',
                        data: {
                            event_category: event_category, 
                            event_judge: event_judge, 
                            category_judge: category_judge,
                            conGeneral: conGeneral,
                        },
                        success: function(result) {
                            $(".event_criteria").html(result);
                        },
                        error: function(xhr, status, error) {
                            $(".event_criteria").html('<p>Error loading criteria.</p>'); // Display error message
                            console.error('AJAX Error:', status, error);
                        }
                    });
                }
            });

            // get criteria
            let lastSelectedEventCategorySpecial;

            $(document).on('change', '.event_categorySpecial', function() {
                var event_category = $(this).val();

                // Only proceed if the selected value is different
                if (event_category !== lastSelectedEventCategorySpecial) {
                    lastSelectedEventCategorySpecial = event_category; // Update last selected value

                    var event_judge = "<?=$fetch['code']?>";
                    var category_judge = "<?=$categoryOfJudge?>";
                    var conGeneral = "<?=$isGeneral?>";

                    // Show loading indication
                    $(".event_criteria").html('<p>Loading...</p>');

                    $.ajax({
                        url: "judgeSpecialAjax.php", 
                        type: 'POST',
                        data: {
                            event_category: event_category, 
                            event_judge: event_judge, 
                            category_judge: category_judge,
                            conGeneral: conGeneral,
                        },
                        success: function(result) {
                            $(".event_criteria").html(result);
                        },
                        error: function(xhr, status, error) {
                            $(".event_criteria").html('<p>Error loading criteria.</p>'); // Display error message
                            console.error('AJAX Error:', status, error);
                        }
                    });
                }
            });




            // get final criteria
            let lastSelectedEventCategoryFinal;

            $(document).on('change', '.event_category_final', function() {
                var event_category_final = $(this).val();

                // Only proceed if the selected value is different
                if (event_category_final !== lastSelectedEventCategoryFinal) {
                    lastSelectedEventCategoryFinal = event_category_final;

                    var event_judge_final = "<?=$fetch['code']?>";
                    var category_judge_final = "<?=$categoryOfJudge?>";
                    var conGeneralFinal = "<?=$isGeneral?>";

                    // Show loading indication
                    $(".event_criteria").html('<p>Loading...</p>');

                    $.ajax({
                        url: "judgeFinalAjax.php", 
                        type: 'POST',
                        data: {
                            event_category_final: event_category_final, 
                            event_judge_final: event_judge_final,
                            category_judge_final: category_judge_final,
                            conGeneralFinal: conGeneralFinal
                        },
                        success: function(result) {
                            $(".event_criteria").html(result);
                        },
                        error: function(xhr, status, error) {
                            $(".event_criteria").html('<p>Error loading criteria.</p>'); // Display error message
                            console.error('AJAX Error:', status, error); // Log error for debugging
                        }
                    });
                }
            });


    </script>
</body>
</html>
<?php include "../include/footerSwal.php";?>