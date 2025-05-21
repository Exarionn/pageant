<?php
require '../include/connector/dbconn.php';

include "../include/generatedKey.php";
include "../include/query.php";


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Check if all required parameters are present
//     if (isset($_POST['updateEventScoreCodes'], $_POST['updateScores'])) {
//         $updateEventScoreCodes = $_POST['updateEventScoreCodes'];
//         $updateScores = $_POST['updateScores'];

        
//             // Update the existing score
//             $updateAdminJudgeScoreQuery = eventJudgeScoreUpdate;
//             $stmt = $db->prepare($updateAdminJudgeScoreQuery);

//             foreach ($updateScores as $index => $updateScore) {
//                 $updateEventScoreCodes = $updateEventScoreCodes[$index];

//                 $stmt->bind_param("ss", $updateScore, $updateEventScoreCodes);
//                 $stmt->execute();
//             }
                
//             echo "Scores updated successfully, ";

//         $stmt->close();
//     } else {
//         echo "Missing required parameters";
//     }
// } else {
//     echo "Invalid request method";
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required parameters are present
    if (isset($_POST['updateEventScoreCodes'], $_POST['updateScores'])) {
        $updateEventScoreCodes = json_decode($_POST['updateEventScoreCodes'], true);
        $updateScores = json_decode($_POST['updateScores'], true);

        if (is_array($updateEventScoreCodes) && is_array($updateScores)) {
            // Prepare the SQL query
            $updateAdminJudgeScoreQuery = 'UPDATE event_score SET score = ? WHERE code = ?'; // Example query, adjust as needed
            $stmt = $db->prepare($updateAdminJudgeScoreQuery);

            foreach ($updateScores as $index => $updateScore) {
                if (isset($updateEventScoreCodes[$index])) {
                    $updateEventScoreCode = $updateEventScoreCodes[$index];
                    $stmt->bind_param("ss", $updateScore, $updateEventScoreCode);
                    $stmt->execute();
                }
            }
            
            echo "Scores updated successfully";

            $stmt->close();
        } else {
            echo "Invalid data format";
        }
    } else {
        echo "Missing required parameters";
    }
} else {
    echo "Invalid request method";
}


?>