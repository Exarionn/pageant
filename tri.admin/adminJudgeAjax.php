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
        <title>Admin | Judge Score</title>
        <link rel="icon" type="image/x-icon" href="../assets/img/<?= $logo ?>" />
        <link href="../css/dataTable.css" rel="stylesheet" />
        <link href="../css/custom-table.css" rel="stylesheet" />
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
    <?php include "../include/topNav.php";?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
            <?php include "../include/admininclude/adminSideNav.php";?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 text-muted">Admin Dashboard</h1>
                        
                            <section class="mb-3">
                                <div class="criteria justify-content-center mt-4 mb-5">
                                    <?php

                                        echo '<form id="eventForm" method="get">'; // Removed action attribute
                                            echo '<div class="input-group mb-3">';
                                                echo '<div class="col-sm-2 ms-2 mt-1">';

                                                $categoryQuery = eventListAll;
                                                $resultCategory = mysqli_query($db, $categoryQuery);
                                                if ($resultCategory->num_rows > 0) {
                                                    $selectedCategory = isset($_GET['selected_evnts']) ? $_GET['selected_evnts'] : null;

                                                    echo '<select class="event_selected form-select form-select-sm" name="selected_evnts" required>'; 
                                                    echo '<option value="" selected disabled>Select Event</option>';
                                                    foreach ($resultCategory as $categoryResult) {
                                                        $eventCodes = htmlspecialchars($categoryResult['code']);
                                                        $event_names = htmlspecialchars($categoryResult['event_name']);
                                                        $eventSpecial = htmlspecialchars($categoryResult['event_type']);
                                                        echo '<option value="' . $eventCodes . '" ' . ($eventCodes == $selectedCategory ? "selected" : "") . '>' . $event_names . (($eventSpecial == "SP") ? " (Special Event)" : "") . '</option>';
                                                    }
                                                    echo '</select>';

                                                }

                                                echo '</div>';

                                                echo '<div class="col-sm-2 ms-2 mt-1">';

                                                $judgesQuery = judgeList;
                                                $resultJudges = mysqli_query($db, $judgesQuery);

                                                if ($resultJudges->num_rows > 0) {
                                                    $selected_judge = isset($_GET['selected_judge']) ? $_GET['selected_judge'] : null;
                                                    echo '<select class="event_judge_selected form-select form-select-sm" name="selected_judge" required>';
                                                    echo '<option value="" selected disabled>Select Judge</option>';
                                                    foreach ($resultJudges as $judgesResult) {
                                                        $judgeCode = htmlspecialchars($judgesResult['code']);
                                                        $judgeName = htmlspecialchars($judgesResult['name']);
                                                        echo '<option value="' . $judgeCode . '" '. ($judgeCode == $selected_judge ? "selected" : "") .' >' . $judgeName . '</option>';
                                                    }
                                                    echo '</select>';
                                                }

                                                echo '</div class>';
                                                
                                                echo '<div class="col-sm-1 ms-2 mt-1">';

                                                $isFinal = isset($_GET['isFinal']) ? $_GET['isFinal'] : null;
                                                echo '  <input class="form-check-input" type="checkbox" name="isFinal" id="isFinal" value = "1" '. ($isFinal == 1 ? "checked" : "") .'>
                                                        <label class="form-check-label" for="Finalist?">
                                                            Finalist
                                                        </label>
                                                        ';

                                                echo '</div>';

                                                echo '<div class="col-sm-3 ms-2 mt-1">
                                                        <button class="btn btn-sm btn-outline-success" type="submit" id="sort" name="sort">Search</button>
                                                    </div>';
                                            echo '</div>';
                                        echo '</form>'; 
    

                        if(isset($_GET['sort']) && isset($_GET['selected_evnts']) && isset($_GET['selected_judge'])) {

                        $selected_evnts = $_GET['selected_evnts'];
                        $selected_judge = $_GET['selected_judge'];
                        $isFinalistChecked = isset($_GET['isFinal']) ? $_GET['isFinal'] : null;
                        
                        // echo $selected_judge;

                        if ($selected_evnts && $selected_judge !== NULL) {
                                    // Initialize an array to hold contestant data
                                    
                                    $contestantsByCategoryFemale  = [];
                                    $contestantsByCategoryMale  = [];
                                    $contestantsByCategoryGay = [];
                                    $contestantsByCategoryLesbian = [];
                                    $contestantsByCategoryBothMF = [];
                                    $contestantsByCategoryBothLGBTQ = [];
                                    
                                    // Function to generate category table for judge scoring
                                    function generateJudgeCategoryTable($contestants, $categoryName, $categoryClass, $tableId, $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked) {
                                        if (empty($contestants)) return '';
                                        
                                        $output = '';
                                        
                                        if ($isGeneral == 1) {
                                            $output .= '<h6 class="'.$categoryClass.'-hd mt-5 text-muted" align="center">General Summary</h6>';
                                        } else {
                                            $output .= '<h6 class="'.$categoryClass.'-hd mt-5 text-muted" align="center">'.$categoryName.' Category Summary</h6>';
                                        }
                                        
                                        $eventTitle = ($fetchResultEvents['event_type'] == "SP") ? "Special Event" : "";
                                        $output .= '<h3 class="mt-2 text-danger selected" align="center">' . $eventTitle . '</h3>';
                                        
                                        $output .= '<div class="card-body table-responsive">
                                                        <table class="table table-hover table-bordered" id="'.$tableId.'">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th class="text-center"><div class="small">Candidate No.</div></th>';
                                        
                                        $totalPercent = 0;
                                        foreach ($resultEventCriteria as $eventCriteriaResult) {
                                            $criteriaHeader = $eventCriteriaResult['criteria_name'];
                                            $criteriaHeaderPercent = $eventCriteriaResult['percent'];
                                            $totalPercent += $criteriaHeaderPercent;
                                            $output .= '<th data-type="number" class="text-center"><div class="small">'.$criteriaHeader.' ('.$criteriaHeaderPercent.')</div></th>';
                                        }
                                        
                                        $output .= '<th data-type="number" class="text-center"><div class="small text-success">Total ('.$totalPercent.')</div></th>
                                                    <th class="text-center"><div class="small">Action</div></th>
                                                    </tr></thead><tbody>';
                                        
                                        foreach ($contestants as $eventContestantResult) {
                                            $contestantCode = htmlspecialchars($eventContestantResult['code']);
                                            $contestantIsFinal = htmlspecialchars($eventContestantResult['is_finalist']);
                                            $contestantSequence = htmlspecialchars($eventContestantResult['sequence']);
                                            $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                            $totalScore = NULL;
                                            
                                            // Filter contestants if the "Finalist?" checkbox is checked
                                            if ($isFinalistChecked === '1') {
                                                if ($contestantIsFinal != '1') {
                                                    continue;
                                                }
                                            }
                                            
                                            $output .= '<tr><td class="text-center"><div class="small">' . $contestantSequence;
                                            
                                            if ($contestantGender != null && $isGeneral == 0) {
                                                $output .= ' - ' . $contestantGender;
                                            }
                                            
                                            $output .= '</div></td>';
                                            
                                            foreach($resultEventCriteria as $eventCriteriaResult) {
                                                $criteriaCode = htmlspecialchars($eventCriteriaResult['code']);
                                                $eventScoreQuery = eventScoreList;
                                                $stmt = $db->prepare($eventScoreQuery);
                                                if (!$stmt) {
                                                    continue;
                                                }
                                                $stmt->bind_param("ssss", $selected_evnts, $contestantCode, $selected_judge, $criteriaCode);
                                                $stmt->execute();
                                                $resultEventScore = $stmt->get_result();
                                                if (!$resultEventScore) {
                                                    continue;
                                                }
                                                $fetchResultEventScore = $resultEventScore->fetch_assoc();
                                                if ($fetchResultEventScore !== null) {
                                                    $score = $fetchResultEventScore['score'];
                                                    $totalScore += $score;
                                                    $output .= '<td class="text-center"><div class="small">'.$score.'</div></td>';
                                                } else {
                                                    $output .= '<td class="text-center"><div class="small"></div></td>';
                                                }
                                            }
                                            
                                            $output .= '<td class="text-center"><div class="small">'.$totalScore.'</div></td>
                                                        <td class="text-center"><button data-code='.$contestantCode.' class="updateGenCode btn btn-warning btn-sm">Update</button></td></tr>';
                                        }
                                        
                                        $output .= '</tbody></table></div>';
                                        $output .= '<div class="" align="center">
                                                        <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\''.$tableId.'\'], [\'selected\', \''.$categoryClass.'-hd\'])">Print Summary</button>
                                                    </div>';
                                        
                                        return $output;
                                    }
                                    

                                    // Fetch female contestant by category list using parameterized query
                                    $eventContestantByCategoryFemaleQuery = contestantListFemale;
                                    $stmt = $db->prepare($eventContestantByCategoryFemaleQuery);
                                    // $stmt->bind_param("s", $judgeCategoryFemale);
                                    $stmt->execute();
                                    $resultEventContestantByFemale = $stmt->get_result();

                                    if ($resultEventContestantByFemale) {
                                        while ($row = $resultEventContestantByFemale->fetch_assoc()) {
                                            $contestantsByCategoryFemale[] = $row;
                                        }
                                    } else {
                                        // Handle database query error without revealing sensitive information
                                        echo "Error fetching contestant list";
                                        exit;
                                    }


                                    // Fetch male contestant by category list using parameterized query
                                    $eventContestantByCategoryMaleQuery = contestantListMale;
                                    $stmt = $db->prepare($eventContestantByCategoryMaleQuery);
                                    // $stmt->bind_param("s", $judgeCategoryMale);
                                    $stmt->execute();
                                    $resultEventContestantByMale = $stmt->get_result();

                                    if ($resultEventContestantByMale) {
                                        while ($row = $resultEventContestantByMale->fetch_assoc()) {
                                            $contestantsByCategoryMale[] = $row;
                                        }
                                    } else {
                                        // Handle database query error without revealing sensitive information
                                        echo "Error fetching contestant list";
                                        exit;
                                    }

                                    // Fetch Lbtq gay contestant by category list using parameterized query
                                    $eventContestantByCategoryGayQuery = contestantListGay;
                                    $stmt = $db->prepare($eventContestantByCategoryGayQuery);
                                    // $stmt->bind_param("s", $judgeCategoryMale);
                                    $stmt->execute();
                                    $resultEventContestantByGay = $stmt->get_result();

                                    if ($resultEventContestantByGay) {
                                        while ($row = $resultEventContestantByGay->fetch_assoc()) {
                                            $contestantsByCategoryGay[] = $row;
                                        }
                                    } else {
                                        // Handle database query error without revealing sensitive information
                                        echo "Error fetching contestant list";
                                        exit;
                                    }

                                    // Fetch Lbtq lesbian contestant by category list using parameterized query
                                    $eventContestantByCategoryLesbianQuery = contestantListLesbian;
                                    $stmt = $db->prepare($eventContestantByCategoryLesbianQuery);
                                    // $stmt->bind_param("s", $judgeCategoryMale);
                                    $stmt->execute();
                                    $resultEventContestantByLesbian = $stmt->get_result();

                                    if ($resultEventContestantByLesbian) {
                                        while ($row = $resultEventContestantByLesbian->fetch_assoc()) {
                                            $contestantsByCategoryLesbian[] = $row;
                                        }
                                    } else {
                                        // Handle database query error without revealing sensitive information
                                        echo "Error fetching contestant list";
                                        exit;
                                    }

                                    // Fetch Both Male and Female contestant by category list using parameterized query
                                    $eventContestantByCategoryBothMFQuery = contestantListBothMF;
                                    $stmt = $db->prepare($eventContestantByCategoryBothMFQuery);
                                    $stmt->execute();
                                    $resultEventContestantByBothMF = $stmt->get_result();

                                    if ($resultEventContestantByBothMF) {
                                        while ($row = $resultEventContestantByBothMF->fetch_assoc()) {
                                            $contestantsByCategoryBothMF[] = $row;
                                        }
                                    } else {
                                        // Handle database query error without revealing sensitive information
                                        echo "Error fetching contestant list";
                                        exit;
                                    }

                                    // Fetch Both LGBTQ contestant by category list using parameterized query
                                    $eventContestantByCategoryBothLGBTQQuery = contestantListBothLGBTQ;
                                    $stmt = $db->prepare($eventContestantByCategoryBothLGBTQQuery);
                                    $stmt->execute();
                                    $resultEventContestantByBothLGBTQ = $stmt->get_result();

                                    if ($resultEventContestantByBothLGBTQ) {
                                        while ($row = $resultEventContestantByBothLGBTQ->fetch_assoc()) {
                                            $contestantsByCategoryBothLGBTQ[] = $row;
                                        }
                                    } else {
                                        // Handle database query error without revealing sensitive information
                                        echo "Error fetching contestant list";
                                        exit;
                                    }

                                    $eventCriteriaQuery = criteriaList;
                                    $stmt = $db->prepare($eventCriteriaQuery);
                                    $stmt->bind_param("s", $selected_evnts);
                                    $stmt->execute();
                                    $resultEventCriteria = $stmt->get_result();

                                    if ($resultEventCriteria->num_rows <= 0) {
                                        echo "<h4 align='center'>No Data Found</h4>";
                                        exit;
                                    }

                                    $eventsQuery = eventListJudgeScore;
                                    $stmt = $db->prepare($eventsQuery);
                                    $stmt->bind_param("s", $selected_evnts);
                                    $stmt->execute();
                                    $resultEvents = $stmt->get_result();
                                    $fetchResultEvents = $resultEvents->fetch_assoc();

                                    $eventCountQuery = eventCount;
                                    $stmt = $db->prepare($eventCountQuery);
                                    $stmt->execute();
                                    $resultEventCount = $stmt->get_result();
                                    $fetchResultEventCount = $resultEventCount->fetch_assoc();

                                    // get judge list
                                    $eventJudgeQuery = judgeList;
                                    $stmt = $db->prepare($eventJudgeQuery);
                                    $stmt->execute();
                                    $resultEventJudgeList = $stmt->get_result();
                                    $fetchResultEventJudgeList = $resultEventJudgeList->fetch_assoc();

                                    $eventSelectedQuery = eventJudgeSelected;
                                    $stmt = $db->prepare($eventSelectedQuery);
                                    $stmt->bind_param("s", $selected_judge);
                                    $stmt->execute();
                                    $resultEvents = $stmt->get_result();
                                    $fetchResultEventSelected = $resultEvents->fetch_assoc();


                                    $judge = '';

                                        if($fetchResultEvents != NULL){
                                            $judge .= '<h3 class="mt-2 text-muted selected" align="center">'.$fetchResultEvents['event_name'].' - '.$fetchResultEventSelected['name'].'</h3>';
                                        } else {
                                            $judge .= '<h3 class="mt-2 text-muted" align="center"></h3>';
                                        }

                        // get category of judge list
                        $eventCategoryByjudgeQuery = judgeByCategoryList;
                        $stmt = $db->prepare($eventCategoryByjudgeQuery);
                        $stmt->bind_param("s", $selected_judge);
                        $stmt->execute();
                        $resultEventCategoryByjudge = $stmt->get_result();
                        $fetchResultEventCategoryByJudge = $resultEventCategoryByjudge->fetch_assoc();

                        // is_both removed; judge category alone determines view filters

                        // Add navigation tabs
                        $judge .= '<ul class="nav nav-tabs mt-4 justify-content-center" id="categoryTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All Categories</button>
                                        </li>';
                        
                        if (!empty($contestantsByCategoryFemale)) {
                            $judge .= '<li class="nav-item" role="presentation">
                                            <button class="nav-link" id="female-tab" data-bs-toggle="tab" data-bs-target="#female" type="button" role="tab">Female</button>
                                        </li>';
                        }
                        if (!empty($contestantsByCategoryMale)) {
                            $judge .= '<li class="nav-item" role="presentation">
                                            <button class="nav-link" id="male-tab" data-bs-toggle="tab" data-bs-target="#male" type="button" role="tab">Male</button>
                                        </li>';
                        }
                        if (!empty($contestantsByCategoryLesbian)) {
                            $judge .= '<li class="nav-item" role="presentation">
                                            <button class="nav-link" id="lesbian-tab" data-bs-toggle="tab" data-bs-target="#lesbian" type="button" role="tab">Lesbian</button>
                                        </li>';
                        }
                        if (!empty($contestantsByCategoryGay)) {
                            $judge .= '<li class="nav-item" role="presentation">
                                            <button class="nav-link" id="gay-tab" data-bs-toggle="tab" data-bs-target="#gay" type="button" role="tab">Gay</button>
                                        </li>';
                        }
                        if (!empty($contestantsByCategoryBothMF)) {
                            $judge .= '<li class="nav-item" role="presentation">
                                            <button class="nav-link" id="bothmf-tab" data-bs-toggle="tab" data-bs-target="#bothmf" type="button" role="tab">Both M/F</button>
                                        </li>';
                        }
                        if (!empty($contestantsByCategoryBothLGBTQ)) {
                            $judge .= '<li class="nav-item" role="presentation">
                                            <button class="nav-link" id="bothlgbtq-tab" data-bs-toggle="tab" data-bs-target="#bothlgbtq" type="button" role="tab">Both LGBTQ</button>
                                        </li>';
                        }
                        
                        $judge .= '</ul>';
                        
                        // Tab content
                        $judge .= '<div class="tab-content" id="categoryTabContent">
                                        <div class="tab-pane fade show active" id="all" role="tabpanel">';

                        // Generate all category tables for "All Categories" tab
                        $judge .= generateJudgeCategoryTable($contestantsByCategoryFemale, 'Female', 'fm', 'data1', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                        $judge .= generateJudgeCategoryTable($contestantsByCategoryMale, 'Male', 'm', 'data2', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                        $judge .= generateJudgeCategoryTable($contestantsByCategoryLesbian, 'Lesbian', 'ls', 'data4', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                        $judge .= generateJudgeCategoryTable($contestantsByCategoryGay, 'Gay', 'gy', 'data3', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                        $judge .= generateJudgeCategoryTable($contestantsByCategoryBothMF, 'Both Male and Female', 'bmf', 'data5', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                        $judge .= generateJudgeCategoryTable($contestantsByCategoryBothLGBTQ, 'Both LGBTQ', 'blgbtq', 'data6', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                        
                        $judge .= '</div>'; // Close "All Categories" tab
                        
                        // Individual category tabs
                        if (!empty($contestantsByCategoryFemale)) {
                            $judge .= '<div class="tab-pane fade" id="female" role="tabpanel">';
                            $judge .= generateJudgeCategoryTable($contestantsByCategoryFemale, 'Female', 'fm', 'data1-single', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                            $judge .= '</div>';
                        }
                        
                        if (!empty($contestantsByCategoryMale)) {
                            $judge .= '<div class="tab-pane fade" id="male" role="tabpanel">';
                            $judge .= generateJudgeCategoryTable($contestantsByCategoryMale, 'Male', 'm', 'data2-single', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                            $judge .= '</div>';
                        }
                        
                        if (!empty($contestantsByCategoryLesbian)) {
                            $judge .= '<div class="tab-pane fade" id="lesbian" role="tabpanel">';
                            $judge .= generateJudgeCategoryTable($contestantsByCategoryLesbian, 'Lesbian', 'ls', 'data4-single', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                            $judge .= '</div>';
                        }
                        
                        if (!empty($contestantsByCategoryGay)) {
                            $judge .= '<div class="tab-pane fade" id="gay" role="tabpanel">';
                            $judge .= generateJudgeCategoryTable($contestantsByCategoryGay, 'Gay', 'gy', 'data3-single', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                            $judge .= '</div>';
                        }
                        
                        if (!empty($contestantsByCategoryBothMF)) {
                            $judge .= '<div class="tab-pane fade" id="bothmf" role="tabpanel">';
                            $judge .= generateJudgeCategoryTable($contestantsByCategoryBothMF, 'Both Male and Female', 'bmf', 'data5-single', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                            $judge .= '</div>';
                        }
                        
                        if (!empty($contestantsByCategoryBothLGBTQ)) {
                            $judge .= '<div class="tab-pane fade" id="bothlgbtq" role="tabpanel">';
                            $judge .= generateJudgeCategoryTable($contestantsByCategoryBothLGBTQ, 'Both LGBTQ', 'blgbtq', 'data6-single', $resultEventCriteria, $selected_evnts, $selected_judge, $db, $fetchResultEvents, $isGeneral, $isFinalistChecked);
                            $judge .= '</div>';
                        }
                        
                        $judge .= '</div>'; // Close tab-content

                        } 
                        else {
                            echo "Please Select Condition!";
                        }

                                            echo $judge;

                        }
                                    ?>            
                                </div>
                            </section>
                            
                    </div>
                </main>
                <?php include "../include/footer.php";?>
            </div>
        </div>
    
        <!-- Modal -->
        <div class="modal fade" id="ModalUpdateJudgeScore" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Judge Score</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body bg-light rounded">
                <div class="updateJudgeScore"></div>
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
        function initAllDataTables(root=document) {
            if (!window.simpleDatatables) return;
            const ids = ['#data1','#data2','#data3','#data4','#data5','#data6','#data1-single','#data2-single','#data3-single','#data4-single','#data5-single','#data6-single'];
            ids.forEach(sel => {
                const el = root.querySelector(sel);
                if (el && !el._dtInited) {
                    try {
                        new simpleDatatables.DataTable(el, { perPage: 20, perPageSelect: [10,20,50,100] });
                        el._dtInited = true;
                    } catch(e) { /* ignore */ }
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function(){ initAllDataTables(document); });
        document.addEventListener('shown.bs.tab', function(){ initAllDataTables(document); });
        </script>

        <script>
        $(document).ready(function() {
            $('.judge').on('input', function() {
                var value = this.value;
                
                // Retrieve the percentage value
                var percentage = $(this).data('percent'); 
                console.log("Percentage attribute:", percentage);
                
                // Ensure that the entered value is within the allowed range
                value = value.replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1');
                if(parseFloat(value) < 1.00) {
                    value = '1.00'; // Set the minimum score to 1.00
                } else if(parseFloat(value) > percentage) {
                    value = percentage.toString(); // Set the value to the maximum allowed score
                }
                
                this.value = value;
            });
        });

        </script>

        <script>
            //general score update
             $(document).ready(function(){

                $('.updateGenCode').click(function(e){
                    e.preventDefault();
                    var updateGenCode = $(this).data('code');
                    var selectedEvent = "<?= $selected_evnts?>";
                    var selectedJudge = "<?= $selected_judge?>";

                    $.ajax({
                        url: '../include/modal.php',
                        type: 'POST',
                        data: {updateGenCode: updateGenCode,
                            selectedEvent: selectedEvent,
                            selectedJudge: selectedJudge
                        },
                        success: function(response){
                            $('.updateJudgeScore').html(response);
                            $('#ModalUpdateJudgeScore').modal('show');
                        }
                    });

                });

            });

            //female score update
            $(document).ready(function(){

                $('.updateFeCode').click(function(e){
                    e.preventDefault();
                    var updateFeCode = $(this).data('code');
                    var selectedEvent = "<?= $selected_evnts?>";
                    var selectedJudge = "<?= $selected_judge?>";

                    $.ajax({
                        url: '../include/modal.php',
                        type: 'POST',
                        data: {updateFeCode: updateFeCode,
                            selectedEvent: selectedEvent,
                            selectedJudge: selectedJudge
                        },
                        success: function(response){
                            $('.updateJudgeScore').html(response);
                            $('#ModalUpdateJudgeScore').modal('show');
                        }
                    });

                });

            });

            //male score update
            $(document).ready(function(){

                $('.updateMaCode').click(function(e){
                    e.preventDefault();
                    var updateMaCode = $(this).data('code');
                    var selectedEvent = "<?= $selected_evnts?>";
                    var selectedJudge = "<?= $selected_judge?>";

                    $.ajax({
                        url: '../include/modal.php',
                        type: 'POST',
                        data: {updateMaCode: updateMaCode,
                            selectedEvent: selectedEvent,
                            selectedJudge: selectedJudge
                        },
                        success: function(response){
                            $('.updateJudgeScore').html(response);
                            $('#ModalUpdateJudgeScore').modal('show');
                        }
                    });

                });

            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("sort").addEventListener("click", function() {
                    // Get the form data
                    const form = document.getElementById("eventForm");
                    const formData = new FormData(form);

                    // Send the form data using AJAX
                    fetch("adminJudgeAjax.php", {
                        method: "GET",
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        // Handle the response here if needed
                        console.log(data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        </script>

        <script>
            // if (window.location.search.includes('sort=')) {
            //     const url = new URL(window.location.href);
            //     const parametersToRemove = ['selected_evnts', 'selected_judge',  'isFinal', 'sort'];

            //     parametersToRemove.forEach(param => url.searchParams.delete(param));
            //     window.history.replaceState({}, document.title, url.href);
            // }
        </script>

        <script>
            function printTables(tableIds, divClasses) {
                // Hide the buttons with the class 'updateGenCode'
                var buttons = document.getElementsByClassName('updateGenCode');
                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].style.display = 'none';
                }

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
                    for (var i = 0; i < buttons.length; i++) {
                        buttons[i].style.display = 'inline-block';
                    }

                    // Optionally, close the new window after printing
                    printWindow.close();
                };
            }

        </script>
    </body>
</html>
<?php include "../include/footerSwal.php";?>