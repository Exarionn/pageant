<?php
require '../include/connector/dbconn.php';

include "../include/generatedKey.php"; 
include "../include/query.php"; 

if(isset($_POST['event_categorySpecial'])) {
    $event_category = $_POST['event_categorySpecial'];
    $event_judge = $_POST['event_judgeSpecial']; // not used directly; judges fetched per category
    $conGeneral = $_POST['conGeneralSpecial'];
    $conWeightedScoring = $_POST['conWeightedScoringSpecial'];
    

    // Initialize an array to hold contestant data
    $contestantsByCategoryFemale  = [];
    $contestantsByCategoryMale  = [];
    $contestantsByCategoryLesbian  = [];
    $contestantsByCategoryGay  = [];
    $contestantsByCategoryBothMF = [];
    $contestantsByCategoryBothLGBTQ = [];
    

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
        while ($row = $resultEventContestantByGay->fetch_assoc()) { $contestantsByCategoryGay[] = $row; }
    } else {
        // Handle database query error without revealing sensitive information
        echo "Error fetching contestant list";
        exit;
    }

    // Fetch Both Male & Female contestants
    $stmt = $db->prepare(contestantListBothMF);
    $stmt->execute();
    $resBothMF = $stmt->get_result();
    if ($resBothMF) { while ($row = $resBothMF->fetch_assoc()) { $contestantsByCategoryBothMF[] = $row; } }

    // Fetch Both LGBTQ contestants
    $stmt = $db->prepare(contestantListBothLGBTQ);
    $stmt->execute();
    $resBothLGBTQ = $stmt->get_result();
    if ($resBothLGBTQ) { while ($row = $resBothLGBTQ->fetch_assoc()) { $contestantsByCategoryBothLGBTQ[] = $row; } }

    // get criteria percentage list
    $eventCriteriaPercentageQuery = criteriaPercentageList;
    $stmt = $db->prepare($eventCriteriaPercentageQuery);
    $stmt->bind_param("s", $event_category);
    $stmt->execute();
    $resultEventCriteriaPercentage = $stmt->get_result();
    $fetchResultEventCriteriaPercentage = $resultEventCriteriaPercentage->fetch_assoc();

    // get Event list (to display event name in headers)
    $eventQuery = eventListSpecialList;
    $stmt = $db->prepare($eventQuery);
    $stmt->bind_param("s", $event_category);
    $stmt->execute();
    $resultEvent = $stmt->get_result();
    $fetchResultEvent = $resultEvent ? $resultEvent->fetch_assoc() : null;

    // page header
    $summary = '';
    if ($fetchResultEvent != NULL){
        $summary .= '<h3 class="mt-4 selected text-muted" align="center">'.$fetchResultEvent['event_name'].'</h3>';
    } else {
        $summary .= '<h3 class="mt-4 text-muted" align="center"></h3>';
    }
    
    // Helper to render a category table (small h6 summary like adminAjax)
    $renderCategory = function(array $contestantsArr, string $judgeQuery, string $tableId, string $hdrClass, string $categoryLabel) use ($db, $event_category, $fetchResultEventCriteriaPercentage, $fetchResultEvent, $conWeightedScoring, $conGeneral) {
        if (empty($contestantsArr)) { return ''; }

        // Header block (h6 only)
        $html = '';
        if ($conGeneral == 1) {
            $html .= '             <h6 class="'.$hdrClass.' mt-5 text-muted" align="center">General Summary</h6>         ';
        } else {
            $html .= '             <h6 class="'.$hdrClass.' mt-4 text-muted" align="center">'.$categoryLabel.' Category Summary</h6>         ';
        }

        // Fetch judges once and materialize into an array for reuse
        $stmtJ = $db->prepare($judgeQuery);
        $stmtJ->execute();
        $resultJ = $stmtJ->get_result();
        $judges = [];
        if ($resultJ && $resultJ->num_rows > 0) {
            while ($jr = $resultJ->fetch_assoc()) { $judges[] = $jr; }
        }

        $avgLabel = ($conWeightedScoring == 1 ? 'Average (%) - ' : 'Average (pts) - ') . ($fetchResultEvent ? $fetchResultEvent['event_name'] : '');

    $html .= '             <div class="card-body table-responsive-sm">                 <table class="table table-hover" id="'.$tableId.'">                     <thead>                         <tr>                             <th>                                 <div class="small" align="center">                                     Candidate No.                                 </div>                             </th>';
        foreach ($judges as $j) {
            $html .= '                             <th data-type="number">                                 <div class="small ms-3 me-3" align="center">'.htmlspecialchars($j['name']).'</div>                             </th>';
        }
    $html .= '                             <th data-type="number">                                 <div class="small text-success" align="center">                                     '.$avgLabel.'                                 </div>                             </th>                             <th data-type="number">                                 <div class="small" align="center">                                     Rank                                 </div>                             </th>                         </tr>                     </thead>                     <tbody>';

        // Compute rows
        $ranked = [];
        $judgeCount = count($judges);
        $criteriaPercent = isset($fetchResultEventCriteriaPercentage['percent']) ? floatval($fetchResultEventCriteriaPercentage['percent']) : 0.0;
        foreach ($contestantsArr as $c) {
            $contestantCode = $c['code'];
            $seqCons = htmlspecialchars($c['sequence']);
            $gender = isset($c['gender']) ? htmlspecialchars($c['gender']) : '';
            $contestantSequence = ($conGeneral == 1 ? $seqCons : ($gender ? ($seqCons.' - '.$gender) : $seqCons));

            $totalScore = 0.0;
            $judgeScoresDisp = [];

            foreach ($judges as $j) {
                $event_judge_code = $j['code'];
                $stmtS = $db->prepare(judgeEventScoreList);
                $stmtS->bind_param("sss", $event_category, $contestantCode, $event_judge_code);
                $stmtS->execute();
                $resS = $stmtS->get_result();
                $judgeScore = 0.0;
                if ($resS && $resS->num_rows > 0) {
                    while ($row = $resS->fetch_assoc()) {
                        $judgeScore += floatval($row['score']);
                    }
                }
                $totalScore += $judgeScore;
                $judgeScoresDisp[] = $judgeScore !== null ? number_format($judgeScore, 2) : '';
            }

            // Average value numeric
            $avgVal = 0.0;
            if ($judgeCount > 0) {
                if ($conWeightedScoring == 1) {
                    $totalPossible = $criteriaPercent * $judgeCount;
                    $avgVal = ($totalPossible > 0) ? ($totalScore / $totalPossible * 100.0) : 0.0;
                } else {
                    $avgVal = $totalScore / $judgeCount; // average points per judge
                }
            }
            $avgDisp = number_format($avgVal, 2) . ($conWeightedScoring == 1 ? '%' : '');

            $ranked[] = [
                'seq' => $contestantSequence,
                'judgeScores' => $judgeScoresDisp,
                'avgVal' => $avgVal,
                'avgDisp' => $avgDisp,
            ];
        }

        // Sort by numeric average desc
        usort($ranked, function($a, $b) {
            if ($b['avgVal'] == $a['avgVal']) return 0;
            return ($b['avgVal'] < $a['avgVal']) ? -1 : 1;
        });

        // Build rows with tie-aware ranking based on rounded(2)
        $rank = 1;
        $prevRounded = null;
        $prevRank = null;
        $count = count($ranked);
        for ($i = 0; $i < $count; $i++) {
            $row = $ranked[$i];
            $rounded = round($row['avgVal'], 2);
            if ($i > 0 && $rounded === $prevRounded) {
                $currentRank = $prevRank;
            } else {
                $currentRank = $rank;
            }
            $prevRank = $currentRank;
            $prevRounded = $rounded;
            $rank++;

            // tie group check
            $isTie = false;
            if (($i > 0 && round($ranked[$i-1]['avgVal'],2) === $rounded) || ($i < $count-1 && round($ranked[$i+1]['avgVal'],2) === $rounded)) {
                $isTie = true;
            }
            $displayRank = $currentRank . ($isTie ? '.5' : '');

            $html .= '                         <tr>                             <td>                                 <div class="small text-center">'.$row['seq'].'</div>                             </td>';
            foreach ($row['judgeScores'] as $js) {
                $html .= '                             <td><div class="small text-center">'.$js.'</div></td>';
            }
            $html .= '                             <td data-sort="'.number_format((float)$row['avgVal'], 2, '.', '').'"><div class="small text-center">'.$row['avgDisp'].'</div></td>                             <td><div class="small text-center">'.$displayRank.'</div></td>                         </tr>';
        }

    $html .= "                     </tbody>                 </table>             </div>             <div class=\"\" align=\"center\">                 <button class=\"btn btn-outline-primary btn-sm rounded\" onclick=\"printTables(['".$tableId."'], ['selected', '".$hdrClass."'])\">Print Summary</button>             </div>";

        return $html;
    };
    // Build nav-tabs like adminAjax.php
    $summary .= '<ul class="nav nav-tabs mt-4 justify-content-center" id="categoryTabs" role="tablist">'
              . '<li class="nav-item" role="presentation"><button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All Categories</button></li>';
    if (!empty($contestantsByCategoryFemale)) { $summary .= '<li class="nav-item" role="presentation"><button class="nav-link" id="female-tab" data-bs-toggle="tab" data-bs-target="#female" type="button" role="tab">Female</button></li>'; }
    if (!empty($contestantsByCategoryMale)) { $summary .= '<li class="nav-item" role="presentation"><button class="nav-link" id="male-tab" data-bs-toggle="tab" data-bs-target="#male" type="button" role="tab">Male</button></li>'; }
    if (!empty($contestantsByCategoryLesbian)) { $summary .= '<li class="nav-item" role="presentation"><button class="nav-link" id="lesbian-tab" data-bs-toggle="tab" data-bs-target="#lesbian" type="button" role="tab">Lesbian</button></li>'; }
    if (!empty($contestantsByCategoryGay)) { $summary .= '<li class="nav-item" role="presentation"><button class="nav-link" id="gay-tab" data-bs-toggle="tab" data-bs-target="#gay" type="button" role="tab">Gay</button></li>'; }
    if (!empty($contestantsByCategoryBothMF)) { $summary .= '<li class="nav-item" role="presentation"><button class="nav-link" id="bothmf-tab" data-bs-toggle="tab" data-bs-target="#bothmf" type="button" role="tab">Both M/F</button></li>'; }
    if (!empty($contestantsByCategoryBothLGBTQ)) { $summary .= '<li class="nav-item" role="presentation"><button class="nav-link" id="bothlgbtq-tab" data-bs-toggle="tab" data-bs-target="#bothlgbtq" type="button" role="tab">Both LGBTQ</button></li>'; }
    $summary .= '</ul>';

    // Tab panes
    $summary .= '<div class="tab-content" id="categoryTabContent">'
              . '<div class="tab-pane fade show active" id="all" role="tabpanel">';

    // All Categories pane
    $summary .= $renderCategory($contestantsByCategoryFemale, judgeByCategorySummaryListFemale, 'data1', 'fm-hd', 'Female');
    $summary .= $renderCategory($contestantsByCategoryMale, judgeByCategorySummaryListMale, 'data2', 'm-hd', 'Male');
    $summary .= $renderCategory($contestantsByCategoryLesbian, judgeByCategorySummaryListLesbian, 'data3', 'ls-hd', 'Lesbian');
    $summary .= $renderCategory($contestantsByCategoryGay, judgeByCategorySummaryListGay, 'data4', 'gy-hd', 'Gay');
    $summary .= $renderCategory($contestantsByCategoryBothMF, judgeByCategorySummaryListBothMF, 'data5', 'bmf-hd', 'Both Male and Female');
    $summary .= $renderCategory($contestantsByCategoryBothLGBTQ, judgeByCategorySummaryListBothLGBTQ, 'data6', 'blgbtq-hd', 'Both LGBTQ');
    $summary .= '</div>';

    // Individual tabs
    if (!empty($contestantsByCategoryFemale)) {
        $summary .= '<div class="tab-pane fade" id="female" role="tabpanel">'
                 .  $renderCategory($contestantsByCategoryFemale, judgeByCategorySummaryListFemale, 'data1-single', 'fm-hd', 'Female')
                 .  '</div>';
    }
    if (!empty($contestantsByCategoryMale)) {
        $summary .= '<div class="tab-pane fade" id="male" role="tabpanel">'
                 .  $renderCategory($contestantsByCategoryMale, judgeByCategorySummaryListMale, 'data2-single', 'm-hd', 'Male')
                 .  '</div>';
    }
    if (!empty($contestantsByCategoryLesbian)) {
        $summary .= '<div class="tab-pane fade" id="lesbian" role="tabpanel">'
                 .  $renderCategory($contestantsByCategoryLesbian, judgeByCategorySummaryListLesbian, 'data3-single', 'ls-hd', 'Lesbian')
                 .  '</div>';
    }
    if (!empty($contestantsByCategoryGay)) {
        $summary .= '<div class="tab-pane fade" id="gay" role="tabpanel">'
                 .  $renderCategory($contestantsByCategoryGay, judgeByCategorySummaryListGay, 'data4-single', 'gy-hd', 'Gay')
                 .  '</div>';
    }
    if (!empty($contestantsByCategoryBothMF)) {
        $summary .= '<div class="tab-pane fade" id="bothmf" role="tabpanel">'
                 .  $renderCategory($contestantsByCategoryBothMF, judgeByCategorySummaryListBothMF, 'data5-single', 'bmf-hd', 'Both Male and Female')
                 .  '</div>';
    }
    if (!empty($contestantsByCategoryBothLGBTQ)) {
        $summary .= '<div class="tab-pane fade" id="bothlgbtq" role="tabpanel">'
                 .  $renderCategory($contestantsByCategoryBothLGBTQ, judgeByCategorySummaryListBothLGBTQ, 'data6-single', 'blgbtq-hd', 'Both LGBTQ')
                 .  '</div>';
    }
    $summary .= '</div>'; // close tab-content

    // No contestants fallback
    if (empty($contestantsByCategoryFemale) && empty($contestantsByCategoryMale) && empty($contestantsByCategoryLesbian) && empty($contestantsByCategoryGay) && empty($contestantsByCategoryBothMF) && empty($contestantsByCategoryBothLGBTQ)) {
        $summary .= '             <div class="mt-5" align="center">                 <h2 class="text-danger">No Contestants Found!</h2>             </div>         ';
    }

    echo $summary;
}
?>
