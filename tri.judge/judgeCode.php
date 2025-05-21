<?php
require '../include/connector/dbconn.php';

include "../include/generatedKey.php";
include "../include/query.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required parameters are present
    if (isset($_POST['judgeCategoryCode'], $_POST['eventCode'], $_POST['contestantCode'], $_POST['eventTypeCode'], $_POST['criteriaCodes'], $_POST['judgesCode'], $_POST['scores'])) {

        $judgeCategoryCode = $_POST['judgeCategoryCode'];
        $eventCode = $_POST['eventCode'];
        $contestantCode = $_POST['contestantCode'];
        $eventTypeCode = $_POST['eventTypeCode'];
        $criteriaCodes = $_POST['criteriaCodes']; 
        $judgesCode = $_POST['judgesCode'];
        $scores = $_POST['scores'];

        

        // Check if the score already exists
        $getEventScore = eventScoreCheckForExistingScore;
        $stmt = $db->prepare($getEventScore);
        $stmt->bind_param("sss", $eventCode, $judgesCode, $contestantCode);
        $stmt->execute();
        $fetchEventScore = $stmt->get_result();
        $fetchResultEventScore = $fetchEventScore->fetch_assoc();

        $stmt->close();

        if ($fetchResultEventScore) {
            // Update the existing score
            $updateQuery = eventScoreUpdate;
            $stmt = $db->prepare($updateQuery);

            foreach ($scores as $index => $score) {
                $criteriaCode = $criteriaCodes[$index];

                $stmt->bind_param("ssssss", $score, $judgeCategoryCode, $eventCode, $judgesCode, $criteriaCode, $contestantCode);
                $stmt->execute();
            }
                
            echo "Scores updated successfully, ";

        } else {
            // Insert a new score
            $insertQuery = eventScoreAdd;
            $stmt = $db->prepare($insertQuery);

            foreach ($scores as $index => $score) {
                $criteriaCode = $criteriaCodes[$index];
                $generatedKeyCode = generateKey(eventScoreLast, 6);

                $stmt->bind_param("ssssssss", $generatedKeyCode, $eventCode, $eventTypeCode, $judgesCode, $criteriaCode, $contestantCode, $score, $judgeCategoryCode);
                $stmt->execute();
            }

            echo "Scores inserted successfully, ";
        }
            $stmt->close();
    } else {
        echo "Missing required parameters";
    }
} else {
    echo "Invalid request method";
}
?>
