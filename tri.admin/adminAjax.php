<?php
require '../include/connector/dbconn.php';

include "../include/generatedKey.php"; 
include "../include/query.php"; 

if(isset($_POST['event_category'])) {
    $event_category = $_POST['event_category'];
    $event_judge = $_POST['event_judge'];
    $conGeneral = $_POST['conGeneral'];
    $conWeightedScoring = $_POST['conWeightedScoring'];
    

    // Initialize an array to hold contestant data
    $contestantsByCategoryFemale  = [];
    $contestantsByCategoryMale  = [];
    $contestantsByCategoryLesbian  = [];
    $contestantsByCategoryGay  = [];
    $contestantsByCategoryBothMF = [];
    $contestantsByCategoryBothLGBTQ = [];
    
    // Fetch contestant list using parameterized query (IMPORTANT!!)
    $eventContestantQuery = contestantList;
    $stmt = $db->prepare($eventContestantQuery);
    $stmt->execute();
    $resultEventContestant = $stmt->get_result();

    if ($resultEventContestant) {
        while ($row = $resultEventContestant->fetch_assoc()) {
            $contestants[] = $row;
        }
    } else {
        // Handle database query error without revealing sensitive information
        echo "Error fetching contestant list";
        exit;
    }

    // Fetch female contestant by category list using parameterized query
    $eventContestantByCategoryFemaleQuery = contestantListFemale;
    $stmt = $db->prepare($eventContestantByCategoryFemaleQuery);
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

    // Fetch lesbian contestant by category list using parameterized query
    $eventContestantByCategoryLesbianQuery = contestantListLesbian;
    $stmt = $db->prepare($eventContestantByCategoryLesbianQuery);
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

    // Fetch gay contestant by category list using parameterized query
    $eventContestantByCategoryGayQuery = contestantListGay;
    $stmt = $db->prepare($eventContestantByCategoryGayQuery);
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

    // get criteria percentage list
    $eventCriteriaPercentageQuery = criteriaPercentageList;
    $stmt = $db->prepare($eventCriteriaPercentageQuery);
    $stmt->bind_param("s", $event_category);
    $stmt->execute();
    $resultEventCriteriaPercentage = $stmt->get_result();
    $fetchResultEventCriteriaPercentage = $resultEventCriteriaPercentage->fetch_assoc();

    // get Event list
    $eventQuery = eventListPreliminaryList;
    $stmt = $db->prepare($eventQuery);
    $stmt->bind_param("s", $event_category);
    $stmt->execute();
    $resultEvent = $stmt->get_result();
    $fetchResultEvent = $resultEvent->fetch_assoc();


    // get judge count list
    $eventJudgeCountQuery = judgeCountList;
    $stmt = $db->prepare($eventJudgeCountQuery);
    $stmt->execute();
    $resultEventJudgeCount = $stmt->get_result();


    // Function to generate category table
    function generateCategoryTable($contestants, $categoryName, $categoryClass, $tableId, $judgeQuery, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral) {
        if (empty($contestants)) return '';
        
        $output = '';
        
        if ($conGeneral == 1) {
            $output .= '<h6 class="'.$categoryClass.'-hd mt-5 text-muted" align="center">General Summary</h6>';
        } else {
            $output .= '<h6 class="'.$categoryClass.'-hd mt-4 text-muted" align="center">'.$categoryName.' Category Summary</h6>';
        }
        
        $output .= '<div class="card-body table-responsive-sm">
                        <table class="table table-hover" id="'.$tableId.'">
                            <thead>
                                <tr>
                                    <th><div class="small" align="center">Candidate No.</div></th>';
        
        // Get judge list
        $stmt = $db->prepare($judgeQuery);
        $stmt->execute();
        $resultEventJudge = $stmt->get_result();
        
        if ($resultEventJudge->num_rows > 0) {
            foreach ($resultEventJudge as $eventJudgeResult) {
                $output .= '<th data-type="number"><div class="small ms-3 me-3" align="center">'.$eventJudgeResult['name'].'</div></th>';
            }
        }
        
    $avgLabel = ($conWeightedScoring == 1) ? ('Average (%) - '. $fetchResultEvent['event_name'] . '') : ('Average (pts) - ' . $fetchResultEvent['event_name']);
    $output .= '<th data-type="number"><div class="small text-success" align="center">'.$avgLabel.'</div></th>
                    <th data-type="number"><div class="small" align="center">Rank</div></th>
                    </tr></thead><tbody>';
        
        // Process contestants
        $rankedContestants = [];
        foreach ($contestants as $eventContestantResult) {
            $contestantCode = htmlspecialchars($eventContestantResult['code']);
            $seqCons = htmlspecialchars($eventContestantResult['sequence']);
            $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
            $contestantSequence = ($conGeneral == 1 || empty($contestantGender)) ? $seqCons : ($seqCons . ' - ' . $contestantGender);
            
            $totalScore = 0.0;
            $judgeScores = [];
            
            foreach ($resultEventJudge as $eventJudgeResult) {
                $event_judge_code = $eventJudgeResult['code'];
                $eventJudgeScoreQuery = judgeEventScoreList;
                $stmt = $db->prepare($eventJudgeScoreQuery);
                $stmt->bind_param("sss", $event_category, $contestantCode, $event_judge_code);
                $stmt->execute();
                $resultEventJudgeScore = $stmt->get_result();
                
                $judgeScore = 0.0;
                if ($resultEventJudgeScore->num_rows > 0) {
                    while ($row = $resultEventJudgeScore->fetch_assoc()) {
                        $judgeScore += (float)$row['score'];
                    }
                }
                
                $judgeScores[$event_judge_code] = $judgeScore;
                $totalScore += $judgeScore;
            }
            
            $criteriaPercentage = $fetchResultEventCriteriaPercentage['percent'];
            $totalPossibleScore = $criteriaPercentage * $resultEventJudge->num_rows;
            
            if ($conWeightedScoring == 1) {
                $averageVal = ($totalPossibleScore > 0) ? (($totalScore / $totalPossibleScore) * 100.0) : 0.0;
            } else {
                $averageVal = ($resultEventJudge->num_rows > 0) ? ($totalScore / $resultEventJudge->num_rows) : 0.0;
            }
            $averageDisp = number_format($averageVal, 2) . (($conWeightedScoring == 1) ? ' %' : '');
            
            $rankedContestants[] = [
                'contestantSequence' => $contestantSequence,
                'judgeScores' => $judgeScores,
                'averageVal' => $averageVal,
                'averageDisp' => $averageDisp,
            ];
        }
        
        // Sort contestants
        usort($rankedContestants, function($a, $b) {
            return ($b['averageVal'] ?? 0) <=> ($a['averageVal'] ?? 0);
        });
        
        // Generate table rows
        $rank = 1;
        $previousRank = 1;
        $count = count($rankedContestants);
        for ($i = 0; $i < $count; $i++) {
            $contestant = $rankedContestants[$i];
            
            if ($i > 0 && round($contestant['averageVal'],2) === round($rankedContestants[$i - 1]['averageVal'],2)) {
                $currentRank = $previousRank;
            } else {
                $currentRank = $rank;
                $rank++;
            }
            $previousRank = $currentRank;
            
            $isTie = false;
            if (($i > 0 && round($contestant['averageVal'],2) === round($rankedContestants[$i - 1]['averageVal'],2)) ||
                ($i < $count - 1 && round($contestant['averageVal'],2) === round($rankedContestants[$i + 1]['averageVal'],2))) {
                $isTie = true;
            }
            
            $displayRank = $currentRank . ($isTie ? '.5' : '');
            
            $output .= '<tr><td><div class="small text-center">' . $contestant['contestantSequence'] . '</div></td>';
            
            foreach ($contestant['judgeScores'] as $judgeScore) {
                $output .= '<td><div class="small text-center">' . number_format((float)$judgeScore, 2) . '</div></td>';
            }
            
            $output .= '<td data-sort="' . number_format((float)$contestant['averageVal'], 2, '.', '') . '"><div class="small text-center">' . $contestant['averageDisp'] . '</div></td>
                        <td><div class="small text-center">' . $displayRank . '</div></td></tr>';
        }
        
        $output .= '</tbody></table></div>';
        $output .= '<div class="" align="center">
                        <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\''.$tableId.'\'], [\'selected\', \''.$categoryClass.'-hd\'])">Print Summary</button>
                    </div>';
        
        return $output;
    }

    // Fetch details and build HTML outside the loop
    $summary = '';

    if ($resultEventContestant->num_rows > 0) {

        if($fetchResultEvent != NULL){
            $fetchResultEventJudgeCount = $resultEventJudgeCount->fetch_assoc();
            $summary .= '<h3 class="mt-4 selected text-muted" align="center">'.$fetchResultEvent['event_name'].'</h3>';
        }
        else{
            $summary .= '<h3 class="mt-4 text-muted" align="center"></h3>';
        }
        
        // Add navigation tabs
    $summary .= '<ul class="nav nav-tabs mt-4 justify-content-center" id="categoryTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All Categories</button>
                        </li>';
        
        if (!empty($contestantsByCategoryFemale)) {
            $summary .= '<li class="nav-item" role="presentation">
                            <button class="nav-link" id="female-tab" data-bs-toggle="tab" data-bs-target="#female" type="button" role="tab">Female</button>
                        </li>';
        }
        if (!empty($contestantsByCategoryMale)) {
            $summary .= '<li class="nav-item" role="presentation">
                            <button class="nav-link" id="male-tab" data-bs-toggle="tab" data-bs-target="#male" type="button" role="tab">Male</button>
                        </li>';
        }
        if (!empty($contestantsByCategoryLesbian)) {
            $summary .= '<li class="nav-item" role="presentation">
                            <button class="nav-link" id="lesbian-tab" data-bs-toggle="tab" data-bs-target="#lesbian" type="button" role="tab">Lesbian</button>
                        </li>';
        }
        if (!empty($contestantsByCategoryGay)) {
            $summary .= '<li class="nav-item" role="presentation">
                            <button class="nav-link" id="gay-tab" data-bs-toggle="tab" data-bs-target="#gay" type="button" role="tab">Gay</button>
                        </li>';
        }
        if (!empty($contestantsByCategoryBothMF)) {
            $summary .= '<li class="nav-item" role="presentation">
                            <button class="nav-link" id="bothmf-tab" data-bs-toggle="tab" data-bs-target="#bothmf" type="button" role="tab">Both M/F</button>
                        </li>';
        }
        if (!empty($contestantsByCategoryBothLGBTQ)) {
            $summary .= '<li class="nav-item" role="presentation">
                            <button class="nav-link" id="bothlgbtq-tab" data-bs-toggle="tab" data-bs-target="#bothlgbtq" type="button" role="tab">Both LGBTQ</button>
                        </li>';
        }
        
        $summary .= '</ul>';
        
        // Tab content
        $summary .= '<div class="tab-content" id="categoryTabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel">';

        // Generate all category tables for "All Categories" tab
        $summary .= generateCategoryTable($contestantsByCategoryFemale, 'Female', 'fm', 'data1', judgeByCategorySummaryListFemale, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
        $summary .= generateCategoryTable($contestantsByCategoryMale, 'Male', 'm', 'data2', judgeByCategorySummaryListMale, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
        $summary .= generateCategoryTable($contestantsByCategoryLesbian, 'Lesbian', 'ls', 'data3', judgeByCategorySummaryListLesbian, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
        $summary .= generateCategoryTable($contestantsByCategoryGay, 'Gay', 'gy', 'data4', judgeByCategorySummaryListGay, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
        $summary .= generateCategoryTable($contestantsByCategoryBothMF, 'Both Male and Female', 'bmf', 'data5', judgeByCategorySummaryListBothMF, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
        $summary .= generateCategoryTable($contestantsByCategoryBothLGBTQ, 'Both LGBTQ', 'blgbtq', 'data6', judgeByCategorySummaryListBothLGBTQ, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
        
        $summary .= '</div>'; // Close "All Categories" tab
        
        // Individual category tabs
        if (!empty($contestantsByCategoryFemale)) {
            $summary .= '<div class="tab-pane fade" id="female" role="tabpanel">';
            $summary .= generateCategoryTable($contestantsByCategoryFemale, 'Female', 'fm', 'data1-single', judgeByCategorySummaryListFemale, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
            $summary .= '</div>';
        }
        
        if (!empty($contestantsByCategoryMale)) {
            $summary .= '<div class="tab-pane fade" id="male" role="tabpanel">';
            $summary .= generateCategoryTable($contestantsByCategoryMale, 'Male', 'm', 'data2-single', judgeByCategorySummaryListMale, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
            $summary .= '</div>';
        }
        
        if (!empty($contestantsByCategoryLesbian)) {
            $summary .= '<div class="tab-pane fade" id="lesbian" role="tabpanel">';
            $summary .= generateCategoryTable($contestantsByCategoryLesbian, 'Lesbian', 'ls', 'data3-single', judgeByCategorySummaryListLesbian, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
            $summary .= '</div>';
        }
        
        if (!empty($contestantsByCategoryGay)) {
            $summary .= '<div class="tab-pane fade" id="gay" role="tabpanel">';
            $summary .= generateCategoryTable($contestantsByCategoryGay, 'Gay', 'gy', 'data4-single', judgeByCategorySummaryListGay, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
            $summary .= '</div>';
        }
        
        if (!empty($contestantsByCategoryBothMF)) {
            $summary .= '<div class="tab-pane fade" id="bothmf" role="tabpanel">';
            $summary .= generateCategoryTable($contestantsByCategoryBothMF, 'Both Male and Female', 'bmf', 'data5-single', judgeByCategorySummaryListBothMF, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
            $summary .= '</div>';
        }
        
        if (!empty($contestantsByCategoryBothLGBTQ)) {
            $summary .= '<div class="tab-pane fade" id="bothlgbtq" role="tabpanel">';
            $summary .= generateCategoryTable($contestantsByCategoryBothLGBTQ, 'Both LGBTQ', 'blgbtq', 'data6-single', judgeByCategorySummaryListBothLGBTQ, $db, $event_category, $fetchResultEvent, $fetchResultEventCriteriaPercentage, $conWeightedScoring, $conGeneral);
            $summary .= '</div>';
        }
        
        $summary .= '</div>'; // Close tab-content
    } else {
        $summary .= '
                <div class="mt-5" align="center">
                    <h2 class="text-danger">No Contestants Found!</h2>
                </div>
            ';
    }

    echo $summary;
}
?>
