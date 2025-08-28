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
        <title>Admin | Preliminary Summary</title>
        <link rel="icon" type="image/x-icon" href="../assets/img/<?= $logo ?>" />
        <link href="../css/dataTable.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/jquery-ui.min.css">
        <script src="../js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">

    <?php include "../include/topNav.php";?>


        <div id="layoutSidenav">
        <?php include "../include/admininclude/adminSideNav.php";?>
            
            <div id="layoutSidenav_content">
            <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 text-muted">Preliminary Overall Summary Dashboard</h1>
                            <section>
                                <div class="card">
                                    <div class="card-body">
                                    <?php


                                    // Initialize an array to hold contestant data
                                    // $contestants = [];
                                    $contestantsByCategoryFemale  = [];
                                    $contestantsByCategoryMale  = [];
                                    $contestantsByCategoryLesbian  = [];
                                    $contestantsByCategoryGay  = [];

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

                                    // Fetch Lesbian contestant by category list using parameterized query
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

                                    // Fetch Gay contestant by category list using parameterized query
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

                                    // get event percentage list
                                    $eventPercentageOverallQuery = eventPercentage;
                                    $stmt = $db->prepare($eventPercentageOverallQuery);
                                    $stmt->execute();
                                    $resultEventPercentage = $stmt->get_result();
                                    $fetchResultEventPercentage = $resultEventPercentage->fetch_assoc();

                                    // get event count list
                                    $eventOverallQuery = eventPercentage;
                                    $stmt = $db->prepare($eventOverallQuery);
                                    $stmt->execute();
                                    $resultEventOverall = $stmt->get_result();
                                    $fetchResultEventOverall = $resultEventOverall->fetch_assoc();

                                    //get Female Category judge count list
                                    $eventJudgeCountFemaleQuery = judgeCountListFemale;
                                    $stmt = $db->prepare($eventJudgeCountFemaleQuery);
                                    $stmt->execute();
                                    $resultEventJudgeCountFemale = $stmt->get_result();
                                    $fetchResultEventJudgeCountFemale = $resultEventJudgeCountFemale->fetch_assoc();

                                    //get Male Category judge count list
                                    $eventJudgeCountMaleQuery = judgeCountListFemale;
                                    $stmt = $db->prepare($eventJudgeCountMaleQuery);
                                    $stmt->execute();
                                    $resultEventJudgeCountMale = $stmt->get_result();
                                    $fetchResultEventJudgeCountMale = $resultEventJudgeCountMale->fetch_assoc();

                                    //get Lesbian Category judge count list
                                    $eventJudgeCountLesbianQuery = judgeCountListLesbian;
                                    $stmt = $db->prepare($eventJudgeCountLesbianQuery);
                                    $stmt->execute();
                                    $resultEventJudgeCountLesbian = $stmt->get_result();
                                    $fetchResultEventJudgeCountLesbian = $resultEventJudgeCountLesbian->fetch_assoc();

                                    //get Gay Category judge count list
                                    $eventJudgeCountGayQuery = judgeCountListGay;
                                    $stmt = $db->prepare($eventJudgeCountGayQuery);
                                    $stmt->execute();
                                    $resultEventJudgeCountGay = $stmt->get_result();
                                    $fetchResultEventJudgeCountGay = $resultEventJudgeCountGay->fetch_assoc();

                                    
                                    // Fetch details and build HTML outside the loop
                                    $summary = '';

                                    if ($resultEventContestant->num_rows > 0) {

                                        $summary .= '<h3 class="mt-4 selected text-muted" align="center">Preliminary Overall Summary</h3>';

                    if (!empty($contestantsByCategoryFemale)){    
 //=================================================Female Category =======================================================

                            if ($isGeneral == 1) {  // Use double equal sign for comparison
                                $summary .= '
                                    <h6 class="fm-hd mt-5 text-muted" align="center">General Summary</h6>
                                ';
                            } else {
                                $summary .= '
                                    <h6 class="fm-hd mt-4 text-muted" align="center">Female Category Summary</h6>
                                ';
                            }
 
                            $summary .= '
                                        <div class="card-body table-responsive-sm">
                                            <table class="table table-hover" id="data1">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div class="small" align="center">
                                                                Candidate No.
                                                            </div>
                                                        </th>';

                                        // get event list
                                        $eventNameQuery = eventList;
                                        $stmt = $db->prepare($eventNameQuery);
                                        $stmt->execute();
                                        $resultEventName = $stmt->get_result();

                                        if ($resultEventName->num_rows > 0) {
                                        foreach ($resultEventName as $eventNameResult) {
                                            $eventNameHeader = $eventNameResult['event_name'];
                                            $summary .= '
                                                <th>
                                                    <div class="small ms-3 me-3" align="center">
                                                        ' . $eventNameHeader . '
                                                    </div>
                                                </th>';
                                        }
                                        }

                                        $summary .= '
                                                <th>
                                                    <div class="small text-success" align="center">
                                                        Average - Overall
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="small" align="center">
                                                        Rank
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                                        $rankedContestants = [];

                                        foreach ($contestantsByCategoryFemale as $eventContestantResult) {
                                            $contestantCode = htmlspecialchars($eventContestantResult['code']);
                                            $seqCons = htmlspecialchars($eventContestantResult['sequence']);
                                            $contestantName = htmlspecialchars($eventContestantResult['name']);
                                            $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                            // $contestantSequence = $contestantGender ? $seqCons . ' - ' . $contestantGender : $seqCons;
                                            $contestantSequence = ($contestantGender != null || $isGeneral == 1) ? $seqCons : $seqCons . ' - ' . $contestantGender;
                                            $judgeCountOverall = $fetchResultEventJudgeCountFemale['judge_count'];
                                            
                                        $totalOverallAverageScore = 0;
                                        $prelimenaryOverallCriteriapercentage = 0;
                                        $averagePoint = 0;
                                        $overallScoresArray = [];

                                        foreach ($resultEventName as $eventJudgeResult) {
                                            $event_judge_code = $eventJudgeResult['code'];
                                            $eventOverallScoreQuery = overallSummaryOverallSummary;
                                            $stmt = $db->prepare($eventOverallScoreQuery);
                                            $stmt->bind_param("ss", $event_judge_code, $contestantCode);
                                            $stmt->execute();
                                            $resultEventOverallScore = $stmt->get_result();

                                            if ($resultEventOverallScore->num_rows > 0) {
                                                foreach ($resultEventOverallScore as $eventOverallScoreSummaryResult) {
                                                    $judgeScore = $eventOverallScoreSummaryResult['overallSummary'];
                                                    $eventCodeOverall = $eventOverallScoreSummaryResult['event_code'];

                                                    // get criteria percentage per event list
                                                    $eventCriteriaPercentageQuery = criteriaPercentageList;
                                                    $stmt = $db->prepare($eventCriteriaPercentageQuery);
                                                    $stmt->bind_param("s", $eventCodeOverall);
                                                    $stmt->execute();
                                                    $resultEventCriteriaPercentage = $stmt->get_result();
                                                    $fetchResultEventCriteriaPercentage = $resultEventCriteriaPercentage->fetch_assoc();

                                                    // get criteria percentage overall list
                                                    $eventCriteriaPercentageOverallQuery = criteriaPercentage;
                                                    $stmt = $db->prepare($eventCriteriaPercentageOverallQuery);
                                                    $stmt->execute();
                                                    $resultEventCriteriaPercentageOverall = $stmt->get_result();
                                                    $fetchResultEventCriteriaPercentageOverall = $resultEventCriteriaPercentageOverall->fetch_assoc();

                                                    $criteriaPercentageCount = $fetchResultEventCriteriaPercentage['percent'];
                                                    $eventtotalPossibleScore = $criteriaPercentageCount * $judgeCountOverall;

                                                    $overallSumOfCriteria = $fetchResultEventCriteriaPercentageOverall['cretiria_percent'];
                                                    $prelimenaryOverallCriteriapercentage = $overallSumOfCriteria * $judgeCountOverall;

                                                    if ($eventtotalPossibleScore > 0 && $prelimenaryOverallCriteriapercentage > 0) {
                                                        $totalOverallAverageScore += $judgeScore;
                                                                                                                
                                                        if($weightedScoring == 1){
                                                            $overallScore = number_format($judgeScore / $eventtotalPossibleScore * 100.0, 2);
                                                        } else {
                                                            $overallScore = number_format($judgeScore / $judgeCountOverall, 2);
                                                            $averagePoint += $overallScore;
                                                        }

                                                        $overallScoresArray[] = $overallScore;
                                                    } else {
                                                        // Add an empty entry if no score
                                                        $overallScoresArray[] = null;
                                                    }
                                                }
                                            } else {
                                                // If no results, add an empty entry
                                                $overallScoresArray[] = null;
                                            }
                                        }

                                        if($weightedScoring == 1){
                                            $overallAverageScore = number_format($totalOverallAverageScore / $prelimenaryOverallCriteriapercentage * 100.0, 2) . ' ';
                                        } else {
                                            $overallAverageScore = number_format($averagePoint / $resultEventName->num_rows, 2) . ' ';
                                        }
                                        
                                        $rankedContestants[] = [
                                            'contestantSequence' => $contestantSequence,
                                            'overallScoresArray' => $overallScoresArray,
                                            'overallAverageScore' => $overallAverageScore,
                                        ];
                                        }

                                        // Sort contestants based on overall average score (descending order)
                                        usort($rankedContestants, function($a, $b) {
                                            return $b['overallAverageScore'] <=> $a['overallAverageScore'];
                                        });

                                        // Initialize rank and summary container
                                        $rank = 1;
                                        $count = count($rankedContestants);

                                        for ($i = 0; $i < $count; $i++) {
                                            $contestantFemale = $rankedContestants[$i];

                                            // If this candidate is tied with the previous candidate, reuse the previous candidate's base rank.
                                            if ($i > 0 && $contestantFemale['overallAverageScore'] === $rankedContestants[$i - 1]['overallAverageScore']) {
                                                $currentRank = $previousRank;
                                            } else {
                                                $currentRank = $rank;
                                                $rank++; // Increment base rank for next unique candidate
                                            }
                                            $previousRank = $currentRank; // Store for the next iteration

                                            // Determine if this candidate is part of a tie group
                                            $isTie = false;
                                            if (
                                                ($i > 0 && $contestantFemale['overallAverageScore'] === $rankedContestants[$i - 1]['overallAverageScore']) ||
                                                ($i < $count - 1 && $contestantFemale['overallAverageScore'] === $rankedContestants[$i + 1]['overallAverageScore'])
                                            ) {
                                                $isTie = true;
                                            }

                                            // Prepare display rank with ".5" suffix if tied
                                            $displayRank = $currentRank . ($isTie ? '.5' : '');

                                            // Build the table row
                                            $summary .= '<tr>';
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . $contestantFemale['contestantSequence'] . '
                                                            </div>
                                                        </td>';

                                            // Loop through the overallScoresArray and add each score cell
                                            foreach ($contestantFemale['overallScoresArray'] as $overallScorePrelim) {
                                                if (!empty($overallScorePrelim)) {
                                                    $summary .= '<td>
                                                                    <div class="small text-center">
                                                                        ' . $overallScorePrelim . '
                                                                    </div>
                                                                </td>';
                                                } else {
                                                    // Add an empty cell if overallScorePrelim is empty
                                                    $summary .= '<td>
                                                                    <div class="small text-center">&nbsp;</div>
                                                                </td>';
                                                }
                                            }

                                            // Add the overall average score cell
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . ($contestantFemale['overallAverageScore'] ?? '&nbsp;') . '
                                                            </div>
                                                        </td>';

                                            // Add the rank cell with displayRank
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . $displayRank . '
                                                            </div>
                                                        </td>';

                                            $summary .= '</tr>';
                                        }


                                        $summary .= '
                                                </tbody>
                                            </table>    
                                        </div>';

                                        $summary .= '
                                        <div class="" align="center">
                                            <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\'data1\'], [\'selected\', \'fm-hd\'])">Print Summary</button>
                                        </div>';
                    }

                    if (!empty($contestantsByCategoryMale)){ 
                                        
 //================================================= Male Category =======================================================

                                        if ($isGeneral == 1) {  // Use double equal sign for comparison
                                            $summary .= '
                                                <h6 class="m-hd mt-5 text-muted" align="center">General Summary</h6>
                                            ';
                                        } else {
                                            $summary .= '
                                                <h6 class="m-hd mt-4 text-muted" align="center">Male Category Summary</h6>
                                            ';
                                        }

                                        $summary .= '
                                        
                                        <div class="card-body table-responsive-sm">
                                            <table class="table table-hover" id="data2">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div class="small" align="center">
                                                                Candidate No.
                                                            </div>
                                                        </th>';

                                        // get event list
                                        $eventNameQuery = eventList;
                                        $stmt = $db->prepare($eventNameQuery);
                                        $stmt->execute();
                                        $resultEventName = $stmt->get_result();

                                        if ($resultEventName->num_rows > 0) {
                                        foreach ($resultEventName as $eventNameResult) {
                                            $eventNameHeader = $eventNameResult['event_name'];
                                            $summary .= '
                                                <th>
                                                    <div class="small ms-3 me-3" align="center">
                                                        ' . $eventNameHeader . ' (100)
                                                    </div>
                                                </th>';
                                        }
                                        }

                                        $summary .= '
                                                <th>
                                                    <div class="small" align="center">
                                                        Events General Average (100)
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="small" align="center">
                                                        Rank
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                                        $rankedContestants = [];

                                        foreach ($contestantsByCategoryMale as $eventContestantResult) {
                                        $contestantCode = htmlspecialchars($eventContestantResult['code']);
                                        $seqCons = htmlspecialchars($eventContestantResult['sequence']);
                                        $contestantName = htmlspecialchars($eventContestantResult['name']);
                                        $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                        $contestantSequence = $contestantGender ? $seqCons . ' - ' . $contestantGender : $seqCons;
                                        $judgeCountOverall = $fetchResultEventJudgeCountMale['judge_count'];

                                        $totalOverallAverageScore = 0;
                                        $prelimenaryOverallCriteriapercentage = 0;
                                        $averagePoint = 0;
                                        $overallScoresArray = [];

                                        foreach ($resultEventName as $eventJudgeResult) {
                                            $event_judge_code = $eventJudgeResult['code'];
                                            $eventOverallScoreQuery = overallSummaryOverallSummary;
                                            $stmt = $db->prepare($eventOverallScoreQuery);
                                            $stmt->bind_param("ss", $event_judge_code, $contestantCode);
                                            $stmt->execute();
                                            $resultEventOverallScore = $stmt->get_result();

                                            if ($resultEventOverallScore->num_rows > 0) {
                                                foreach ($resultEventOverallScore as $eventOverallScoreSummaryResult) {
                                                    $judgeScore = $eventOverallScoreSummaryResult['overallSummary'];
                                                    $eventCodeOverall = $eventOverallScoreSummaryResult['event_code'];

                                                    // get criteria percentage per event list
                                                    $eventCriteriaPercentageQuery = criteriaPercentageList;
                                                    $stmt = $db->prepare($eventCriteriaPercentageQuery);
                                                    $stmt->bind_param("s", $eventCodeOverall);
                                                    $stmt->execute();
                                                    $resultEventCriteriaPercentage = $stmt->get_result();
                                                    $fetchResultEventCriteriaPercentage = $resultEventCriteriaPercentage->fetch_assoc();

                                                    // get criteria percentage overall list
                                                    $eventCriteriaPercentageOverallQuery = criteriaPercentage;
                                                    $stmt = $db->prepare($eventCriteriaPercentageOverallQuery);
                                                    $stmt->execute();
                                                    $resultEventCriteriaPercentageOverall = $stmt->get_result();
                                                    $fetchResultEventCriteriaPercentageOverall = $resultEventCriteriaPercentageOverall->fetch_assoc();

                                                    $criteriaPercentageCount = $fetchResultEventCriteriaPercentage['percent'];
                                                    $eventtotalPossibleScore = $criteriaPercentageCount * $judgeCountOverall;

                                                    $overallSumOfCriteria = $fetchResultEventCriteriaPercentageOverall['cretiria_percent'];
                                                    $prelimenaryOverallCriteriapercentage = $overallSumOfCriteria * $judgeCountOverall;

                                                    if ($eventtotalPossibleScore > 0 && $prelimenaryOverallCriteriapercentage > 0) {
                                                        $totalOverallAverageScore += $judgeScore;
                                                        if($weightedScoring == 1){
                                                            $overallScore = number_format($judgeScore / $eventtotalPossibleScore * 100.0, 2);
                                                        } else {
                                                            $overallScore = number_format($judgeScore / $resultEventName->num_rows, 2);
                                                            $averagePoint += $overallScore;
                                                        }
                                                        $overallScoresArray[] = $overallScore;
                                                    } else {
                                                        // Add an empty entry if no score
                                                        $overallScoresArray[] = null;
                                                    }
                                                }
                                            } else {
                                                // If no results, add an empty entry
                                                $overallScoresArray[] = null;
                                            }
                                        }

                                        if($weightedScoring == 1){
                                            $overallAverageScore = number_format($totalOverallAverageScore / $prelimenaryOverallCriteriapercentage * 100.0, 2) . ' ';
                                        } else {
                                            $overallAverageScore = number_format($averagePoint / $judgeCountOverall, 2) . ' ';
                                        }
                                        
                                        $rankedContestants[] = [
                                            'contestantSequence' => $contestantSequence,
                                            'overallScoresArray' => $overallScoresArray,
                                            'overallAverageScore' => $overallAverageScore,
                                        ];
                                        }

                                        usort($rankedContestants, function($a, $b) {
                                            return $b['overallAverageScore'] <=> $a['overallAverageScore'];
                                        });

                                        // Initialize rank and summary container
                                        $rank = 1;
                                        $count = count($rankedContestants);

                                        for ($i = 0; $i < $count; $i++) {
                                            $contestantMale = $rankedContestants[$i];

                                            // If this candidate is tied with the previous candidate, reuse the previous candidate's base rank.
                                            if ($i > 0 && $contestantMale['overallAverageScore'] === $rankedContestants[$i - 1]['overallAverageScore']) {
                                                $currentRank = $previousRank;
                                            } else {
                                                $currentRank = $rank;
                                                $rank++; // Increment base rank for next unique candidate
                                            }
                                            $previousRank = $currentRank; // Store for the next iteration

                                            // Determine if this candidate is part of a tie group
                                            $isTie = false;
                                            if (
                                                ($i > 0 && $contestantMale['overallAverageScore'] === $rankedContestants[$i - 1]['overallAverageScore']) ||
                                                ($i < $count - 1 && $contestantMale['overallAverageScore'] === $rankedContestants[$i + 1]['overallAverageScore'])
                                            ) {
                                                $isTie = true;
                                            }

                                            // Prepare display rank with ".5" suffix if tied
                                            $displayRank = $currentRank . ($isTie ? '.5' : '');

                                            // Build the table row
                                            $summary .= '<tr>';
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . $contestantMale['contestantSequence'] . '
                                                            </div>
                                                        </td>';

                                            // Loop through the overallScoresArray and add each score cell
                                            foreach ($contestantMale['overallScoresArray'] as $overallScorePrelim) {
                                                if (!empty($overallScorePrelim)) {
                                                    $summary .= '<td>
                                                                    <div class="small text-center">
                                                                        ' . $overallScorePrelim . '
                                                                    </div>
                                                                </td>';
                                                } else {
                                                    // Add an empty cell if overallScorePrelim is empty
                                                    $summary .= '<td>
                                                                    <div class="small text-center">&nbsp;</div>
                                                                </td>';
                                                }
                                            }

                                            // Add the overall average score cell
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . ($contestantMale['overallAverageScore'] ?? '&nbsp;') . '
                                                            </div>
                                                        </td>';

                                            // Add the rank cell with displayRank
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . $displayRank . '
                                                            </div>
                                                        </td>';

                                            $summary .= '</tr>';
                                        }

                                        $summary .= '
                                                </tbody>
                                            </table>    
                                        </div>';

                                        $summary .= '
                                        <div class="" align="center">
                                            <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\'data2\'], [\'selected\', \'m-hd\'])">Print Summary</button>
                                        </div>';
                }

                if (!empty($contestantsByCategoryLesbian)){ 
//=================================================== Lesbian Table =====================================================================================================================================================

                            if ($isGeneral == 1) {  // Use double equal sign for comparison
                                $summary .= '
                                    <h6 class="ls-hd mt-5 text-muted" align="center">General Summary</h6>
                                ';
                            } else {
                                $summary .= '
                                     <h6 class="ls-hd mt-4 text-muted" align="center">Lesbian Category Summary</h6>
                                ';
                            }

                            $summary .= '

                                        <div class="card-body table-responsive-sm">
                                            <table class="table table-hover" id="data3">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div class="small" align="center">
                                                                Candidate No.
                                                            </div>
                                                        </th>';

                                        // get event list
                                        $eventNameQuery = eventList;
                                        $stmt = $db->prepare($eventNameQuery);
                                        $stmt->execute();
                                        $resultEventName = $stmt->get_result();

                                        if ($resultEventName->num_rows > 0) {
                                        foreach ($resultEventName as $eventNameResult) {
                                            $eventNameHeader = $eventNameResult['event_name'];
                                            $summary .= '
                                                <th>
                                                    <div class="small ms-3 me-3" align="center">
                                                        ' . $eventNameHeader . ' (100)
                                                    </div>
                                                </th>';
                                        }
                                        }

                                        $summary .= '
                                                <th>
                                                    <div class="small" align="center">
                                                        Events General Average (100)
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="small" align="center">
                                                        Rank
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                                        $rankedContestants = [];

                                        foreach ($contestantsByCategoryLesbian as $eventContestantResult) {
                                            $contestantCode = htmlspecialchars($eventContestantResult['code']);
                                            $seqCons = htmlspecialchars($eventContestantResult['sequence']);
                                            $contestantName = htmlspecialchars($eventContestantResult['name']);
                                            $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                            $contestantSequence = $contestantGender ? $seqCons . ' - ' . $contestantGender : $seqCons;
                                            $judgeCountOverall = $fetchResultEventJudgeCountLesbian['judge_count'];

                                        $totalOverallAverageScore = 0;
                                        $prelimenaryOverallCriteriapercentage = 0;
                                        $averagePoint = 0;
                                        $overallScoresArray = [];

                                        foreach ($resultEventName as $eventJudgeResult) {
                                            $event_judge_code = $eventJudgeResult['code'];
                                            $eventOverallScoreQuery = overallSummaryOverallSummary;
                                            $stmt = $db->prepare($eventOverallScoreQuery);
                                            $stmt->bind_param("ss", $event_judge_code, $contestantCode);
                                            $stmt->execute();
                                            $resultEventOverallScore = $stmt->get_result();

                                            if ($resultEventOverallScore->num_rows > 0) {
                                                foreach ($resultEventOverallScore as $eventOverallScoreSummaryResult) {
                                                    $judgeScore = $eventOverallScoreSummaryResult['overallSummary'];
                                                    $eventCodeOverall = $eventOverallScoreSummaryResult['event_code'];

                                                    // get criteria percentage per event list
                                                    $eventCriteriaPercentageQuery = criteriaPercentageList;
                                                    $stmt = $db->prepare($eventCriteriaPercentageQuery);
                                                    $stmt->bind_param("s", $eventCodeOverall);
                                                    $stmt->execute();
                                                    $resultEventCriteriaPercentage = $stmt->get_result();
                                                    $fetchResultEventCriteriaPercentage = $resultEventCriteriaPercentage->fetch_assoc();

                                                    // get criteria percentage overall list
                                                    $eventCriteriaPercentageOverallQuery = criteriaPercentage;
                                                    $stmt = $db->prepare($eventCriteriaPercentageOverallQuery);
                                                    $stmt->execute();
                                                    $resultEventCriteriaPercentageOverall = $stmt->get_result();
                                                    $fetchResultEventCriteriaPercentageOverall = $resultEventCriteriaPercentageOverall->fetch_assoc();

                                                    $criteriaPercentageCount = $fetchResultEventCriteriaPercentage['percent'];
                                                    $eventtotalPossibleScore = $criteriaPercentageCount * $judgeCountOverall;

                                                    $overallSumOfCriteria = $fetchResultEventCriteriaPercentageOverall['cretiria_percent'];
                                                    $prelimenaryOverallCriteriapercentage = $overallSumOfCriteria * $judgeCountOverall;

                                                    if ($eventtotalPossibleScore > 0 && $prelimenaryOverallCriteriapercentage > 0) {
                                                        $totalOverallAverageScore += $judgeScore;
                                                        if($weightedScoring == 1){
                                                            $overallScore = number_format($judgeScore / $eventtotalPossibleScore * 100.0, 2);
                                                        } else {
                                                            $overallScore = number_format($judgeScore / $resultEventName->num_rows, 2);
                                                            $averagePoint += $overallScore;
                                                        }
                                                        $overallScoresArray[] = $overallScore;
                                                    } else {
                                                        // Add an empty entry if no score
                                                        $overallScoresArray[] = null;
                                                    }
                                                }
                                            } else {
                                                // If no results, add an empty entry
                                                $overallScoresArray[] = null;
                                            }
                                        }

                                        if($weightedScoring == 1){
                                            $overallAverageScore = number_format($totalOverallAverageScore / $prelimenaryOverallCriteriapercentage * 100.0, 2) . ' ';
                                        } else {
                                            $overallAverageScore = number_format($averagePoint / $judgeCountOverall, 2) . ' ';
                                        }

                                        $rankedContestants[] = [
                                            'contestantSequence' => $contestantSequence,
                                            'overallScoresArray' => $overallScoresArray,
                                            'overallAverageScore' => $overallAverageScore,
                                        ];
                                        }

                                        usort($rankedContestants, function($a, $b) {
                                            return $b['overallAverageScore'] <=> $a['overallAverageScore'];
                                        });

                                        // Initialize rank and summary container
                                        $rank = 1;
                                        $count = count($rankedContestants);

                                        for ($i = 0; $i < $count; $i++) {
                                            $contestantLesbian = $rankedContestants[$i];

                                            // If this candidate is tied with the previous candidate, reuse the previous candidate's base rank.
                                            if ($i > 0 && $contestantLesbian['overallAverageScore'] === $rankedContestants[$i - 1]['overallAverageScore']) {
                                                $currentRank = $previousRank;
                                            } else {
                                                $currentRank = $rank;
                                                $rank++; // Increment base rank for next unique candidate
                                            }
                                            $previousRank = $currentRank; // Store for the next iteration

                                            // Determine if this candidate is part of a tie group
                                            $isTie = false;
                                            if (
                                                ($i > 0 && $contestantLesbian['overallAverageScore'] === $rankedContestants[$i - 1]['overallAverageScore']) ||
                                                ($i < $count - 1 && $contestantLesbian['overallAverageScore'] === $rankedContestants[$i + 1]['overallAverageScore'])
                                            ) {
                                                $isTie = true;
                                            }

                                            // Prepare display rank with ".5" suffix if tied
                                            $displayRank = $currentRank . ($isTie ? '.5' : '');

                                            // Build the table row
                                            $summary .= '<tr>';
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . $contestantLesbian['contestantSequence'] . '
                                                            </div>
                                                        </td>';

                                            // Loop through the overallScoresArray and add each score cell
                                            foreach ($contestantLesbian['overallScoresArray'] as $overallScorePrelim) {
                                                if (!empty($overallScorePrelim)) {
                                                    $summary .= '<td>
                                                                    <div class="small text-center">
                                                                        ' . $overallScorePrelim . '
                                                                    </div>
                                                                </td>';
                                                } else {
                                                    // Add an empty cell if overallScorePrelim is empty
                                                    $summary .= '<td>
                                                                    <div class="small text-center">&nbsp;</div>
                                                                </td>';
                                                }
                                            }

                                            // Add the overall average score cell
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . ($contestantLesbian['overallAverageScore'] ?? '&nbsp;') . '
                                                            </div>
                                                        </td>';

                                            // Add the rank cell with displayRank
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . $displayRank . '
                                                            </div>
                                                        </td>';

                                            $summary .= '</tr>';
                                        }

                                        $summary .= '
                                                </tbody>
                                            </table>    
                                        </div>';

                                        $summary .= '
                                        <div class="" align="center">
                                            <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\'data3\'], [\'selected\', \'ls-hd\'])">Print Summary</button>
                                        </div>';
                }
                
                if (!empty($contestantsByCategoryGay)){ 

//================================================= Gay Table Category =======================================================

                                        if ($isGeneral == 1) {  // Use double equal sign for comparison
                                            $summary .= '
                                                <h6 class="gy-hd mt-5 text-muted" align="center">General Summary</h6>
                                            ';
                                        } else {
                                            $summary .= '
                                                <h6 class="gy-hd mt-4 text-muted" align="center">Gay Category Summary</h6>
                                            ';
                                        }

                                        $summary .= '
                                        
                                        <div class="card-body table-responsive-sm">
                                            <table class="table table-hover" id="data4">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div class="small" align="center">
                                                                Candidate No.
                                                            </div>
                                                        </th>';

                                        // get event list
                                        $eventNameQuery = eventList;
                                        $stmt = $db->prepare($eventNameQuery);
                                        $stmt->execute();
                                        $resultEventName = $stmt->get_result();

                                        if ($resultEventName->num_rows > 0) {
                                        foreach ($resultEventName as $eventNameResult) {
                                            $eventNameHeader = $eventNameResult['event_name'];
                                            $summary .= '
                                                <th>
                                                    <div class="small ms-3 me-3" align="center">
                                                        ' . $eventNameHeader . ' (100)
                                                    </div>
                                                </th>';
                                        }
                                        }

                                        $summary .= '
                                                <th>
                                                    <div class="small" align="center">
                                                        Events General Average (100)
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="small" align="center">
                                                        Rank
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                                        $rankedContestants = [];

                                        foreach ($contestantsByCategoryGay as $eventContestantResult) {
                                            $contestantCode = htmlspecialchars($eventContestantResult['code']);
                                            $seqCons = htmlspecialchars($eventContestantResult['sequence']);
                                            $contestantName = htmlspecialchars($eventContestantResult['name']);
                                            $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                            $contestantSequence = $contestantGender ? $seqCons . ' - ' . $contestantGender : $seqCons;
                                            $judgeCountOverall = $fetchResultEventJudgeCountGay['judge_count'];

                                        $totalOverallAverageScore = 0;
                                        $prelimenaryOverallCriteriapercentage = 0;
                                        $averagePoint = 0;
                                        $overallScoresArray = [];

                                        foreach ($resultEventName as $eventJudgeResult) {
                                            $event_judge_code = $eventJudgeResult['code'];
                                            $eventOverallScoreQuery = overallSummaryOverallSummary;
                                            $stmt = $db->prepare($eventOverallScoreQuery);
                                            $stmt->bind_param("ss", $event_judge_code, $contestantCode);
                                            $stmt->execute();
                                            $resultEventOverallScore = $stmt->get_result();

                                            if ($resultEventOverallScore->num_rows > 0) {
                                                foreach ($resultEventOverallScore as $eventOverallScoreSummaryResult) {
                                                    $judgeScore = $eventOverallScoreSummaryResult['overallSummary'];
                                                    $eventCodeOverall = $eventOverallScoreSummaryResult['event_code'];

                                                    // get criteria percentage per event list
                                                    $eventCriteriaPercentageQuery = criteriaPercentageList;
                                                    $stmt = $db->prepare($eventCriteriaPercentageQuery);
                                                    $stmt->bind_param("s", $eventCodeOverall);
                                                    $stmt->execute();
                                                    $resultEventCriteriaPercentage = $stmt->get_result();
                                                    $fetchResultEventCriteriaPercentage = $resultEventCriteriaPercentage->fetch_assoc();

                                                    // get criteria percentage overall list
                                                    $eventCriteriaPercentageOverallQuery = criteriaPercentage;
                                                    $stmt = $db->prepare($eventCriteriaPercentageOverallQuery);
                                                    $stmt->execute();
                                                    $resultEventCriteriaPercentageOverall = $stmt->get_result();
                                                    $fetchResultEventCriteriaPercentageOverall = $resultEventCriteriaPercentageOverall->fetch_assoc();

                                                    $criteriaPercentageCount = $fetchResultEventCriteriaPercentage['percent'];
                                                    $eventtotalPossibleScore = $criteriaPercentageCount * $judgeCountOverall;

                                                    $overallSumOfCriteria = $fetchResultEventCriteriaPercentageOverall['cretiria_percent'];
                                                    $prelimenaryOverallCriteriapercentage = $overallSumOfCriteria * $judgeCountOverall;

                                                    if ($eventtotalPossibleScore > 0 && $prelimenaryOverallCriteriapercentage > 0) {
                                                        $totalOverallAverageScore += $judgeScore;
                                                        if($weightedScoring == 1){
                                                            $overallScore = number_format($judgeScore / $eventtotalPossibleScore * 100.0, 2);
                                                        } else {
                                                            $overallScore = number_format($judgeScore / $resultEventName->num_rows , 2);
                                                            $averagePoint += $overallScore;
                                                        }
                                                        $overallScoresArray[] = $overallScore;
                                                    } else {
                                                        // Add an empty entry if no score
                                                        $overallScoresArray[] = null;
                                                    }
                                                }
                                            } else {
                                                // If no results, add an empty entry
                                                $overallScoresArray[] = null;
                                            }
                                        }

                                        if($weightedScoring == 1){
                                            $overallAverageScore = number_format($totalOverallAverageScore / $prelimenaryOverallCriteriapercentage * 100.0, 2) . ' ';
                                        } else {
                                            $overallAverageScore = number_format($averagePoint / $judgeCountOverall, 2) . ' ';
                                        }

                                        $rankedContestants[] = [
                                            'contestantSequence' => $contestantSequence,
                                            'overallScoresArray' => $overallScoresArray,
                                            'overallAverageScore' => $overallAverageScore,
                                        ];
                                        }

                                        usort($rankedContestants, function($a, $b) {
                                            return $b['overallAverageScore'] <=> $a['overallAverageScore'];
                                        });

                                        // Initialize rank and summary container
                                        $rank = 1;
                                        $count = count($rankedContestants);

                                        for ($i = 0; $i < $count; $i++) {
                                            $contestantGay = $rankedContestants[$i];

                                            // If this candidate is tied with the previous candidate, reuse the previous candidate's base rank.
                                            if ($i > 0 && $contestantGay['overallAverageScore'] === $rankedContestants[$i - 1]['overallAverageScore']) {
                                                $currentRank = $previousRank;
                                            } else {
                                                $currentRank = $rank;
                                                $rank++; // Increment base rank for next unique candidate
                                            }
                                            $previousRank = $currentRank; // Store for the next iteration

                                            // Determine if this candidate is part of a tie group
                                            $isTie = false;
                                            if (
                                                ($i > 0 && $contestantGay['overallAverageScore'] === $rankedContestants[$i - 1]['overallAverageScore']) ||
                                                ($i < $count - 1 && $contestantGay['overallAverageScore'] === $rankedContestants[$i + 1]['overallAverageScore'])
                                            ) {
                                                $isTie = true;
                                            }

                                            // Prepare display rank with ".5" suffix if tied
                                            $displayRank = $currentRank . ($isTie ? '.5' : '');

                                            // Build the table row
                                            $summary .= '<tr>';
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . $contestantGay['contestantSequence'] . '
                                                            </div>
                                                        </td>';

                                            // Loop through the overallScoresArray and add each score cell
                                            foreach ($contestantGay['overallScoresArray'] as $overallScorePrelim) {
                                                if (!empty($overallScorePrelim)) {
                                                    $summary .= '<td>
                                                                    <div class="small text-center">
                                                                        ' . $overallScorePrelim . '
                                                                    </div>
                                                                </td>';
                                                } else {
                                                    // Add an empty cell if overallScorePrelim is empty
                                                    $summary .= '<td>
                                                                    <div class="small text-center">&nbsp;</div>
                                                                </td>';
                                                }
                                            }

                                            // Add the overall average score cell
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . ($contestantGay['overallAverageScore'] ?? '&nbsp;') . '
                                                            </div>
                                                        </td>';

                                            // Add the rank cell with displayRank
                                            $summary .= '<td>
                                                            <div class="small text-center">
                                                                ' . $displayRank . '
                                                            </div>
                                                        </td>';

                                            $summary .= '</tr>';
                                        }

                                        $summary .= '
                                                </tbody>
                                            </table>    
                                        </div>';

                                        $summary .= '
                                        <div class="" align="center">
                                            <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\'data4\'], [\'selected\', \'gy-hd\'])">Print Summary</button>
                                        </div>';
                }
                                    } else {
                                        $summary .= '
                                            <div class="mt-5" align="center">
                                                <h2 class="text-danger">No Contestants Found!</h2>
                                            </div>
                                        ';
                                    }

                                    echo $summary;
                                    ?>
                                        <div class="" align="center">
                                            <button class="btn btn-outline-success btn-sm mt-5" onclick="generateFinalButton()" data-finalist="1" >Generate Finalist</button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                    </div>
                    
                </main>
                <?php include "../include/footer.php";?>
            </div>
        </div>
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

                    // Optionally, close the new window after printing
                    printWindow.close();
                };
            }

        </script>
<script>
function generateFinalButton() {
    $.ajax({
            url: 'generateFinalist.php',
            method: 'POST',
            data: { action: 'generateFinalist' },
            success: function(response) {

                let timerInterval
                Swal.fire({
                title: response,
                icon: 'info',
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
</script>
        <script src="../js/jquery-3.6.1.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/sweetalert2.all.min.js"></script>
        <script src="../js/fontawesome.js" crossorigin="anonymous"></script>
        <script src="../js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="../js/simple-datatables@latest.js"></script>
        <script src="../js/tableDisplay.js"></script>
        
    </body>
</html>

<?php include "../include/footerSwal.php";?>

