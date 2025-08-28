<?php
    require '../include/connector/dbconn.php';
    require '../include/admininclude/adminSession.php';
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
            <div id="layoutSidenav_nav">
            <?php include "../include/admininclude/adminSideNav.php";?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4 mb-3">
                        <h1 class="mt-4 text-muted">Preliminary Overall Summary</h1>
<?php
                                    // Build one table with tabs to filter categories
                                    $contestantsByCategoryFemale  = [];
                                    $contestantsByCategoryMale  = [];
                                    $contestantsByCategoryLesbian  = [];
                                    $contestantsByCategoryGay  = [];
                                    $contestantsByCategoryBothMF = [];
                                    $contestantsByCategoryBothLGBTQ = [];

                                    // Female
                                    $stmt = $db->prepare(contestantListFemale);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    if ($res) { while ($row = $res->fetch_assoc()) { $contestantsByCategoryFemale[] = $row; } }

                                    // Male
                                    $stmt = $db->prepare(contestantListMale);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    if ($res) { while ($row = $res->fetch_assoc()) { $contestantsByCategoryMale[] = $row; } }

                                    // Lesbian
                                    $stmt = $db->prepare(contestantListLesbian);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    if ($res) { while ($row = $res->fetch_assoc()) { $contestantsByCategoryLesbian[] = $row; } }

                                    // Gay
                                    $stmt = $db->prepare(contestantListGay);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    if ($res) { while ($row = $res->fetch_assoc()) { $contestantsByCategoryGay[] = $row; } }

                                    // Both M/F
                                    $stmt = $db->prepare(contestantListBothMF);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    if ($res) { while ($row = $res->fetch_assoc()) { $contestantsByCategoryBothMF[] = $row; } }

                                    // Both LGBTQ
                                    $stmt = $db->prepare(contestantListBothLGBTQ);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    if ($res) { while ($row = $res->fetch_assoc()) { $contestantsByCategoryBothLGBTQ[] = $row; } }

                                    // Judge counts per category
                                    $fetchResultEventJudgeCountFemale = $db->query(judgeCountListFemale)->fetch_assoc();
                                    $fetchResultEventJudgeCountMale = $db->query(judgeCountListMale)->fetch_assoc();
                                    $fetchResultEventJudgeCountLesbian = $db->query(judgeCountListLesbian)->fetch_assoc();
                                    $fetchResultEventJudgeCountGay = $db->query(judgeCountListGay)->fetch_assoc();
                                    $fetchResultEventJudgeCountBothMF = $db->query(judgeCountListBothMF)->fetch_assoc();
                                    $fetchResultEventJudgeCountBothLGBTQ = $db->query(judgeCountListBothLGBTQ)->fetch_assoc();

                                    // Prefetch shared event/criteria data once
                                    $events = [];
                                    $stmt = $db->prepare(eventList);
                                    $stmt->execute();
                                    $resEvents = $stmt->get_result();
                                    if ($resEvents && $resEvents->num_rows > 0) {
                                        while ($er = $resEvents->fetch_assoc()) {
                                            $events[] = ['code' => $er['code'], 'name' => $er['event_name']];
                                        }
                                    }

                                    // Overall preliminary criteria percent (sum of PR criteria)
                                    $stmt = $db->prepare(criteriaPercentage);
                                    $stmt->execute();
                                    $resCritOverall = $stmt->get_result();
                                    $overallCritRow = $resCritOverall ? $resCritOverall->fetch_assoc() : null;
                                    $overallSumOfCriteria = $overallCritRow && isset($overallCritRow['criteria_percent']) ? (float)$overallCritRow['criteria_percent'] : 0.0;

                                    // Criteria percent per event map
                                    $criteriaByEvent = [];
                                    foreach ($events as $ev) {
                                        $stmt = $db->prepare(criteriaPercentageList);
                                        $stmt->bind_param("s", $ev['code']);
                                        $stmt->execute();
                                        $rc = $stmt->get_result();
                                        $row = $rc ? $rc->fetch_assoc() : null;
                                        $criteriaByEvent[$ev['code']] = $row && isset($row['percent']) ? (float)$row['percent'] : 0.0;
                                    }

                                    // Snapshot settings into locals for closure capture
                                    $isGeneralVal = isset($isGeneral) ? (int)$isGeneral : 0;
                                    $weightedScoringVal = isset($weightedScoring) ? (int)$weightedScoring : 0;

                                    // Helper to compute ranked rows for a category
                                    $computeCategory = function(array $contestants, int $judgeCount) use ($db, $events, $criteriaByEvent, $overallSumOfCriteria, $isGeneralVal, $weightedScoringVal) {
                                        $ranked = [];
                                        foreach ($contestants as $c) {
                                            $contestantCode = htmlspecialchars($c['code']);
                                            $seqCons = htmlspecialchars($c['sequence']);
                                            $gender = isset($c['gender']) ? htmlspecialchars($c['gender']) : '';
                                            $sequenceLabel = ($isGeneralVal == 1 || empty($gender)) ? $seqCons : ($seqCons . ' - ' . $gender);

                                            $totalOverallScore = 0.0;
                                            $overallPossible = max($overallSumOfCriteria * max($judgeCount, 0), 0.0);
                                            $averagePoint = 0.0; // sum of per-event percentages for unweighted mode
                                            $eventCount = 0;     // count of events considered
                                            $scores = [];

                                            foreach ($events as $ev) {
                                                $evCode = $ev['code'];
                                                $stmt = $db->prepare(overallSummaryOverallSummary);
                                                $stmt->bind_param("ss", $evCode, $contestantCode);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                $judgeScore = 0.0;
                                                if ($res && $res->num_rows > 0) {
                                                    $row = $res->fetch_assoc();
                                                    $judgeScore = isset($row['overallSummary']) ? (float)$row['overallSummary'] : 0.0;
                                                }

                                                $evCrit = isset($criteriaByEvent[$evCode]) ? (float)$criteriaByEvent[$evCode] : 0.0;
                                                $evPossible = $evCrit * max($judgeCount, 0);
                                                if ($evPossible > 0 && $overallPossible > 0) {
                                                    // Compute per-event display and aggregates based on scoring mode
                                                    $totalOverallScore += $judgeScore; // used in percentage system (weighted)
                                                    if ($weightedScoringVal == 1) {
                                                        // Percentage system: show percentage for each event
                                                        $eventPct = ($judgeScore / $evPossible) * 100.0;
                                                        $scoreDisplay = number_format($eventPct, 2) . ' %';
                                                        $scores[] = [ 'disp' => $scoreDisplay, 'val' => $eventPct ];
                                                    } else {
                                                        // Point system: show average points per judge for the event
                                                        $pointsAvg = $judgeScore / max($judgeCount, 1);
                                                        $averagePoint += $pointsAvg;
                                                        $eventCount++;
                                                        $scoreDisplay = number_format($pointsAvg, 2);
                                                        $scores[] = [ 'disp' => $scoreDisplay, 'val' => $pointsAvg ];
                                                    }
                                                } else {
                                                    $scores[] = null;
                                                }
                                            }

                                            if ($weightedScoringVal == 1) {
                                                // Percentage system: total points / total possible points across all events (as percentage)
                                                $avgVal = ($overallPossible > 0) ? ($totalOverallScore / $overallPossible * 100.0) : 0.0;
                                            } else {
                                                // Point system: average of per-event average points so each event contributes equally (in points)
                                                $den = $eventCount > 0 ? $eventCount : 0;
                                                $avgVal = ($den > 0) ? ($averagePoint / $den) : 0.0;
                                            }
                                            $avgDisp = number_format($avgVal, 2) . ($weightedScoringVal == 1 ? ' %' : '');
                                            $ranked[] = [
                                                'label' => $sequenceLabel,
                                                'scores' => $scores,
                                                'avgVal' => $avgVal,
                                                'avgDisp' => $avgDisp,
                                            ];
                                        }

                                        usort($ranked, function($a, $b) { return ($b['avgVal'] ?? 0) <=> ($a['avgVal'] ?? 0); });
                                        $rank = 1; $count = count($ranked); $prevRank = 0;
                                        for ($i = 0; $i < $count; $i++) {
                                            $curr = round($ranked[$i]['avgVal'] ?? 0, 2);
                                            $prev = ($i > 0) ? round($ranked[$i-1]['avgVal'] ?? 0, 2) : null;
                                            $next = ($i < $count - 1) ? round($ranked[$i+1]['avgVal'] ?? 0, 2) : null;
                                            $isTieWithPrev = ($i > 0) && ($curr === $prev);
                                            $isTieWithNext = ($i < $count - 1) && ($curr === $next);
                                            $currentRank = $isTieWithPrev ? $prevRank : $rank;
                                            $rank++;
                                            $prevRank = $currentRank;
                                            $isHalf = ($isTieWithPrev || $isTieWithNext);
                                            $ranked[$i]['rankDisp'] = $currentRank . ($isHalf ? '.5' : '');
                                            $ranked[$i]['rankVal'] = $currentRank + ($isHalf ? 0.5 : 0.0);
                                        }
                                        return $ranked;
                                    };

                                    // Build category map
                                    $categories = [];
                                    if (!empty($contestantsByCategoryFemale)) {
                                        $categories['FE'] = [ 'name' => 'Female', 'judgeCount' => (int)($fetchResultEventJudgeCountFemale['judge_count'] ?? 0), 'contestants' => $contestantsByCategoryFemale ];
                                    }
                                    if (!empty($contestantsByCategoryMale)) {
                                        $categories['MA'] = [ 'name' => 'Male', 'judgeCount' => (int)($fetchResultEventJudgeCountMale['judge_count'] ?? 0), 'contestants' => $contestantsByCategoryMale ];
                                    }
                                    if (!empty($contestantsByCategoryLesbian)) {
                                        $categories['LGBTQ-LES'] = [ 'name' => 'Lesbian', 'judgeCount' => (int)($fetchResultEventJudgeCountLesbian['judge_count'] ?? 0), 'contestants' => $contestantsByCategoryLesbian ];
                                    }
                                    if (!empty($contestantsByCategoryGay)) {
                                        $categories['LGBTQ-GAY'] = [ 'name' => 'Gay', 'judgeCount' => (int)($fetchResultEventJudgeCountGay['judge_count'] ?? 0), 'contestants' => $contestantsByCategoryGay ];
                                    }
                                    if (!empty($contestantsByCategoryBothMF)) {
                                        $categories['B'] = [ 'name' => 'Both M/F', 'judgeCount' => (int)($fetchResultEventJudgeCountBothMF['judge_count'] ?? 0), 'contestants' => $contestantsByCategoryBothMF ];
                                    }
                                    if (!empty($contestantsByCategoryBothLGBTQ)) {
                                        $categories['LGBTQ-B'] = [ 'name' => 'Both LGBTQ', 'judgeCount' => (int)($fetchResultEventJudgeCountBothLGBTQ['judge_count'] ?? 0), 'contestants' => $contestantsByCategoryBothLGBTQ ];
                                    }

                                    $summary = '';
                                    if (count($categories) === 0) {
                                        $summary .= '<div class="mt-5" align="center"><h2 class="text-danger">No Contestants Found!</h2></div>';
                                        echo $summary;
                                    } else {
                                        $summary .= '<h3 class="mt-4 selected text-muted" align="center">Preliminary Overall Summary</h3>';
                                        $summary .= '<ul class="nav nav-tabs mt-4 justify-content-center" id="categoryTabs" role="tablist">';
                                        // All Categories tab first
                                        $summary .= '<li class="nav-item" role="presentation">'
                                                  . '<button class="nav-link active" id="all-tab" data-cat="" type="button" role="tab">All Categories</button>'
                                                  . '</li>';
                                        foreach ($categories as $code => $cat) {
                                            $summary .= '<li class="nav-item" role="presentation"><button class="nav-link" data-cat="' . htmlspecialchars($code) . '" type="button" role="tab">' . htmlspecialchars($cat['name']) . '</button></li>';
                                        }
                                        $summary .= '</ul>';
                                        $headerText = ($isGeneral == 1) ? 'General Summary' : 'All Categories Summary';
                                        $summary .= '<h6 id="categoryHeader" class="cat-title mt-4 text-muted" align="center">' . $headerText . '</h6>';

                                        $summary .= '<div class="card-body table-responsive-sm">';
                                        $summary .= '<table class="table table-hover" id="summaryTable">';
                                        $summary .= '<thead><tr>';
                                        $summary .= '<th><div class="small" align="center">Candidate No.</div></th>';
                                        foreach ($events as $ev) {
                                            $summary .= '<th data-type="number"><div class="small ms-3 me-3" align="center">' . htmlspecialchars($ev['name']) . '</div></th>';
                                        }
                                        $avgHdr = ($weightedScoring == 1) ? 'Average (%) - Overall' : 'Average (pts) - Overall';
                                        $summary .= '<th data-type="number"><div class="small text-success" align="center">'.$avgHdr.'</div></th>';
                                        $summary .= '<th data-type="number"><div class="small" align="center">Rank</div></th>';
                                        $summary .= '</tr></thead><tbody>';

                                        foreach ($categories as $code => $cat) {
                                            $rows = $computeCategory($cat['contestants'], (int)$cat['judgeCount']);
                                            foreach ($rows as $r) {
                                                $summary .= '<tr data-cat="' . htmlspecialchars($code) . '">';
                                                $summary .= '<td><div class="small text-center">' . htmlspecialchars($r['label']) . '</div></td>';
                                                foreach ($r['scores'] as $sc) {
                                                    if ($sc !== null) {
                                                        if (is_array($sc)) {
                                                            $summary .= '<td data-sort="'.number_format((float)$sc['val'], 2, '.', '').'"><div class="small text-center">' . $sc['disp'] . '</div></td>';
                                                        } else {
                                                            // fallback
                                                            $summary .= '<td><div class="small text-center">' . $sc . '</div></td>';
                                                        }
                                                    } else {
                                                        $summary .= '<td><div class="small text-center">&nbsp;</div></td>';
                                                    }
                                                }
                                                $summary .= '<td data-sort="'.number_format((float)($r['avgVal'] ?? 0), 2, '.', '').'"><div class="small text-center">' . htmlspecialchars($r['avgDisp']) . '</div></td>';
                                                $summary .= '<td data-sort="'.number_format((float)($r['rankVal'] ?? 0), 2, '.', '').'"><div class="small text-center">' . htmlspecialchars($r['rankDisp']) . '</div></td>';
                                                $summary .= '</tr>';
                                            }
                                        }
                                        $summary .= '</tbody></table></div>';

                                        $summary .= '<div class="" align="center"><button class="btn btn-outline-primary btn-sm rounded" onclick="printCurrentCategory()">Print Summary</button></div>';
                                        echo $summary;
                                    }
?>
                    </div>
                </main>
                <?php include "../include/footer.php";?>
            </div>
        </div>
        <script>
        // Filter table rows by selected category and update header
        (function() {
            function showCategory(cat) {
                var header = document.getElementById('categoryHeader');
                var selectedBtn = document.querySelector('#categoryTabs .nav-link.active');
                var name = selectedBtn ? selectedBtn.textContent.trim() : '';
                if (header) {
                    var isGeneral = <?php echo isset($isGeneral) ? (int)$isGeneral : 0; ?>;
                    var text = 'All Categories Summary';
                    if (isGeneral === 1) {
                        text = 'General Summary';
                    } else if (name && name.toLowerCase() !== 'all categories') {
                        text = name + ' Category Summary';
                    }
                    header.textContent = text;
                }
                var rows = document.querySelectorAll('#summaryTable tbody tr');
                rows.forEach(function(r){
                    if (!cat || r.getAttribute('data-cat') === cat) {
                        r.style.display = '';
                    } else {
                        r.style.display = 'none';
                    }
                });
            }

            var tabs = document.querySelectorAll('#categoryTabs .nav-link');
            tabs.forEach(function(btn){
                btn.addEventListener('click', function(){
                    tabs.forEach(function(b){ b.classList.remove('active'); });
                    this.classList.add('active');
                    showCategory(this.getAttribute('data-cat'));
                });
            });

            // Initialize to All (first active)
            var firstActive = document.querySelector('#categoryTabs .nav-link.active');
            if (firstActive) { showCategory(firstActive.getAttribute('data-cat')); }

            // Expose a print helper that prints the selected header and the main table
            window.printCurrentCategory = function() {
                var active = document.querySelector('#categoryTabs .nav-link.active');
                var cat = active ? active.getAttribute('data-cat') : null;
                // Create a clone of the table with only visible rows
                var table = document.getElementById('summaryTable');
                if (!table) { window.print(); return; }

                var clone = table.cloneNode(true);
                // Remove hidden rows in clone
                clone.querySelectorAll('tbody tr').forEach(function(r){
                    if (r.style.display === 'none') { r.remove(); }
                });

                var printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write('<html><head><title>Print</title>');
                var stylesheets = document.querySelectorAll('link[rel="stylesheet"]');
                stylesheets.forEach(function(sheet) { printWindow.document.write('<link rel="stylesheet" href="' + sheet.href + '">'); });
                printWindow.document.write('<style>@page { size: letter landscape; }</style>');
                printWindow.document.write('</head><body>');
                var selected = document.querySelector('.selected');
                if (selected) { printWindow.document.write(selected.outerHTML); }
                var header = document.getElementById('categoryHeader');
                if (header) { printWindow.document.write(header.outerHTML); }
                printWindow.document.body.appendChild(clone);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.onload = function() { printWindow.focus(); printWindow.print(); printWindow.close(); };
            }
        })();
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
        <script>
        // Initialize simple-datatables for the summary table
        document.addEventListener('DOMContentLoaded', function(){
            if (window.simpleDatatables) {
                var el = document.querySelector('#summaryTable');
                if (el) {
                    try { new simpleDatatables.DataTable(el, { perPage: 20, perPageSelect: [10,20,50,100] }); } catch(e) {}
                }
            }
        });
        </script>
        
    </body>
</html>

<?php include "../include/footerSwal.php";?>

