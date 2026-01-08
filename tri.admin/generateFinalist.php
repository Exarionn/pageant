<?php

require '../include/connector/dbconn.php';
include "../include/settings.php";
include "../include/query.php";

if (isset($_POST['action'])) {
    $sqlReset = "UPDATE contestant SET is_finalist = '0'";
    
    if ($db->query($sqlReset) === TRUE) {
        $conditionFinal = (int)$fetchSettings['condition_final'];
        $weightedScoring = (int)$weightedScoring;

        // Get all preliminary events
        $events = [];
        $stmt = $db->prepare("SELECT code FROM event WHERE event_type = 'PR'");
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $events[] = $row['code'];
        }

        // Get criteria percentages per event
        $criteriaByEvent = [];
        foreach ($events as $eventCode) {
            $stmt = $db->prepare("SELECT SUM(percent) as percent FROM event_criteria WHERE event_code = ?");
            $stmt->bind_param("s", $eventCode);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $criteriaByEvent[$eventCode] = $row ? (float)$row['percent'] : 0.0;
        }

        // Process each category
        $categories = [
            'FE' => ['judges' => ['FE', 'B']],
            'MA' => ['judges' => ['MA', 'B']],
            'LGBTQ-LES' => ['judges' => ['LGBTQ-LES', 'LGBTQ-B']],
            'LGBTQ-GAY' => ['judges' => ['LGBTQ-GAY', 'LGBTQ-B']],
            'B' => ['judges' => ['B']],
            'LGBTQ-B' => ['judges' => ['LGBTQ-B']]
        ];

        foreach ($categories as $categoryCode => $catInfo) {
            // Get contestants in this category
            $stmt = $db->prepare("SELECT code FROM contestant WHERE category_code = ?");
            $stmt->bind_param("s", $categoryCode);
            $stmt->execute();
            $res = $stmt->get_result();
            $contestants = [];
            while ($row = $res->fetch_assoc()) {
                $contestants[] = $row['code'];
            }

            if (empty($contestants)) continue;

            // Get judge count for this category
            $judgeCategories = implode("','", $catInfo['judges']);
            $judgeCountRes = $db->query("SELECT COUNT(*) as cnt FROM user WHERE types = 'isJudge' AND category IN ('$judgeCategories')");
            $judgeCount = $judgeCountRes->fetch_assoc()['cnt'];

            if ($judgeCount == 0) continue;

            // Calculate scores for each contestant
            $contestantScores = [];
            foreach ($contestants as $contestantCode) {
                $totalOverallScore = 0.0;
                $overallPossible = 0.0;
                $averagePoint = 0.0;
                $eventCount = 0;

                foreach ($events as $eventCode) {
                    $evCrit = $criteriaByEvent[$eventCode];
                    $evPossible = $evCrit * $judgeCount;

                    // Get sum of scores for this contestant, event, from eligible judges
                    $judgeCategories = implode("','", $catInfo['judges']);
                    $stmt = $db->prepare("SELECT SUM(score) as total FROM event_score WHERE contestant_code = ? AND event_code = ? AND category_code IN ('$judgeCategories')");
                    $stmt->bind_param("ss", $contestantCode, $eventCode);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $row = $res->fetch_assoc();
                    $judgeScore = $row ? (float)$row['total'] : 0.0;

                    if ($evPossible > 0) {
                        $totalOverallScore += $judgeScore;
                        $overallPossible += $evPossible;
                        
                        if ($weightedScoring == 0) {
                            // Point system: average points per judge for this event
                            $pointsAvg = $judgeScore / $judgeCount;
                            $averagePoint += $pointsAvg;
                            $eventCount++;
                        }
                    }
                }

                // Calculate final score based on scoring mode
                if ($weightedScoring == 1) {
                    // Percentage system
                    $finalScore = ($overallPossible > 0) ? ($totalOverallScore / $overallPossible * 100.0) : 0.0;
                } else {
                    // Point system: average of per-event averages
                    $finalScore = ($eventCount > 0) ? ($averagePoint / $eventCount) : 0.0;
                }

                $contestantScores[$contestantCode] = $finalScore;
            }

            // Sort by score descending
            arsort($contestantScores);

            // Mark top N as finalists
            $rank = 0;
            foreach ($contestantScores as $contestantCode => $score) {
                $rank++;
                if ($rank <= $conditionFinal) {
                    $stmt = $db->prepare("UPDATE contestant SET is_finalist = '1' WHERE code = ?");
                    $stmt->bind_param("s", $contestantCode);
                    $stmt->execute();
                }
            }
        }

        echo "Contestants Added to Finalist!";
    } else {
        echo "Error resetting is_finalist column: " . $db->error;
    }
    
    $db->close();
}

?>
