<?php 
    require '../include/connector/dbconn.php';
    require '../include/admininclude/adminSession.php';
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
        <title>Admin | HOME</title>
        <link rel="icon" type="image/x-icon" href="../assets/img/<?= $logo ?>" />
        <link href="../css/dataTable.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/jquery-ui.min.css">
        <script src="../js/all.js" crossorigin="anonymous"></script>
        <style>
        body{margin: 0;
            /* background-image: url("logo/home-bg.png"); */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial;
            }
        </style>
    </head>

    <body class="sb-nav-fixed">
    <?php include "../include/admininclude/adminTopNav.php";?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
            <?php include "../include/admininclude/adminSideNav.php";?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 text-muted">Admin Dashboard</h1>
                        
                        <ul class="nav nav-tabs" id="genderTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="female-tab" data-bs-toggle="tab" data-bs-target="#female"
                                    type="button" role="tab" aria-controls="female" aria-selected="true">Female</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="male-tab" data-bs-toggle="tab" data-bs-target="#male"
                                    type="button" role="tab" aria-controls="male" aria-selected="false">Male</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="both-mf-tab" data-bs-toggle="tab" data-bs-target="#both-mf"
                                    type="button" role="tab" aria-controls="both-mf" aria-selected="false">Both Male/Female</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="gay-tab" data-bs-toggle="tab" data-bs-target="#gay"
                                    type="button" role="tab" aria-controls="gay" aria-selected="false">Gay</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="lesbian-tab" data-bs-toggle="tab" data-bs-target="#lesbian"
                                    type="button" role="tab" aria-controls="lesbian" aria-selected="false">Lesbian</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="both-gl-tab" data-bs-toggle="tab" data-bs-target="#both-gl"
                                    type="button" role="tab" aria-controls="both-gl" aria-selected="false">Both Gay/Lesbian</button>
                            </li>
                        </ul>

                            <section class="mb-3">
                                            <div class="criteria justify-content-center mt-4 mb-5">
                                                <div class="event_summary"></div>
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

        // get judge score
        $(document).ready(function(){
            $(".event_judge_scores").click(function(){
                var event_judge_scores =  $(this).val();

                if(event_judge_scores !== null && event_judge_scores !== '') {
                $.ajax({
                    url: "adminJudgeAjax.php", 
                    type: 'POST',
                    data: {event_judge_scores: event_judge_scores},
                    success: function(result){
                        $(".event_summary").html(result);
                        // Reset tab to default ("Female")
                        const defaultTab = new bootstrap.Tab(document.querySelector('#female-tab'));
                        defaultTab.show();
                    }});

                }
            });
            
        });

        // get criteria
        $(document).ready(function(){
            $(".event_category").click(function(){
                var event_category = $(this).data('code');
                var event_judge = "<?=$fetch['code']?>";
                var conGeneral = "<?=$isGeneral?>";
                var conWeightedScoring = "<?=$weightedScoring?>";

                $.ajax({
                    url: "adminAjax.php", 
                    type: 'POST',
                    data: {event_category: event_category, 
                            event_judge: event_judge,
                            conGeneral: conGeneral,
                            conWeightedScoring: conWeightedScoring},
                    success: function(result){
                        $(".event_summary").html(result);
                        // Reset tab to default ("Female")
                        const defaultTab = new bootstrap.Tab(document.querySelector('#female-tab'));
                        defaultTab.show();
                    }});
            });
        });

        // get criteria Special Event
        $(document).ready(function(){
            $(".event_categorySpecial").click(function(){
                var event_categorySpecial = $(this).data('code');
                var event_judgeSpecial = "<?=$fetch['code']?>";
                var conGeneralSpecial = "<?=$isGeneral?>";
                var conWeightedScoringSpecial = "<?=$weightedScoring?>";

                $.ajax({
                    url: "adminSpecialAjax.php", 
                    type: 'POST',
                    data: {event_categorySpecial: event_categorySpecial, 
                            event_judgeSpecial: event_judgeSpecial,
                            conGeneralSpecial: conGeneralSpecial,
                            conWeightedScoringSpecial: conWeightedScoringSpecial},
                    success: function(result){
                        $(".event_summary").html(result);
                        // Reset tab to default ("Female")
                        const defaultTab = new bootstrap.Tab(document.querySelector('#female-tab'));
                        defaultTab.show();
                    }});
            });
        });

        // get final criteria
        $(document).ready(function(){
            $(".event_category_final").click(function(){
                var event_category_final = $(this).data('code');
                var event_judge_final = "<?=$fetch['code']?>";
                var conGeneralFinal = "<?=$isGeneral?>";
                var conWeightedScoringFinal = "<?=$weightedScoring?>";

                $.ajax({
                    url: "adminFinalAjax.php", 
                    type: 'POST',
                    data: {event_category_final: event_category_final, 
                            event_judge_final: event_judge_final,
                            conGeneralFinal: conGeneralFinal,
                            conWeightedScoringFinal: conWeightedScoringFinal},
                    success: function(result){
                        $(".event_summary").html(result); 
                        // Reset tab to default ("Female")
                        const defaultTab = new bootstrap.Tab(document.querySelector('#female-tab'));
                        defaultTab.show();
                    }});
            });
        });
        </script>

        
        <script>
            function printTables(tableIds, divClasses) {
                // Hide the buttons with the class 'updateGenCode'
                // var buttons = document.getElementsByClassName('updateGenCode');
                // for (var i = 0; i < buttons.length; i++) {
                //     buttons[i].style.display = 'none';
                // }

                // Create a new window for printing
                var printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write('<html><head><title>Print</title>');

                // Include external stylesheets (add your stylesheet paths)
                var stylesheets = document.querySelectorAll('link[rel="stylesheet"]');
                stylesheets.forEach(function(sheet) {
                    printWindow.document.write('<link rel="stylesheet" href="' + sheet.href + '">');
                });

                // Optionally, add any inline styles
                printWindow.document.write('<style>@page { size: letter landscape; }</style>'); // Landscape orientation
                printWindow.document.write('</head><body>');

                // Add all divs with the specified classes first
                for (var j = 0; j < divClasses.length; j++) {
                    var divElement = document.querySelector('.' + divClasses[j]);
                    if (divElement) {
                        printWindow.document.write(divElement.outerHTML);
                    }
                }

                // Add all tables by their IDs
                for (var i = 0; i < tableIds.length; i++) {
                    var table = document.getElementById(tableIds[i]);
                    if (table) {
                        printWindow.document.write(table.outerHTML);
                    }
                }

                // Close the HTML structure
                printWindow.document.write('</body></html>');
                printWindow.document.close(); // Close the document to finish loading

                // Add a small delay to ensure the content and styles are fully loaded
                printWindow.onload = function() {
                    printWindow.focus(); // Focus on the new window
                    printWindow.print(); // Print the contents of the new window
                    
                    // Restore the display of the buttons after printing
                    // for (var i = 0; i < buttons.length; i++) {
                    //     buttons[i].style.display = 'inline-block';
                    // }

                    setTimeout(() => {
                        printWindow.close();
                    }, 1000);
                };
            }

        </script>
    </body>
</html>
<?php include "../include/footerSwal.php";?>