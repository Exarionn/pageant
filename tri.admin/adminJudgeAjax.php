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

                                        echo '
                                        <br>
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
                                        
                                        ';
    

                        if(isset($_GET['sort']) && isset($_GET['selected_evnts']) && isset($_GET['selected_judge'])) {

                        $selected_evnts = $_GET['selected_evnts'];
                        $selected_judge = $_GET['selected_judge'];
                        $isFinalistChecked = isset($_GET['isFinal']) ? $_GET['isFinal'] : null;
                        
                        // echo $selected_judge;

                        if ($selected_evnts && $selected_judge !== NULL) {
                                    // Initialize an array to hold contestant data
                                    
                                    $contestantsByCategoryFemale  = [];
                                    $contestantsByCategoryMale  = [];
                                    $contestantsByCategoryMaleFemale = [];
                                    $contestantsByCategoryGay = [];
                                    $contestantsByCategoryLesbian = [];
                                    $contestantsByCategoryGayLesbian = [];
                                    

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

                                    // Fetch male/female contestant by category list using parameterized query
                                    $eventContestantByCategoryMaleFemaleQuery = contestantListFemaleMaleBoth;
                                    $stmt = $db->prepare($eventContestantByCategoryMaleFemaleQuery);
                                    $stmt->execute();
                                    $resultEventContestantByMaleFemale = $stmt->get_result();

                                    if ($resultEventContestantByMaleFemale) {
                                        while ($row = $resultEventContestantByMaleFemale->fetch_assoc()) {
                                            $contestantsByCategoryMaleFemale[] = $row;
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

                                    // Fetch Lbtq gay contestant by category list using parameterized query
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

                                    // Fetch gay/lesbian contestant by category list using parameterized query
                                    $eventContestantByCategoryGayLesbianQuery = contestantListLgbtqBoth;
                                    $stmt = $db->prepare($eventContestantByCategoryGayLesbianQuery);
                                    $stmt->execute();
                                    $resultEventContestantByGayLesbian = $stmt->get_result();

                                    if ($resultEventContestantByGayLesbian) {
                                        while ($row = $resultEventContestantByGayLesbian->fetch_assoc()) {
                                            $contestantsByCategoryGayLesbian[] = $row;
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

                        $judgeCategoryIsBoth = $fetchResultEventCategoryByJudge['is_both'];
                        // echo $judgeCategoryIsBoth;

                            $judge .='
                        <div class="tab-content border border-top-0 p-3" id="genderTabsContent">
                            <div class="tab-pane fade text-center show active" id="female" role="tabpanel" aria-labelledby="female-tab">
';
                    if (!empty($contestantsByCategoryFemale)){
//=============================================================== female table ==========================================================

                                    if ($isGeneral == 1) {  // Use double equal sign for comparison
                                        $judge .= '
                                            <h6 class="fm-hd mt-5 text-muted" align="center">General Summary</h6>
                                        ';

                                        $eventTitle = ($fetchResultEvents['event_type'] == "SP") ? "Special Event" : "";
                                        $judge .= '<h3 class="mt-2 text-danger selected" align="center">' . $eventTitle . '</h3>';
                                    } else {
                                        $judge .= '
                                            <h6 class="fm-hd mt-5 text-muted" align="center">Female Category Summary</h6>
                                        ';
                                        $eventTitle = ($fetchResultEvents['event_type'] == "SP") ? "Special Event" : "";
                                        $judge .= '<h3 class="mt-2 text-danger selected" align="center">' . $eventTitle . '</h3>';
                                    }

                                            $judge .= '
                                            
                                            <div class="card-body table-responsive-sm">
                                                <table class="table table-hover" id="data1">
                                                    <thead>
                                                        <tr>';

                                            $judge .= '
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">
                                                                    Candidate No.
                                                                </div>
                                                            </th>';
                                        $totalPercent = 0;
                                        foreach ($resultEventCriteria as $eventCriteriaResult) {
                                            $criteriaHeader = $eventCriteriaResult['criteria_name'];
                                            $criteriaHeaderPercent = $eventCriteriaResult['percent'];

                                            // Add the current percent to the total
                                            $totalPercent += $criteriaHeaderPercent;
                                            
                                            $judge .= ' 
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">'.$criteriaHeader.'('.$criteriaHeaderPercent.')</div>
                                                            </th>';
                                        }

                                            $judge .= '
                                                            <th>
                                                                <div class="small text-success ms-3 me-3" align="center">
                                                                    Total('. $totalPercent .')
                                                                </div>
                                                            </th>';

                                            $judge .= '
                                                        </tr>
                                                    </thead>
                                                    <tbody>';

                                                    foreach ($contestantsByCategoryFemale as $eventContestantResult) {
                                                        $contestantCode = htmlspecialchars($eventContestantResult['code']);
                                                        $contestantIsFinal = htmlspecialchars($eventContestantResult['is_finalist']);
                                                        $contestantSequence = htmlspecialchars($eventContestantResult['sequence']);
                                                        $contestantName = htmlspecialchars($eventContestantResult['name']);
                                                        $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                                        $totalScore = NULL; // Initialize total score for each contestant
                                                
                                                        // Filter contestants if the "Finalist?" checkbox is checked
                                                        if ($isFinalistChecked === '1') {
                                                            if ($contestantIsFinal != '1') {
                                                                // Skip non-finalists if checkbox is checked
                                                                continue;
                                                            }
                                                        }

                                                        $judge .= '
                                                            <tr>
                                                                <td>
                                                                    <div class="small text-center">
                                                                    '. $contestantSequence .' ';

                                                if ($contestantGender != null && $isGeneral == 0) {
                                                    // Add your content when $contestantGender is true
                                                    $judge .=  ' - '. $contestantGender .' ';
                                                }
                                                else{
                                                    $judge .= '';
                                                }
                                                                        
                                                    $judge .= '                
                                                                    </div>
                                                                </td>';
                                                    
                                                        foreach($resultEventCriteria as $eventCriteriaResult) {
                                                            $criteriaCode = htmlspecialchars($eventCriteriaResult['code']);
                                                            $selected_evnts = $_GET['selected_evnts'];
                                                            $selected_judge = $_GET['selected_judge'];
                                                            
                                                            $eventScoreQuery = eventScoreList;
                                                            $stmt = $db->prepare($eventScoreQuery);
                                                            if (!$stmt) {
                                                                // Error handling for failed prepared statement
                                                                $errorMessage = $db->error;
                                                                // Handle error, log it, or display a message to the user
                                                                // Example: die("Database error: " . $errorMessage);
                                                                continue; // Skip to the next iteration
                                                            }
                                                            $stmt->bind_param("ssss", $selected_evnts, $contestantCode, $selected_judge, $criteriaCode);
                                                            $stmt->execute();
                                                            $resultEventScore = $stmt->get_result();
                                                            if (!$resultEventScore) {
                                                                // Error handling for failed query execution
                                                                $errorMessage = $db->error;
                                                                // Handle error, log it, or display a message to the user
                                                                // Example: die("Database error: " . $errorMessage);
                                                                continue; // Skip to the next iteration
                                                            }
                                                            $fetchResultEventScore = $resultEventScore->fetch_assoc();
                                                            if ($fetchResultEventScore !== null) {
                                                                // Access $fetchResultEventScore['score'] here
                                                                $score = $fetchResultEventScore['score'];
                                                                $totalScore += $score; // Add individual score to total score
                                                                $judge .= '
                                                                    <td>
                                                                        <div class="small text-center">
                                                                            '.$score.'
                                                                        </div>
                                                                    </td>';
                                                            } else {
                                                                // Handle the case where $fetchResultEventScore is null
                                                                // For example, you could output a placeholder or handle it differently
                                                                $judge .= '
                                                                    <td>
                                                                        <div class="small text-center">
                                                                            
                                                                        </div>
                                                                    </td>';
                                                            }
                                                        }
                                                    
                                                        // Add total score cell
                                                        $judge .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    '.$totalScore.'
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button data-code='. $contestantCode .' class="updateGenCode btn btn-outline-warning btn-sm rounded">Update</button>
                                                            </td>';
                                                    }
                                                    
                                                    

                                            $judge .= '
                                                    </tbody>
                                                </table>
                                            </div>';

                                            $judge .= '
                                            <div class="" align="center">
                                                <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\'data1\'], [\'selected\', \'fm-hd\'])">Print Summary</button>
                                            </div>';
                                }
$judge .='
                            </div>
                            <div class="tab-pane fade text-center" id="male" role="tabpanel" aria-labelledby="male-tab">
';
                    if (!empty($contestantsByCategoryMale)){
//=============================================================== Male table ==========================================================

                                            if ($isGeneral == 1) {  // Use double equal sign for comparison
                                                $judge .= '
                                                    <h6 class="m-hd mt-5 text-muted" align="center">General Summary</h6>
                                                ';
                                                $eventTitle = ($fetchResultEvents['event_type'] == "SP") ? "Special Event" : "";
                                                $judge .= '<h3 class="mt-2 text-danger selected" align="center">' . $eventTitle . '</h3>';
                                            } else {
                                                $judge .= '
                                                    <h6 class="m-hd mt-5 text-muted" align="center">Male Category Summary</h6>
                                                ';
                                                $eventTitle = ($fetchResultEvents['event_type'] == "SP") ? "Special Event" : "";
                                                $judge .= '<h3 class="mt-2 text-danger selected" align="center">' . $eventTitle . '</h3>';
                                            }
                                            $judge .= '
                                            
                                            <div class="card-body table-responsive-sm">
                                                <table class="table table-hover" id="data2">
                                                    <thead>
                                                        <tr>';

                                            $judge .= '
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">
                                                                    Candidate No.
                                                                </div>
                                                            </th>';
                                        $totalPercent = 0;
                                        foreach ($resultEventCriteria as $eventCriteriaResult) {
                                            $criteriaHeader = $eventCriteriaResult['criteria_name'];
                                            $criteriaHeaderPercent = $eventCriteriaResult['percent'];

                                            $totalPercent += $criteriaHeaderPercent;

                                            $judge .= ' 
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">'.$criteriaHeader.'('.$criteriaHeaderPercent.')</div>
                                                            </th>';
                                        }

                                            $judge .= '
                                                            <th>
                                                                <div class="small text-success ms-3 me-3" align="center">
                                                                    Total('. $totalPercent .')
                                                                </div>
                                                            </th>';

                                            $judge .= '
                                                        </tr>
                                                    </thead>
                                                    <tbody>';

                                                    foreach ($contestantsByCategoryMale as $eventContestantResult) {
                                                        $contestantCode = htmlspecialchars($eventContestantResult['code']);            
                                                        $contestantIsFinal = htmlspecialchars($eventContestantResult['is_finalist']);
                                                        $contestantSequence = htmlspecialchars($eventContestantResult['sequence']);
                                                        $contestantName = htmlspecialchars($eventContestantResult['name']);
                                                        $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                                        $totalScore = NULL; // Initialize total score for each contestant
                                                    

                                                        // Filter contestants if the "Finalist?" checkbox is checked
                                                        if ($isFinalistChecked === '1') {
                                                            if ($contestantIsFinal != '1') {
                                                                // Skip non-finalists if checkbox is checked
                                                                continue;
                                                            }
                                                        }

                                                        $judge .= '
                                                            <tr>
                                                                <td>
                                                                    <div class="small text-center">
                                                                        '. $contestantSequence .' ';

                                                if ($contestantGender != null && $isGeneral == 0) {
                                                    // Add your content when $contestantGender is true
                                                    $judge .= ' - '. $contestantGender .' ';
                                                }
                                                else{
                                                    $judge .= '';
                                                }
                                                                        
                                                    $judge .= '                
                                                                    </div>
                                                                </td>';
                                                    
                                                        foreach($resultEventCriteria as $eventCriteriaResult) {
                                                            $criteriaCode = htmlspecialchars($eventCriteriaResult['code']);
                                                            $selected_evnts = $_GET['selected_evnts'];
                                                            $selected_judge = $_GET['selected_judge'];
                                                            $eventScoreQuery = eventScoreList;
                                                            $stmt = $db->prepare($eventScoreQuery);
                                                            if (!$stmt) {
                                                                // Error handling for failed prepared statement
                                                                $errorMessage = $db->error;
                                                                // Handle error, log it, or display a message to the user
                                                                // Example: die("Database error: " . $errorMessage);
                                                                continue; // Skip to the next iteration
                                                            }
                                                            $stmt->bind_param("ssss", $selected_evnts, $contestantCode, $selected_judge, $criteriaCode);
                                                            $stmt->execute();
                                                            $resultEventScore = $stmt->get_result();
                                                            if (!$resultEventScore) {
                                                                // Error handling for failed query execution
                                                                $errorMessage = $db->error;
                                                                // Handle error, log it, or display a message to the user
                                                                // Example: die("Database error: " . $errorMessage);
                                                                continue; // Skip to the next iteration
                                                            }
                                                            $fetchResultEventScore = $resultEventScore->fetch_assoc();
                                                            if ($fetchResultEventScore !== null) {
                                                                // Access $fetchResultEventScore['score'] here
                                                                $score = $fetchResultEventScore['score'];
                                                                $totalScore += $score; // Add individual score to total score
                                                                $judge .= '
                                                                    <td>
                                                                        <div class="small text-center">
                                                                            '.$score.'
                                                                        </div>
                                                                    </td>';
                                                            } else {
                                                                // Handle the case where $fetchResultEventScore is null
                                                                // For example, you could output a placeholder or handle it differently
                                                                $judge .= '
                                                                    <td>
                                                                        <div class="small text-center">
                                                                            
                                                                        </div>
                                                                    </td>';
                                                            }
                                                        }
                                                    
                                                        // Add total score cell
                                                        $judge .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    '.$totalScore.'
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button data-code='. $contestantCode .' class="updateGenCode btn btn-outline-warning btn-sm rounded">Update</button>
                                                            </td>';
                                                    }
                                                    
                                                    

                                            $judge .= '
                                                    </tbody>
                                                </table>
                                            </div>';

                                            $judge .= '
                                            <div class="" align="center">
                                                <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\'data2\'], [\'selected\', \'m-hd\'])">Print Summary</button>
                                            </div>';
                                    }
$judge .='
                            </div>
                            <div class="tab-pane fade text-center" id="both-mf" role="tabpanel" aria-labelledby="both-mf-tab">
';
                    if (!empty($contestantsByCategoryMaleFemale)){
//=============================================================== Male table ==========================================================

                                            if ($isGeneral == 1) {  // Use double equal sign for comparison
                                                $judge .= '
                                                    <h6 class="m-hd mt-5 text-muted" align="center">General Summary</h6>
                                                ';
                                                $eventTitle = ($fetchResultEvents['event_type'] == "SP") ? "Special Event" : "";
                                                $judge .= '<h3 class="mt-2 text-danger selected" align="center">' . $eventTitle . '</h3>';
                                            } else {
                                                $judge .= '
                                                    <h6 class="m-hd mt-5 text-muted" align="center">Male Category Summary</h6>
                                                ';
                                                $eventTitle = ($fetchResultEvents['event_type'] == "SP") ? "Special Event" : "";
                                                $judge .= '<h3 class="mt-2 text-danger selected" align="center">' . $eventTitle . '</h3>';
                                            }
                                            $judge .= '
                                            
                                            <div class="card-body table-responsive-sm">
                                                <table class="table table-hover" id="data2">
                                                    <thead>
                                                        <tr>';

                                            $judge .= '
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">
                                                                    Candidate No.
                                                                </div>
                                                            </th>';
                                        $totalPercent = 0;
                                        foreach ($resultEventCriteria as $eventCriteriaResult) {
                                            $criteriaHeader = $eventCriteriaResult['criteria_name'];
                                            $criteriaHeaderPercent = $eventCriteriaResult['percent'];

                                            $totalPercent += $criteriaHeaderPercent;

                                            $judge .= ' 
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">'.$criteriaHeader.'('.$criteriaHeaderPercent.')</div>
                                                            </th>';
                                        }

                                            $judge .= '
                                                            <th>
                                                                <div class="small text-success ms-3 me-3" align="center">
                                                                    Total('. $totalPercent .')
                                                                </div>
                                                            </th>';

                                            $judge .= '
                                                        </tr>
                                                    </thead>
                                                    <tbody>';

                                                    foreach ($contestantsByCategoryMaleFemale as $eventContestantResult) {
                                                        $contestantCode = htmlspecialchars($eventContestantResult['code']);            
                                                        $contestantIsFinal = htmlspecialchars($eventContestantResult['is_finalist']);
                                                        $contestantSequence = htmlspecialchars($eventContestantResult['sequence']);
                                                        $contestantName = htmlspecialchars($eventContestantResult['name']);
                                                        $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                                        $totalScore = NULL; // Initialize total score for each contestant
                                                    

                                                        // Filter contestants if the "Finalist?" checkbox is checked
                                                        if ($isFinalistChecked === '1') {
                                                            if ($contestantIsFinal != '1') {
                                                                // Skip non-finalists if checkbox is checked
                                                                continue;
                                                            }
                                                        }

                                                        $judge .= '
                                                            <tr>
                                                                <td>
                                                                    <div class="small text-center">
                                                                        '. $contestantSequence .' ';

                                                if ($contestantGender != null && $isGeneral == 0) {
                                                    // Add your content when $contestantGender is true
                                                    $judge .= ' - '. $contestantGender .' ';
                                                }
                                                else{
                                                    $judge .= '';
                                                }
                                                                        
                                                    $judge .= '                
                                                                    </div>
                                                                </td>';
                                                    
                                                        foreach($resultEventCriteria as $eventCriteriaResult) {
                                                            $criteriaCode = htmlspecialchars($eventCriteriaResult['code']);
                                                            $selected_evnts = $_GET['selected_evnts'];
                                                            $selected_judge = $_GET['selected_judge'];
                                                            $eventScoreQuery = eventScoreList;
                                                            $stmt = $db->prepare($eventScoreQuery);
                                                            if (!$stmt) {
                                                                // Error handling for failed prepared statement
                                                                $errorMessage = $db->error;
                                                                // Handle error, log it, or display a message to the user
                                                                // Example: die("Database error: " . $errorMessage);
                                                                continue; // Skip to the next iteration
                                                            }
                                                            $stmt->bind_param("ssss", $selected_evnts, $contestantCode, $selected_judge, $criteriaCode);
                                                            $stmt->execute();
                                                            $resultEventScore = $stmt->get_result();
                                                            if (!$resultEventScore) {
                                                                // Error handling for failed query execution
                                                                $errorMessage = $db->error;
                                                                // Handle error, log it, or display a message to the user
                                                                // Example: die("Database error: " . $errorMessage);
                                                                continue; // Skip to the next iteration
                                                            }
                                                            $fetchResultEventScore = $resultEventScore->fetch_assoc();
                                                            if ($fetchResultEventScore !== null) {
                                                                // Access $fetchResultEventScore['score'] here
                                                                $score = $fetchResultEventScore['score'];
                                                                $totalScore += $score; // Add individual score to total score
                                                                $judge .= '
                                                                    <td>
                                                                        <div class="small text-center">
                                                                            '.$score.'
                                                                        </div>
                                                                    </td>';
                                                            } else {
                                                                // Handle the case where $fetchResultEventScore is null
                                                                // For example, you could output a placeholder or handle it differently
                                                                $judge .= '
                                                                    <td>
                                                                        <div class="small text-center">
                                                                            
                                                                        </div>
                                                                    </td>';
                                                            }
                                                        }
                                                    
                                                        // Add total score cell
                                                        $judge .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    '.$totalScore.'
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button data-code='. $contestantCode .' class="updateGenCode btn btn-outline-warning btn-sm rounded">Update</button>
                                                            </td>';
                                                    }
                                                    
                                                    

                                            $judge .= '
                                                    </tbody>
                                                </table>
                                            </div>';

                                            $judge .= '
                                            <div class="" align="center">
                                                <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\'data2\'], [\'selected\', \'m-hd\'])">Print Summary</button>
                                            </div>';
                                    }
$judge .='
                            </div>
                            <div class="tab-pane fade text-center" id="gay" role="tabpanel" aria-labelledby="gay-tab">
';
                     if (!empty($contestantsByCategoryGay)){
//=============================================================== Lgbtq Gay table ==========================================================

                                if ($isGeneral == 1) {  // Use double equal sign for comparison
                                    $judge .= '
                                        <h6 class="gy-hd mt-5 text-muted" align="center">General Summary</h6>
                                    ';
                                    $eventTitle = ($fetchResultEvents['event_type'] == "SP") ? "Special Event" : "";
                                    $judge .= '<h3 class="mt-2 text-danger selected" align="center">' . $eventTitle . '</h3>';
                                } else {
                                    $judge .= '
                                        <h6 class="gy-hd mt-5 text-muted" align="center">Gay Category Summary</h6>
                                    ';
                                    $eventTitle = ($fetchResultEvents['event_type'] == "SP") ? "Special Event" : "";
                                    $judge .= '<h3 class="mt-2 text-danger selected" align="center">' . $eventTitle . '</h3>';
                                }
                                $judge .= '
                                            <div class="card-body table-responsive-sm">
                                                <table class="table table-hover" id="data3">
                                                    <thead>
                                                        <tr>';

                                            $judge .= '
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">
                                                                    Candidate No.
                                                                </div>
                                                            </th>';
                                        $totalPercent = 0;
                                        foreach ($resultEventCriteria as $eventCriteriaResult) {
                                            $criteriaHeader = $eventCriteriaResult['criteria_name'];
                                            $criteriaHeaderPercent = $eventCriteriaResult['percent'];
                                        $totalPercent += $criteriaHeaderPercent;
                                            
                                            $judge .= ' 
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">'.$criteriaHeader.'('.$criteriaHeaderPercent.')</div>
                                                            </th>';
                                        }

                                            $judge .= '
                                                            <th>
                                                                <div class="small text-success ms-3 me-3" align="center">
                                                                    Total('.$totalPercent.')
                                                                </div>
                                                            </th>';

                                            $judge .= '
                                                        </tr>
                                                    </thead>
                                                    <tbody>';

                                                    foreach ($contestantsByCategoryGay as $eventContestantResult) {
                                                        $contestantCode = htmlspecialchars($eventContestantResult['code']);
                                                        $contestantIsFinal = htmlspecialchars($eventContestantResult['is_finalist']);
                                                        $contestantSequence = htmlspecialchars($eventContestantResult['sequence']);
                                                        $contestantName = htmlspecialchars($eventContestantResult['name']);
                                                        $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                                        $totalScore = NULL; // Initialize total score for each contestant
                                                
                                                        // Filter contestants if the "Finalist?" checkbox is checked
                                                        if ($isFinalistChecked === '1') {
                                                            if ($contestantIsFinal != '1') {
                                                                // Skip non-finalists if checkbox is checked
                                                                continue;
                                                            }
                                                        }

                                                        $judge .= '
                                                            <tr>
                                                                <td>
                                                                    <div class="small text-center">
                                                                    '. $contestantSequence .' ';

                                                if ($contestantGender != null && $isGeneral == 0) {
                                                    // Add your content when $contestantGender is true
                                                    $judge .=  ' - '. $contestantGender .' ';
                                                }
                                                else{
                                                    $judge .= '';
                                                }
                                                                        
                                                    $judge .= '                
                                                                    </div>
                                                                </td>';
                                                    
                                                        foreach($resultEventCriteria as $eventCriteriaResult) {
                                                            $criteriaCode = htmlspecialchars($eventCriteriaResult['code']);
                                                            $selected_evnts = $_GET['selected_evnts'];
                                                            $selected_judge = $_GET['selected_judge'];
                                                            $eventScoreQuery = eventScoreList;
                                                            $stmt = $db->prepare($eventScoreQuery);
                                                            if (!$stmt) {
                                                                // Error handling for failed prepared statement
                                                                $errorMessage = $db->error;
                                                                // Handle error, log it, or display a message to the user
                                                                // Example: die("Database error: " . $errorMessage);
                                                                continue; // Skip to the next iteration
                                                            }
                                                            $stmt->bind_param("ssss", $selected_evnts, $contestantCode, $selected_judge, $criteriaCode);
                                                            $stmt->execute();
                                                            $resultEventScore = $stmt->get_result();
                                                            if (!$resultEventScore) {
                                                                // Error handling for failed query execution
                                                                $errorMessage = $db->error;
                                                                // Handle error, log it, or display a message to the user
                                                                // Example: die("Database error: " . $errorMessage);
                                                                continue; // Skip to the next iteration
                                                            }
                                                            $fetchResultEventScore = $resultEventScore->fetch_assoc();
                                                            if ($fetchResultEventScore !== null) {
                                                                // Access $fetchResultEventScore['score'] here
                                                                $score = $fetchResultEventScore['score'];
                                                                $totalScore += $score; // Add individual score to total score
                                                                $judge .= '
                                                                    <td>
                                                                        <div class="small text-center">
                                                                            '.$score.'
                                                                        </div>
                                                                    </td>';
                                                            } else {
                                                                // Handle the case where $fetchResultEventScore is null
                                                                // For example, you could output a placeholder or handle it differently
                                                                $judge .= '
                                                                    <td>
                                                                        <div class="small text-center">
                                                                            
                                                                        </div>
                                                                    </td>';
                                                            }
                                                        }
                                                    
                                                        // Add total score cell
                                                        $judge .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    '.$totalScore.'
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button data-code='. $contestantCode .' class="updateGenCode btn btn-outline-warning btn-sm rounded">Update</button>
                                                            </td>';
                                                    }
                                                    
                                                    

                                            $judge .= '
                                                    </tbody>
                                                </table>
                                            </div>';

                                            $judge .= '
                                            <div class="" align="center">
                                                <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\'data3\'], [\'selected\', \'gy-hd\'])">Print Summary</button>
                                            </div>';
                                            }
$judge .='
                            </div>
                            <div class="tab-pane fade text-center" id="lesbian" role="tabpanel" aria-labelledby="lesbian-tab">
';
                    if (!empty($contestantsByCategoryLesbian)){
//=============================================================== Lgbtq Lesbian table ==========================================================
                                if ($isGeneral == 1) {  // Use double equal sign for comparison
                                    $judge .= '
                                        <h6 class="ls-hd mt-5 text-muted" align="center">General Summary</h6>
                                    ';
                                    $eventTitle = ($fetchResultEvents['event_type'] == "SP") ? "Special Event" : "";
                                    $judge .= '<h3 class="mt-2 text-danger selected" align="center">' . $eventTitle . '</h3>';
                                } else {
                                    $judge .= '
                                        <h6 class="ls-hd mt-5 text-muted" align="center">Lesbian Category Summary</h6>
                                    ';
                                    $eventTitle = ($fetchResultEvents['event_type'] == "SP") ? "Special Event" : "";
                                    $judge .= '<h3 class="mt-2 text-danger selected" align="center">' . $eventTitle . '</h3>';
                                }
                                $judge .= '
                                            
                                            <div class="card-body table-responsive-sm">
                                                <table class="table table-hover" id="data4">
                                                    <thead>
                                                        <tr>';

                                            $judge .= '
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">
                                                                    Candidate No.
                                                                </div>
                                                            </th>';
                                            $totalPercent = 0;
                                            foreach ($resultEventCriteria as $eventCriteriaResult) {
                                            $criteriaHeader = $eventCriteriaResult['criteria_name'];
                                            $criteriaHeaderPercent = $eventCriteriaResult['percent'];

                                            $totalPercent += $criteriaHeaderPercent;

                                            $judge .= ' 
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">'.$criteriaHeader.'('.$criteriaHeaderPercent.')</div>
                                                            </th>';
                                            }

                                            $judge .= '
                                                            <th>
                                                                <div class="small text-success ms-3 me-3" align="center">
                                                                    Total('.$totalPercent.')
                                                                </div>
                                                            </th>';

                                            $judge .= '
                                                        </tr>
                                                    </thead>
                                                    <tbody>';

                                                    foreach ($contestantsByCategoryLesbian as $eventContestantResult) {
                                                        $contestantCode = htmlspecialchars($eventContestantResult['code']);
                                                        $contestantIsFinal = htmlspecialchars($eventContestantResult['is_finalist']);
                                                        $contestantSequence = htmlspecialchars($eventContestantResult['sequence']);
                                                        $contestantName = htmlspecialchars($eventContestantResult['name']);
                                                        $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                                        $totalScore = NULL; // Initialize total score for each contestant
                                                
                                                        // Filter contestants if the "Finalist?" checkbox is checked
                                                        if ($isFinalistChecked === '1') {
                                                            if ($contestantIsFinal != '1') {
                                                                // Skip non-finalists if checkbox is checked
                                                                continue;
                                                            }
                                                        }

                                                        $judge .= '
                                                            <tr>
                                                                <td>
                                                                    <div class="small text-center">
                                                                    '. $contestantSequence .' ';

                                                if ($contestantGender != null && $isGeneral == 0) {
                                                    // Add your content when $contestantGender is true
                                                    $judge .=  ' - '. $contestantGender .' ';
                                                }
                                                else{
                                                    $judge .= '';
                                                }
                                                                        
                                                    $judge .= '                
                                                                    </div>
                                                                </td>';
                                                    
                                                        foreach($resultEventCriteria as $eventCriteriaResult) {
                                                            $criteriaCode = htmlspecialchars($eventCriteriaResult['code']);
                                                            $selected_evnts = $_GET['selected_evnts'];
                                                            $selected_judge = $_GET['selected_judge'];
                                                            $eventScoreQuery = eventScoreList;
                                                            $stmt = $db->prepare($eventScoreQuery);
                                                            if (!$stmt) {
                                                                // Error handling for failed prepared statement
                                                                $errorMessage = $db->error;
                                                                // Handle error, log it, or display a message to the user
                                                                // Example: die("Database error: " . $errorMessage);
                                                                continue; // Skip to the next iteration
                                                            }
                                                            $stmt->bind_param("ssss", $selected_evnts, $contestantCode, $selected_judge, $criteriaCode);
                                                            $stmt->execute();
                                                            $resultEventScore = $stmt->get_result();
                                                            if (!$resultEventScore) {
                                                                // Error handling for failed query execution
                                                                $errorMessage = $db->error;
                                                                // Handle error, log it, or display a message to the user
                                                                // Example: die("Database error: " . $errorMessage);
                                                                continue; // Skip to the next iteration
                                                            }
                                                            $fetchResultEventScore = $resultEventScore->fetch_assoc();
                                                            if ($fetchResultEventScore !== null) {
                                                                // Access $fetchResultEventScore['score'] here
                                                                $score = $fetchResultEventScore['score'];
                                                                $totalScore += $score; // Add individual score to total score
                                                                $judge .= '
                                                                    <td>
                                                                        <div class="small text-center">
                                                                            '.$score.'
                                                                        </div>
                                                                    </td>';
                                                            } else {
                                                                // Handle the case where $fetchResultEventScore is null
                                                                // For example, you could output a placeholder or handle it differently
                                                                $judge .= '
                                                                    <td>
                                                                        <div class="small text-center">
                                                                            
                                                                        </div>
                                                                    </td>';
                                                            }
                                                        }
                                                    
                                                        // Add total score cell
                                                        $judge .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    '.$totalScore.'
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button data-code='. $contestantCode .' class="updateGenCode btn btn-outline-warning btn-sm rounded">Update</button>
                                                            </td>';
                                                    }
                                                    
                                                    

                                            $judge .= '
                                                    </tbody>
                                                </table>
                                            </div>';

                                            $judge .= '
                                            <div class="" align="center">
                                                <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\'data4\'], [\'selected\', \'ls-hd\'])">Print Summary</button>
                                            </div>';
                                }
$judge .='
                            </div>
                            <div class="tab-pane fade text-center" id="both-gl" role="tabpanel" aria-labelledby="both-gl-tab">
';

$judge .='
                            </div>
                        </div>
';


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