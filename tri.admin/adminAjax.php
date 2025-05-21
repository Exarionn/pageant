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
    $contestantsByCategoryBothMaleFemale  = [];
    $contestantsByCategoryLesbian  = [];
    $contestantsByCategorygay  = [];
    $contestantsByCategoryBothGayLesbian =[];
    
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

    // Fetch male/female contestant by category list using parameterized query
    $eventContestantByCategoryMaleFemaleQuery = contestantListFemaleMaleBoth;
    $stmt = $db->prepare($eventContestantByCategoryMaleFemaleQuery);
    $stmt->execute();
    $resultEventContestantByMaleFemale = $stmt->get_result();

    if ($resultEventContestantByMaleFemale) {
        while ($row = $resultEventContestantByMaleFemale->fetch_assoc()) {
            $contestantsByCategoryBothMaleFemale[] = $row;
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

    // Fetch gay/lesbian contestant by category list using parameterized query
    $eventContestantByCategoryGayLesbianQuery = contestantListLgbtqBoth;
    $stmt = $db->prepare($eventContestantByCategoryGayLesbianQuery);
    $stmt->execute();
    $resultEventContestantByGayLesbian = $stmt->get_result();

    if ($resultEventContestantByGayLesbian) {
        while ($row = $resultEventContestantByGayLesbian->fetch_assoc()) {
            $contestantsByCategoryBothGayLesbian[] = $row;
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


$summary .='
                        <div class="tab-content border border-top-0 p-3" id="genderTabsContent">
                            <div class="tab-pane fade text-center show active" id="female" role="tabpanel" aria-labelledby="female-tab">
';
//================================================  table for category Female  =========================================================================================================
                        if (!empty($contestantsByCategoryFemale)) {

                            if ($conGeneral == 1) {  // Use double equal sign for comparison
                                $summary .= '
                                    <h6 class="fm-hd mt-5 text-muted" align="center">General Summary</h6>
                                ';
                            } else {
                                $summary .= '
                                    <h6 class="fm-hd mt-5 text-muted" align="center">Female Category Summary</h6>
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

                                            // get judge list
                                            $eventJudgeQuery = judgeByCategorySummaryListFemale;
                                            $stmt = $db->prepare($eventJudgeQuery);
                                            $stmt->execute();
                                            $resultEventJudge = $stmt->get_result();

                                            // Proceed to generate the output for whichever category returns data
                                            if ($resultEventJudge->num_rows > 0) {
                                                foreach ($resultEventJudge as $eventJudgeResult) {
                                                    $judgeNameHeader = $eventJudgeResult['name'];
                                                    $summary .= '
                                                        <th>
                                                            <div class="small ms-3 me-3" align="center">
                                                                '.$judgeNameHeader.'
                                                            </div>
                                                        </th>';
                                                }
                                            }

                                            $summary .= '
                                                            <th>
                                                                <div class="small text-success" align="center">
                                                                    Average - '.$fetchResultEvent['event_name'].'  
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

                                            // Initialize variables
                                            $rankedContestants = [];

                                            foreach ($contestantsByCategoryFemale as $eventContestantResult) {
                                                $contestantCode = htmlspecialchars($eventContestantResult['code']); 
                                                $seqCons = htmlspecialchars($eventContestantResult['sequence']);
                                                $contestantName = htmlspecialchars($eventContestantResult['name']);
                                                $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                                $contestantSequence = ($contestantGender != null || $isGeneral == 1) ? $seqCons : $seqCons . ' - ' . $contestantGender;

                                                // Reset total score for each contestant
                                                $totalScore = 0;

                                                // Initialize judge scores array
                                                $judgeScores = [];

                                                // Loop through each judge's score
                                                foreach ($resultEventJudge as $eventJudgeResult) {
                                                    $event_judge_code = $eventJudgeResult['code'];
                                                    $eventJudgeScoreQuery = judgeEventScoreList;
                                                    $stmt = $db->prepare($eventJudgeScoreQuery);
                                                    $stmt->bind_param("sss", $event_category, $contestantCode, $event_judge_code);
                                                    $stmt->execute();
                                                    $resultEventJudgeScore = $stmt->get_result();

                                                    $judgeScore = null;

                                                    if ($resultEventJudgeScore->num_rows > 0) {
                                                        // If the contestant has a score from the judge, sum it up
                                                        while ($row = $resultEventJudgeScore->fetch_assoc()) {
                                                            $judgeScore += htmlspecialchars($row['score']);
                                                        }
                                                    } else {
                                                        // If the contestant doesn't have a score from the judge, assign null
                                                        $judgeScore = null;
                                                    }

                                                    // Store judge score for the contestant
                                                    $judgeScores[$event_judge_code] = $judgeScore;

                                                    // Add judge score to the total score
                                                    $totalScore += $judgeScore;
                                                }

                                                // Calculate average score
                                                $criteriaPercentage = $fetchResultEventCriteriaPercentage['percent'];
                                                $totalPossibleScore = $criteriaPercentage * $resultEventJudge->num_rows;

                                                if($conWeightedScoring == 1){
                                                    $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $totalPossibleScore * 100.0), 2) : '';
                                                }else{
                                                    $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $resultEventJudge->num_rows), 2) : '';
                                                }

                                                
                                                // Store contestant details, judge scores, and average score for ranking
                                                $rankedContestants[] = [
                                                    'contestantSequence' => $contestantSequence,
                                                    'judgeScores' => $judgeScores,
                                                    'averageScore' => $averageScore,
                                                ];

                                            }

                                            // Sort contestants based on average score (descending order)
                                            usort($rankedContestants, function($a, $b) {
                                                return $b['averageScore'] <=> $a['averageScore'];
                                            });

                                            // Initialize rank variables and summary container
                                            $rank = 1;
                                            $summary .= ''; // if not already set
                                            $count = count($rankedContestants);

                                            for ($i = 0; $i < $count; $i++) {
                                                $contestantFemale = $rankedContestants[$i];

                                                // Determine the current candidate's base rank.
                                                if ($i > 0 && $contestantFemale['averageScore'] === $rankedContestants[$i - 1]['averageScore']) {
                                                    // If tied with the previous candidate, use the previous candidate's rank.
                                                    $currentRank = $previousRank;
                                                } else {
                                                    // Otherwise, assign the current rank and then increment the base rank.
                                                    $currentRank = $rank;
                                                    $rank++;
                                                }
                                                
                                                // Save current rank for next iteration.
                                                $previousRank = $currentRank;
                                                
                                                // Determine if this candidate is part of a tie group.
                                                // We check the previous or next candidate's score.
                                                $isTie = false;
                                                if (
                                                    ($i > 0 && $contestantFemale['averageScore'] === $rankedContestants[$i - 1]['averageScore']) ||
                                                    ($i < $count - 1 && $contestantFemale['averageScore'] === $rankedContestants[$i + 1]['averageScore'])
                                                ) {
                                                    $isTie = true;
                                                }
                                                
                                                // Prepare the display rank: append '.5' if part of a tie group.
                                                $displayRank = $currentRank . ($isTie ? '.5' : '');
                                                
                                                // Build the table row.
                                                $summary .= '
                                                    <tr>
                                                        <td>
                                                            <div class="small text-center">
                                                                ' . $contestantFemale['contestantSequence'] . '
                                                            </div>
                                                        </td>';
                                                
                                                // Loop through each judge score for this candidate.
                                                foreach ($contestantFemale['judgeScores'] as $judgeScore) {
                                                    $summary .= '
                                                        <td>
                                                            <div class="small text-center">
                                                                ' . $judgeScore . '
                                                            </div>
                                                        </td>';
                                                }
                                                
                                                $summary .= '
                                                        <td>
                                                            <div class="small text-center">
                                                                ' . $contestantFemale['averageScore'] . '
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="small text-center">
                                                                ' . $displayRank . '
                                                            </div>
                                                        </td>
                                                    </tr>';
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
$summary .='
                            </div>
                            <div class="tab-pane fade text-center" id="male" role="tabpanel" aria-labelledby="male-tab">
';
                        if (!empty($contestantsByCategoryMale)){
                            //--------------------------------------  table for category Male  -----------------------------------------------------------------------------------------------------------------------


                            if ($conGeneral == 1) {  // Use double equal sign for comparison
                                $summary .= '
                                    <h6 class="m-hd mt-5 text-muted" align="center">General Summary</h6>
                                ';
                            } else {
                                $summary .= '
                                    <h6 class="m-hd mt-4 text-muted" align="center">Male Category Summary </h6>
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

                                                // get judge list
                                                $eventJudgeQuery = judgeByCategorySummaryListMale;
                                                $stmt = $db->prepare($eventJudgeQuery);
                                                $stmt->execute();
                                                $resultEventJudge = $stmt->get_result();
                                                
                                                // Proceed to generate the output for whichever category returns data
                                                if ($resultEventJudge->num_rows > 0) {
                                                    foreach ($resultEventJudge as $eventJudgeResult) {
                                                        $judgeNameHeader = $eventJudgeResult['name'];
                                                        $summary .= '
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">
                                                                    '.$judgeNameHeader.'
                                                                </div>
                                                            </th>';
                                                    }
                                                }

                                                $summary .= '
                                                                <th>
                                                                    <div class="small text-success" align="center">
                                                                        Average - '.$fetchResultEvent['event_name'].'  
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

                                                // Initialize variables
                                                $rankedContestants = [];
                                                $rank = 1;

                                                foreach ($contestantsByCategoryMale as $eventContestantResult) {
                                                    $contestantCode = htmlspecialchars($eventContestantResult['code']); 
                                                    $seqCons = htmlspecialchars($eventContestantResult['sequence']);
                                                    $contestantName = htmlspecialchars($eventContestantResult['name']);
                                                    $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                                    $contestantSequence = ($contestantGender != null || $isGeneral == 1) ? $seqCons : $seqCons . ' - ' . $contestantGender;

                                                    // Reset total score for each contestant
                                                    $totalScore = 0;

                                                    // Initialize judge scores array
                                                    $judgeScores = [];

                                                    // Loop through each judge's score
                                                    foreach ($resultEventJudge as $eventJudgeResult) {
                                                        $event_judge_code = $eventJudgeResult['code'];
                                                        $eventJudgeScoreQuery = judgeEventScoreList;
                                                        $stmt = $db->prepare($eventJudgeScoreQuery);
                                                        $stmt->bind_param("sss", $event_category, $contestantCode, $event_judge_code);
                                                        $stmt->execute();
                                                        $resultEventJudgeScore = $stmt->get_result();

                                                        $judgeScore = null;

                                                        if ($resultEventJudgeScore->num_rows > 0) {
                                                            // If the contestant has a score from the judge, sum it up
                                                            while ($row = $resultEventJudgeScore->fetch_assoc()) {
                                                                $judgeScore += htmlspecialchars($row['score']);
                                                            }
                                                        } else {
                                                            // If the contestant doesn't have a score from the judge, assign null
                                                            $judgeScore = null;
                                                        }

                                                        // Store judge score for the contestant
                                                        $judgeScores[$event_judge_code] = $judgeScore;

                                                        // Add judge score to the total score
                                                        $totalScore += $judgeScore;
                                                    }

                                                    // Calculate average score
                                                    $criteriaPercentage = $fetchResultEventCriteriaPercentage['percent'];
                                                    $totalPossibleScore = $criteriaPercentage * $resultEventJudge->num_rows;
                                                    
                                                    if($conWeightedScoring == 1){
                                                        $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $totalPossibleScore * 100.0), 2) : '';
                                                    }else{
                                                        $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $resultEventJudge->num_rows), 2) : '';
                                                    }

                                                    // Store contestant details, judge scores, and average score for ranking
                                                    $rankedContestants[] = [
                                                        'contestantSequence' => $contestantSequence,
                                                        'judgeScores' => $judgeScores,
                                                        'averageScore' => $averageScore,
                                                    ];

                                                }

                                                // Sort contestants based on average score (descending order)
                                                usort($rankedContestants, function($a, $b) {
                                                    return $b['averageScore'] <=> $a['averageScore'];
                                                });

                                                // Initialize rank variables and summary container
                                                $rank = 1;
                                                $summary .= ''; // if not already set
                                                $count = count($rankedContestants);

                                                for ($i = 0; $i < $count; $i++) {
                                                    $contestantMale = $rankedContestants[$i];

                                                    // Determine the current candidate's base rank.
                                                    if ($i > 0 && $contestantMale['averageScore'] === $rankedContestants[$i - 1]['averageScore']) {
                                                        // If tied with the previous candidate, use the previous candidate's rank.
                                                        $currentRank = $previousRank;
                                                    } else {
                                                        // Otherwise, assign the current rank and then increment the base rank.
                                                        $currentRank = $rank;
                                                        $rank++;
                                                    }
                                                    
                                                    // Save current rank for next iteration.
                                                    $previousRank = $currentRank;
                                                    
                                                    // Determine if this candidate is part of a tie group.
                                                    // We check the previous or next candidate's score.
                                                    $isTie = false;
                                                    if (
                                                        ($i > 0 && $contestantMale['averageScore'] === $rankedContestants[$i - 1]['averageScore']) ||
                                                        ($i < $count - 1 && $contestantMale['averageScore'] === $rankedContestants[$i + 1]['averageScore'])
                                                    ) {
                                                        $isTie = true;
                                                    }
                                                    
                                                    // Prepare the display rank: append '.5' if part of a tie group.
                                                    $displayRank = $currentRank . ($isTie ? '.5' : '');
                                                    
                                                    // Build the table row.
                                                    $summary .= '
                                                        <tr>
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $contestantMale['contestantSequence'] . '
                                                                </div>
                                                            </td>';
                                                    
                                                    // Loop through each judge score for this candidate.
                                                    foreach ($contestantMale['judgeScores'] as $judgeScore) {
                                                        $summary .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $judgeScore . '
                                                                </div>
                                                            </td>';
                                                    }
                                                    
                                                    $summary .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $contestantMale['averageScore'] . '
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $displayRank . '
                                                                </div>
                                                            </td>
                                                        </tr>';
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
$summary .='
                            </div>
                            <div class="tab-pane fade text-center" id="both-mf" role="tabpanel" aria-labelledby="both-mf-tab">
';
                        if (!empty($contestantsByCategoryBothMaleFemale)){
                            //--------------------------------------  table for category Male/Female  -----------------------------------------------------------------------------------------------------------------------


                            if ($conGeneral == 1) {  // Use double equal sign for comparison
                                $summary .= '
                                    <h6 class="mf-hd mt-5 text-muted" align="center">General Summary</h6>
                                ';
                            } else {
                                $summary .= '
                                    <h6 class="mf-hd mt-4 text-muted" align="center">Male/Female Category Summary </h6>
                                ';
                            }
                                $summary .= '
                                                
                                                <div class="card-body table-responsive-sm">
                                                    <table class="table table-hover" id="data5">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <div class="small" align="center">
                                                                        Candidate No.
                                                                    </div>
                                                                </th>';

                                                // get judge list
                                                $eventJudgeQuery = judgeByCategorySummaryListMaleFemale;
                                                $stmt = $db->prepare($eventJudgeQuery);
                                                $stmt->execute();
                                                $resultEventJudge = $stmt->get_result();
                                                
                                                // Proceed to generate the output for whichever category returns data
                                                if ($resultEventJudge->num_rows > 0) {
                                                    foreach ($resultEventJudge as $eventJudgeResult) {
                                                        $judgeNameHeader = $eventJudgeResult['name'];
                                                        $summary .= '
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">
                                                                    '.$judgeNameHeader.'
                                                                </div>
                                                            </th>';
                                                    }
                                                }

                                                $summary .= '
                                                                <th>
                                                                    <div class="small text-success" align="center">
                                                                        Average - '.$fetchResultEvent['event_name'].'  
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

                                                // Initialize variables
                                                $rankedContestants = [];
                                                $rank = 1;

                                                foreach ($contestantsByCategoryBothMaleFemale as $eventContestantResult) {
                                                    $contestantCode = htmlspecialchars($eventContestantResult['code']); 
                                                    $seqCons = htmlspecialchars($eventContestantResult['sequence']);
                                                    $contestantName = htmlspecialchars($eventContestantResult['name']);
                                                    $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                                    $contestantSequence = ($contestantGender != null || $isGeneral == 1) ? $seqCons : $seqCons . ' - ' . $contestantGender;

                                                    // Reset total score for each contestant
                                                    $totalScore = 0;

                                                    // Initialize judge scores array
                                                    $judgeScores = [];

                                                    // Loop through each judge's score
                                                    foreach ($resultEventJudge as $eventJudgeResult) {
                                                        $event_judge_code = $eventJudgeResult['code'];
                                                        $eventJudgeScoreQuery = judgeEventScoreList;
                                                        $stmt = $db->prepare($eventJudgeScoreQuery);
                                                        $stmt->bind_param("sss", $event_category, $contestantCode, $event_judge_code);
                                                        $stmt->execute();
                                                        $resultEventJudgeScore = $stmt->get_result();

                                                        $judgeScore = null;

                                                        if ($resultEventJudgeScore->num_rows > 0) {
                                                            // If the contestant has a score from the judge, sum it up
                                                            while ($row = $resultEventJudgeScore->fetch_assoc()) {
                                                                $judgeScore += htmlspecialchars($row['score']);
                                                            }
                                                        } else {
                                                            // If the contestant doesn't have a score from the judge, assign null
                                                            $judgeScore = null;
                                                        }

                                                        // Store judge score for the contestant
                                                        $judgeScores[$event_judge_code] = $judgeScore;

                                                        // Add judge score to the total score
                                                        $totalScore += $judgeScore;
                                                    }

                                                    // Calculate average score
                                                    $criteriaPercentage = $fetchResultEventCriteriaPercentage['percent'];
                                                    $totalPossibleScore = $criteriaPercentage * $resultEventJudge->num_rows;
                                                    
                                                    if($conWeightedScoring == 1){
                                                        $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $totalPossibleScore * 100.0), 2) : '';
                                                    }else{
                                                        $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $resultEventJudge->num_rows), 2) : '';
                                                    }

                                                    // Store contestant details, judge scores, and average score for ranking
                                                    $rankedContestants[] = [
                                                        'contestantSequence' => $contestantSequence,
                                                        'judgeScores' => $judgeScores,
                                                        'averageScore' => $averageScore,
                                                    ];

                                                }

                                                // Sort contestants based on average score (descending order)
                                                usort($rankedContestants, function($a, $b) {
                                                    return $b['averageScore'] <=> $a['averageScore'];
                                                });

                                                // Initialize rank variables and summary container
                                                $rank = 1;
                                                $summary .= ''; // if not already set
                                                $count = count($rankedContestants);

                                                for ($i = 0; $i < $count; $i++) {
                                                    $contestantMaleFemale = $rankedContestants[$i];

                                                    // Determine the current candidate's base rank.
                                                    if ($i > 0 && $contestantMaleFemale['averageScore'] === $rankedContestants[$i - 1]['averageScore']) {
                                                        // If tied with the previous candidate, use the previous candidate's rank.
                                                        $currentRank = $previousRank;
                                                    } else {
                                                        // Otherwise, assign the current rank and then increment the base rank.
                                                        $currentRank = $rank;
                                                        $rank++;
                                                    }
                                                    
                                                    // Save current rank for next iteration.
                                                    $previousRank = $currentRank;
                                                    
                                                    // Determine if this candidate is part of a tie group.
                                                    // We check the previous or next candidate's score.
                                                    $isTie = false;
                                                    if (
                                                        ($i > 0 && $contestantMaleFemale['averageScore'] === $rankedContestants[$i - 1]['averageScore']) ||
                                                        ($i < $count - 1 && $contestantMaleFemale['averageScore'] === $rankedContestants[$i + 1]['averageScore'])
                                                    ) {
                                                        $isTie = true;
                                                    }
                                                    
                                                    // Prepare the display rank: append '.5' if part of a tie group.
                                                    $displayRank = $currentRank . ($isTie ? '.5' : '');
                                                    
                                                    // Build the table row.
                                                    $summary .= '
                                                        <tr>
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $contestantMaleFemale['contestantSequence'] . '
                                                                </div>
                                                            </td>';
                                                    
                                                    // Loop through each judge score for this candidate.
                                                    foreach ($contestantMaleFemale['judgeScores'] as $judgeScore) {
                                                        $summary .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $judgeScore . '
                                                                </div>
                                                            </td>';
                                                    }
                                                    
                                                    $summary .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $contestantMaleFemale['averageScore'] . '
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $displayRank . '
                                                                </div>
                                                            </td>
                                                        </tr>';
                                                }

                                                $summary .= '
                                                        </tbody>
                                                    </table>
                                                </div>';

                                            $summary .= '
                                            <div class="" align="center">
                                                <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\'data5\'], [\'selected\', \'mf-hd\'])">Print Summary</button>
                                            </div>';
                                    }
$summary .='
                            </div>
                            <div class="tab-pane fade text-center" id="gay" role="tabpanel" aria-labelledby="gay-tab">
';
                        if (!empty($contestantsByCategoryLesbian)){
                            //-----------------------------------  table for category Lesbian  --------------------------------------------------------------------------------------------------------------------------

                            if ($conGeneral == 1) {  // Use double equal sign for comparison
                                $summary .= '
                                    <h6 class="ls-hd mt-5 text-muted" align="center">General Summary</h6>
                                ';
                            } else {
                                $summary .= '
                                    <h6 class="ls-hd mt-4 text-muted" align="center">Lesbian Category Summary </h6>
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

                                                // get judge list
                                                $eventJudgeQuery = judgeByCategorySummaryListLesbian;
                                                $stmt = $db->prepare($eventJudgeQuery);
                                                $stmt->execute();
                                                $resultEventJudge = $stmt->get_result();
                                                
                                                // Proceed to generate the output for whichever category returns data
                                                if ($resultEventJudge->num_rows > 0) {
                                                    foreach ($resultEventJudge as $eventJudgeResult) {
                                                        $judgeNameHeader = $eventJudgeResult['name'];
                                                        $summary .= '
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">
                                                                    '.$judgeNameHeader.'
                                                                </div>
                                                            </th>';
                                                    }
                                                }

                                                $summary .= '
                                                                <th>
                                                                    <div class="small text-success" align="center">
                                                                        Average - '.$fetchResultEvent['event_name'].'
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

                                                // Initialize variables
                                                $rankedContestants = [];
                                                $rank = 1;

                                                foreach ($contestantsByCategoryLesbian as $eventContestantResult) {
                                                    $contestantCode = htmlspecialchars($eventContestantResult['code']); 
                                                    $seqCons = htmlspecialchars($eventContestantResult['sequence']);
                                                    $contestantName = htmlspecialchars($eventContestantResult['name']);
                                                    $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                                    $contestantSequence = ($contestantGender != null || $isGeneral == 1) ? $seqCons : $seqCons . ' - ' . $contestantGender;

                                                    // Reset total score for each contestant
                                                    $totalScore = 0;

                                                    // Initialize judge scores array
                                                    $judgeScores = [];

                                                    // Loop through each judge's score
                                                    foreach ($resultEventJudge as $eventJudgeResult) {
                                                        $event_judge_code = $eventJudgeResult['code'];
                                                        $eventJudgeScoreQuery = judgeEventScoreList;
                                                        $stmt = $db->prepare($eventJudgeScoreQuery);
                                                        $stmt->bind_param("sss", $event_category, $contestantCode, $event_judge_code);
                                                        $stmt->execute();
                                                        $resultEventJudgeScore = $stmt->get_result();

                                                        $judgeScore = null;

                                                        if ($resultEventJudgeScore->num_rows > 0) {
                                                            // If the contestant has a score from the judge, sum it up
                                                            while ($row = $resultEventJudgeScore->fetch_assoc()) {
                                                                $judgeScore += htmlspecialchars($row['score']);
                                                            }
                                                        } else {
                                                            // If the contestant doesn't have a score from the judge, assign null
                                                            $judgeScore = null;
                                                        }

                                                        // Store judge score for the contestant
                                                        $judgeScores[$event_judge_code] = $judgeScore;

                                                        // Add judge score to the total score
                                                        $totalScore += $judgeScore;
                                                    }

                                                    // Calculate average score
                                                    $criteriaPercentage = $fetchResultEventCriteriaPercentage['percent'];
                                                    $totalPossibleScore = $criteriaPercentage * $resultEventJudge->num_rows;
                                                    if($conWeightedScoring == 1){
                                                        $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $totalPossibleScore * 100.0), 2) : '';
                                                    }else{
                                                        $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $resultEventJudge->num_rows), 2) : '';
                                                    }

                                                    // Store contestant details, judge scores, and average score for ranking
                                                    $rankedContestants[] = [
                                                        'contestantSequence' => $contestantSequence,
                                                        'judgeScores' => $judgeScores,
                                                        'averageScore' => $averageScore,
                                                    ];

                                                }

                                                // Sort contestants based on average score (descending order)
                                                usort($rankedContestants, function($a, $b) {
                                                    return $b['averageScore'] <=> $a['averageScore'];
                                                });

                                                // Initialize rank variables and summary container
                                                $rank = 1;
                                                $summary .= ''; // if not already set
                                                $count = count($rankedContestants);

                                                for ($i = 0; $i < $count; $i++) {
                                                    $contestantLesbian = $rankedContestants[$i];

                                                    // Determine the current candidate's base rank.
                                                    if ($i > 0 && $contestantLesbian['averageScore'] === $rankedContestants[$i - 1]['averageScore']) {
                                                        // If tied with the previous candidate, use the previous candidate's rank.
                                                        $currentRank = $previousRank;
                                                    } else {
                                                        // Otherwise, assign the current rank and then increment the base rank.
                                                        $currentRank = $rank;
                                                        $rank++;
                                                    }
                                                    
                                                    // Save current rank for next iteration.
                                                    $previousRank = $currentRank;
                                                    
                                                    // Determine if this candidate is part of a tie group.
                                                    // We check the previous or next candidate's score.
                                                    $isTie = false;
                                                    if (
                                                        ($i > 0 && $contestantLesbian['averageScore'] === $rankedContestants[$i - 1]['averageScore']) ||
                                                        ($i < $count - 1 && $contestantLesbian['averageScore'] === $rankedContestants[$i + 1]['averageScore'])
                                                    ) {
                                                        $isTie = true;
                                                    }
                                                    
                                                    // Prepare the display rank: append '.5' if part of a tie group.
                                                    $displayRank = $currentRank . ($isTie ? '.5' : '');
                                                    
                                                    // Build the table row.
                                                    $summary .= '
                                                        <tr>
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $contestantLesbian['contestantSequence'] . '
                                                                </div>
                                                            </td>';
                                                    
                                                    // Loop through each judge score for this candidate.
                                                    foreach ($contestantLesbian['judgeScores'] as $judgeScore) {
                                                        $summary .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $judgeScore . '
                                                                </div>
                                                            </td>';
                                                    }
                                                    
                                                    $summary .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $contestantLesbian['averageScore'] . '
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $displayRank . '
                                                                </div>
                                                            </td>
                                                        </tr>';
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
$summary .='
                            </div>
                            <div class="tab-pane fade text-center" id="lesbian" role="tabpanel" aria-labelledby="lesbian-tab">
';
                        if (!empty($contestantsByCategoryGay)){
                            //=============================================== LGBTQ Gay table =================================================================================================
                                    
                            //table for category gay

                            if ($conGeneral == 1) {  // Use double equal sign for comparison
                                $summary .= '
                                    <h6 class="gy-hd mt-5 text-muted" align="center">General Summary</h6>
                                ';
                            } else {
                                $summary .= '
                                    <h6 class="gy-hd mt-4 text-muted" align="center">Gay Category Summary </h6>
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

                                                // get judge list
                                                $eventJudgeQuery = judgeByCategorySummaryListGay;
                                                $stmt = $db->prepare($eventJudgeQuery);
                                                $stmt->execute();
                                                $resultEventJudge = $stmt->get_result();
                                                
                                                // Proceed to generate the output for whichever category returns data
                                                if ($resultEventJudge->num_rows > 0) {
                                                    foreach ($resultEventJudge as $eventJudgeResult) {
                                                        $judgeNameHeader = $eventJudgeResult['name'];
                                                        $summary .= '
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">
                                                                    '.$judgeNameHeader.'
                                                                </div>
                                                            </th>';
                                                    }
                                                }

                                                $summary .= '
                                                                <th>
                                                                    <div class="small text-success" align="center">
                                                                        Average - '.$fetchResultEvent['event_name'].'
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

                                                // Initialize variables
                                                $rankedContestants = [];
                                                $rank = 1;

                                                foreach ($contestantsByCategoryGay as $eventContestantResult) {
                                                    $contestantCode = htmlspecialchars($eventContestantResult['code']); 
                                                    $seqCons = htmlspecialchars($eventContestantResult['sequence']);
                                                    $contestantName = htmlspecialchars($eventContestantResult['name']);
                                                    $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                                    $contestantSequence = ($contestantGender != null || $isGeneral == 1) ? $seqCons : $seqCons . ' - ' . $contestantGender;

                                                    // Reset total score for each contestant
                                                    $totalScore = 0;

                                                    // Initialize judge scores array
                                                    $judgeScores = [];

                                                    // Loop through each judge's score
                                                    foreach ($resultEventJudge as $eventJudgeResult) {
                                                        $event_judge_code = $eventJudgeResult['code'];
                                                        $eventJudgeScoreQuery = judgeEventScoreList;
                                                        $stmt = $db->prepare($eventJudgeScoreQuery);
                                                        $stmt->bind_param("sss", $event_category, $contestantCode, $event_judge_code);
                                                        $stmt->execute();
                                                        $resultEventJudgeScore = $stmt->get_result();

                                                        $judgeScore = null;

                                                        if ($resultEventJudgeScore->num_rows > 0) {
                                                            // If the contestant has a score from the judge, sum it up
                                                            while ($row = $resultEventJudgeScore->fetch_assoc()) {
                                                                $judgeScore += htmlspecialchars($row['score']);
                                                            }
                                                        } else {
                                                            // If the contestant doesn't have a score from the judge, assign null
                                                            $judgeScore = null;
                                                        }

                                                        // Store judge score for the contestant
                                                        $judgeScores[$event_judge_code] = $judgeScore;

                                                        // Add judge score to the total score
                                                        $totalScore += $judgeScore;
                                                    }

                                                    // Calculate average score
                                                    $criteriaPercentage = $fetchResultEventCriteriaPercentage['percent'];
                                                    $totalPossibleScore = $criteriaPercentage * $resultEventJudge->num_rows;
                                                    if($conWeightedScoring == 1){
                                                        $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $totalPossibleScore * 100.0), 2) : '';
                                                    }else{
                                                        $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $resultEventJudge->num_rows), 2) : '';
                                                    }

                                                    // Store contestant details, judge scores, and average score for ranking
                                                    $rankedContestants[] = [
                                                        'contestantSequence' => $contestantSequence,
                                                        'judgeScores' => $judgeScores,
                                                        'averageScore' => $averageScore,
                                                    ];

                                                }

                                                // Sort contestants based on average score (descending order)
                                                usort($rankedContestants, function($a, $b) {
                                                    return $b['averageScore'] <=> $a['averageScore'];
                                                });

                                                // Initialize rank variables and summary container
                                                $rank = 1;
                                                $summary .= ''; // if not already set
                                                $count = count($rankedContestants);

                                                for ($i = 0; $i < $count; $i++) {
                                                    $contestantGay = $rankedContestants[$i];

                                                    // Determine the current candidate's base rank.
                                                    if ($i > 0 && $contestantGay['averageScore'] === $rankedContestants[$i - 1]['averageScore']) {
                                                        // If tied with the previous candidate, use the previous candidate's rank.
                                                        $currentRank = $previousRank;
                                                    } else {
                                                        // Otherwise, assign the current rank and then increment the base rank.
                                                        $currentRank = $rank;
                                                        $rank++;
                                                    }
                                                    
                                                    // Save current rank for next iteration.
                                                    $previousRank = $currentRank;
                                                    
                                                    // Determine if this candidate is part of a tie group.
                                                    // We check the previous or next candidate's score.
                                                    $isTie = false;
                                                    if (
                                                        ($i > 0 && $contestantGay['averageScore'] === $rankedContestants[$i - 1]['averageScore']) ||
                                                        ($i < $count - 1 && $contestantGay['averageScore'] === $rankedContestants[$i + 1]['averageScore'])
                                                    ) {
                                                        $isTie = true;
                                                    }
                                                    
                                                    // Prepare the display rank: append '.5' if part of a tie group.
                                                    $displayRank = $currentRank . ($isTie ? '.5' : '');
                                                    
                                                    // Build the table row.
                                                    $summary .= '
                                                        <tr>
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $contestantGay['contestantSequence'] . '
                                                                </div>
                                                            </td>';
                                                    
                                                    // Loop through each judge score for this candidate.
                                                    foreach ($contestantGay['judgeScores'] as $judgeScore) {
                                                        $summary .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $judgeScore . '
                                                                </div>
                                                            </td>';
                                                    }
                                                    
                                                    $summary .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $contestantGay['averageScore'] . '
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $displayRank . '
                                                                </div>
                                                            </td>
                                                        </tr>';
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
$summary .='
                            </div>
                            <div class="tab-pane fade text-center" id="both-gl" role="tabpanel" aria-labelledby="both-gl-tab">
';
                        if (!empty($contestantsByCategoryBothGayLesbian)){
                            //=============================================== LGBTQ Gay table =================================================================================================
                                    
                            //table for category gay

                            if ($conGeneral == 1) {  // Use double equal sign for comparison
                                $summary .= '
                                    <h6 class="gyls-hd mt-5 text-muted" align="center">General Summary</h6>
                                ';
                            } else {
                                $summary .= '
                                    <h6 class="gyls-hd mt-4 text-muted" align="center">Gay/Lesbian Category Summary </h6>
                                ';
                            }

                                $summary .= '
                                                
                                                <div class="card-body table-responsive-sm">
                                                    <table class="table table-hover" id="data6">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <div class="small" align="center">
                                                                        Candidate No.
                                                                    </div>
                                                                </th>';

                                                // get judge list
                                                $eventJudgeQuery = judgeByCategorySummaryListGayLesbian;
                                                $stmt = $db->prepare($eventJudgeQuery);
                                                $stmt->execute();
                                                $resultEventJudge = $stmt->get_result();
                                                
                                                // Proceed to generate the output for whichever category returns data
                                                if ($resultEventJudge->num_rows > 0) {
                                                    foreach ($resultEventJudge as $eventJudgeResult) {
                                                        $judgeNameHeader = $eventJudgeResult['name'];
                                                        $summary .= '
                                                            <th>
                                                                <div class="small ms-3 me-3" align="center">
                                                                    '.$judgeNameHeader.'
                                                                </div>
                                                            </th>';
                                                    }
                                                }

                                                $summary .= '
                                                                <th>
                                                                    <div class="small text-success" align="center">
                                                                        Average - '.$fetchResultEvent['event_name'].'
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

                                                // Initialize variables
                                                $rankedContestants = [];
                                                $rank = 1;

                                                foreach ($contestantsByCategoryBothGayLesbian as $eventContestantResult) {
                                                    $contestantCode = htmlspecialchars($eventContestantResult['code']); 
                                                    $seqCons = htmlspecialchars($eventContestantResult['sequence']);
                                                    $contestantName = htmlspecialchars($eventContestantResult['name']);
                                                    $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                                                    $contestantSequence = ($contestantGender != null || $isGeneral == 1) ? $seqCons : $seqCons . ' - ' . $contestantGender;

                                                    // Reset total score for each contestant
                                                    $totalScore = 0;

                                                    // Initialize judge scores array
                                                    $judgeScores = [];

                                                    // Loop through each judge's score
                                                    foreach ($resultEventJudge as $eventJudgeResult) {
                                                        $event_judge_code = $eventJudgeResult['code'];
                                                        $eventJudgeScoreQuery = judgeEventScoreList;
                                                        $stmt = $db->prepare($eventJudgeScoreQuery);
                                                        $stmt->bind_param("sss", $event_category, $contestantCode, $event_judge_code);
                                                        $stmt->execute();
                                                        $resultEventJudgeScore = $stmt->get_result();

                                                        $judgeScore = null;

                                                        if ($resultEventJudgeScore->num_rows > 0) {
                                                            // If the contestant has a score from the judge, sum it up
                                                            while ($row = $resultEventJudgeScore->fetch_assoc()) {
                                                                $judgeScore += htmlspecialchars($row['score']);
                                                            }
                                                        } else {
                                                            // If the contestant doesn't have a score from the judge, assign null
                                                            $judgeScore = null;
                                                        }

                                                        // Store judge score for the contestant
                                                        $judgeScores[$event_judge_code] = $judgeScore;

                                                        // Add judge score to the total score
                                                        $totalScore += $judgeScore;
                                                    }

                                                    // Calculate average score
                                                    $criteriaPercentage = $fetchResultEventCriteriaPercentage['percent'];
                                                    $totalPossibleScore = $criteriaPercentage * $resultEventJudge->num_rows;
                                                    if($conWeightedScoring == 1){
                                                        $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $totalPossibleScore * 100.0), 2) : '';
                                                    }else{
                                                        $averageScore = ($totalPossibleScore != null) ? number_format(($totalScore / $resultEventJudge->num_rows), 2) : '';
                                                    }

                                                    // Store contestant details, judge scores, and average score for ranking
                                                    $rankedContestants[] = [
                                                        'contestantSequence' => $contestantSequence,
                                                        'judgeScores' => $judgeScores,
                                                        'averageScore' => $averageScore,
                                                    ];

                                                }

                                                // Sort contestants based on average score (descending order)
                                                usort($rankedContestants, function($a, $b) {
                                                    return $b['averageScore'] <=> $a['averageScore'];
                                                });

                                                // Initialize rank variables and summary container
                                                $rank = 1;
                                                $summary .= ''; // if not already set
                                                $count = count($rankedContestants);

                                                for ($i = 0; $i < $count; $i++) {
                                                    $contestantGayLesbian = $rankedContestants[$i];

                                                    // Determine the current candidate's base rank.
                                                    if ($i > 0 && $contestantGayLesbian['averageScore'] === $rankedContestants[$i - 1]['averageScore']) {
                                                        // If tied with the previous candidate, use the previous candidate's rank.
                                                        $currentRank = $previousRank;
                                                    } else {
                                                        // Otherwise, assign the current rank and then increment the base rank.
                                                        $currentRank = $rank;
                                                        $rank++;
                                                    }
                                                    
                                                    // Save current rank for next iteration.
                                                    $previousRank = $currentRank;
                                                    
                                                    // Determine if this candidate is part of a tie group.
                                                    // We check the previous or next candidate's score.
                                                    $isTie = false;
                                                    if (
                                                        ($i > 0 && $contestantGayLesbian['averageScore'] === $rankedContestants[$i - 1]['averageScore']) ||
                                                        ($i < $count - 1 && $contestantGayLesbian['averageScore'] === $rankedContestants[$i + 1]['averageScore'])
                                                    ) {
                                                        $isTie = true;
                                                    }
                                                    
                                                    // Prepare the display rank: append '.5' if part of a tie group.
                                                    $displayRank = $currentRank . ($isTie ? '.5' : '');
                                                    
                                                    // Build the table row.
                                                    $summary .= '
                                                        <tr>
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $contestantGayLesbian['contestantSequence'] . '
                                                                </div>
                                                            </td>';
                                                    
                                                    // Loop through each judge score for this candidate.
                                                    foreach ($contestantGayLesbian['judgeScores'] as $judgeScore) {
                                                        $summary .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $judgeScore . '
                                                                </div>
                                                            </td>';
                                                    }
                                                    
                                                    $summary .= '
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $contestantGayLesbian['averageScore'] . '
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="small text-center">
                                                                    ' . $displayRank . '
                                                                </div>
                                                            </td>
                                                        </tr>';
                                                }

                                                $summary .= '
                                                        </tbody>
                                                    </table>
                                                </div>';

                                            $summary .= '
                                            <div class="" align="center">
                                                <button class="btn btn-outline-primary btn-sm rounded" onclick="printTables([\'data6\'], [\'selected\', \'gyls-hd\'])">Print Summary</button>
                                            </div>';
                                    }
$summary .='
                            </div>
                        </div>
';

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
