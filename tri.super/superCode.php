<?php

require '../include/connector/dbconn.php';
include "../include/query.php";

//Event add Area codes
if(isset($_POST['addEvent'])){
    $eventGenerated = $_POST['eventGenerated'];
    $eventType = $_POST['eventType'];
    $eventName = $_POST['eventName'];
    $eventPercentage = $_POST['eventPercentage'];
    $addedBy = $_POST['addedBy'];

    $sql = addEvent;
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssss", $eventGenerated, $eventType, $eventName, $eventPercentage, $addedBy);
    $criteriaAddResult = $stmt->execute();

    if($criteriaAddResult) {
        $_SESSION['status'] = "Added successfully";
        $_SESSION['status_code'] = "success";
        header('location: superEvent.php');
        exit; 
    }
    else {
        $_SESSION['status'] = "Error: Failed to process";
        $_SESSION['status_code'] = "error";
        header('location: superEvent.php');
        exit; 
    }
}

//Event update Area Codes
if(isset($_POST['updateEventCode'])){
    $updateEventType = $_POST['updateEventType'];
    $updateEventName = $_POST['updateEventName'];
    $updateEventPercentage = $_POST['updateEventPercentage'];
    $updatedBy = $_POST['updatedBy'];
    $updateEventCode = $_POST['updateEventCode'];

    // Prepare and execute the update query
    $eventEventUpdateQuery = updateEvent;
    $stmt = $db->prepare($eventEventUpdateQuery);
    $stmt->bind_param("sssss", $updateEventType, $updateEventName, $updateEventPercentage, $updatedBy, $updateEventCode);
    $updateResult = $stmt->execute();
    $stmt->close();

    if($updateResult){
        $_SESSION['status'] = "Event Updated Successfully";
        $_SESSION['status_code'] = "success";
        header('location: superEvent.php');
        exit(); 
    }
    else {
        $_SESSION['status'] = "Error Failed to Process";
        $_SESSION['status_code'] = "error";
        header('location: superEvent.php');
        exit(); 
    }

}

//Event delete Area Codes
if(isset($_POST['deleteEventCode'])){
    $deleteEventCode = $_POST['deleteEventCode'];
        
    $sqlDelete = $db->prepare(deleteEvent); 
    $sqlDelete->bind_param("s", $deleteEventCode); 
    $deleteResult = $sqlDelete->execute();

    if ($deleteResult === TRUE) {
        echo "Event Deleted";
    } else {
        echo "Error Deleting: " . $sqlDelete->error;
    }

    
    $db->close();
}



//criteria add Area Codes
if(isset($_POST['addCriteria'])){
    $criteriaGenerated = $_POST['criteriaGenerated'];
    $eventCode = $_POST['eventCode'];
    $criteriaName = $_POST['criteriaName'];
    $criteriaType = $_POST['criteriaType'];
    $criteriaPercentage = $_POST['criteriaPercentage'];
    $addedBy = $_POST['addedBy'];

    $sql = addCriteria;
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ssssss", $criteriaGenerated, $criteriaType, $eventCode, $criteriaName, $criteriaPercentage, $addedBy);
    $criteriaAddResult = $stmt->execute();

    if($criteriaAddResult) {
        $_SESSION['status'] = "Added successfully";
        $_SESSION['status_code'] = "success";
        header('location: superCriteria.php');
        exit; 
    }
    else {
        $_SESSION['status'] = "Error: Failed to process";
        $_SESSION['status_code'] = "error";
        header('location: superCriteria.php');
        exit; 
    }
}

//Criteria update Area Codes
if(isset($_POST['UpdateCriteria'])){
    // Retrieve form data
    $updateCriteriaType = $_POST['updateCriteriaType'];
    $updateEventCriteriaCode = $_POST['updateEventCriteriaCode'];
    $updateCriteriaName = $_POST['updateCriteriaName'];
    $updatePercentage = $_POST['updatePercentage'];
    $updatedBy = $_POST['updatedBy'];
    $updateCriteriaCode = $_POST['updateCriteriaCode'];

    // Prepare and execute the update query
    $eventCriteriaUpdateQuery = updateCriteria;
    $stmt = $db->prepare($eventCriteriaUpdateQuery);
    $stmt->bind_param("ssssss", $updateCriteriaType, $updateEventCriteriaCode, $updateCriteriaName, $updatePercentage, $updatedBy, $updateCriteriaCode);
    $updateResult = $stmt->execute();
    $stmt->close();

    if($updateResult){
        $_SESSION['status'] = "Criteria Updated Successfully";
        $_SESSION['status_code'] = "success";
        header('location: superCriteria.php');
        exit(); 
    }
    else {
        $_SESSION['status'] = "Error Failed to Process";
        $_SESSION['status_code'] = "error";
        header('location: superCriteria.php');
        exit(); 
    }

}



//Criteria delete Area Codes
if(isset($_POST['submitDeleteCriteria'])){
    $deleteCode = $_POST['deleteCode'];
        
    $sqlDelete = $db->prepare(deleteCriteria); 
    $sqlDelete->bind_param("s", $deleteCode); 
    $deleteResult = $sqlDelete->execute();
    $sqlDelete->close();
    
    if($deleteResult) {
        $_SESSION['status'] = "Criteria Deleted Successfully";
        $_SESSION['status_code'] = "success";
        header('location: superCriteria.php');
    }
    else {
        $_SESSION['status'] = "Error Failed to Process";
        $_SESSION['status_code'] = "error";
        header('location: superCriteria.php');
    }
}


//Contestant add Area Codes
if(isset($_POST['addContestants'])){
    $contestantGenerated = $_POST['contestantGenerated'];
    $contestantSequence = $_POST['contestantSequence'];
    $contestantName = $_POST['contestantName'];
    $contestantCategoryType = $_POST['contestantCategoryType'];
    $contestantGender = $_POST['contestantGender'];


    $sql = addContestant;
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssss", $contestantGenerated, $contestantSequence, $contestantName, $contestantCategoryType, $contestantGender);
    

    $AddResult = $stmt->execute();

    if($AddResult) {
        $_SESSION['status'] = "Added successfully";
        $_SESSION['status_code'] = "success";
        header('location: superContestant.php');
        exit; 
    }
    else {
        $_SESSION['status'] = "Error: Failed to process";
        $_SESSION['status_code'] = "error";
        header('location: superContestant.php');
        exit; 
    }
}



//Contestant update Area Codes
if(isset($_POST['updateContestantCode'])){
    $updateContestantSequence = $_POST['updateContestantSequence'];
    $updateContestantName = $_POST['updateContestantName'];
    $updateContestantCode = $_POST['updateContestantCode'];
    $updateContestantCategory = $_POST['updateContestantCategory'];
    $updateContestantGender = $_POST['updateContestantGender'];

    $contestantUpdateQuery = updateContestant;
    $stmt = $db->prepare($contestantUpdateQuery);
    $stmt->bind_param("sssss", $updateContestantSequence, $updateContestantName, $updateContestantCategory, $updateContestantGender, $updateContestantCode);
    $updateResult = $stmt->execute();
    $stmt->close();

    if($updateResult){
        $_SESSION['status'] = "Contestant Updated Successfully";
        $_SESSION['status_code'] = "success";
        header('location: superContestant.php');
        exit(); 
    }
    else {
        $_SESSION['status'] = "Error Failed to Process";
        $_SESSION['status_code'] = "error";
        header('location: superContestant.php');
        exit(); 
    }

}

//Contestatnt delete Area Codes
if(isset($_POST['deleteContestCode'])){
    $deleteContestCode = $_POST['deleteContestCode'];
        
    $sqlDelete = $db->prepare(deleteContestant); 
    $sqlDelete->bind_param("s", $deleteContestCode); 
    $deleteResult = $sqlDelete->execute();
    $sqlDelete->close();

    if ($deleteResult === TRUE) {
        echo "Contestant Deleted";
    } else {
        echo "Error Deleting: " . $sqlDelete->error;
    }

    
    $db->close();
}

//add judge Area
if(isset($_POST['addJudge'])){
    $judgeGenerated = $_POST['judgeGenerated'];    
    $judgeUserName = $_POST['judgeUserName'];
    $judgePassword = $_POST['judgePassword'];

    $judgeCategoryType = $_POST['judgeCategoryType'];
    $judgeName = $_POST['judgeName'];
    $addedBy = $_POST['addedBy'];

    // Fetch user obj
    $eventQuery = judgeValList;
    $stmt = $db->prepare($eventQuery);
    $stmt->execute();
    $resultEvent = $stmt->get_result();

    $existingUsernames = [];

    while($row = $resultEvent->fetch_assoc()) {
        $existingUsernames[] = $row['username'];
    }

    if(in_array($judgeUserName, $existingUsernames)) {
        $_SESSION['status'] = "Error: Username already exists";
        $_SESSION['status_code'] = "error";
        header('location: superjudge.php');
        exit;
    }

    // Validate username
    if(empty($judgeUserName)) {
        $_SESSION['status'] = "Error: Username is required";
        $_SESSION['status_code'] = "error";
        header('location: superjudge.php');
        exit;
    }


    $sql = addJudge;
    $stmt = $db->prepare($sql);
    // addJudge accepts category but no privilege/is_both
    $stmt->bind_param("ssssss", $judgeGenerated, $judgeUserName, $judgePassword, $judgeName, $judgeCategoryType, $addedBy);
    $AddResult = $stmt->execute();

    if($AddResult) {
        $_SESSION['status'] = "Added successfully";
        $_SESSION['status_code'] = "success";
        header('location: superjudge.php');
        exit; 
    }
    else {
        $_SESSION['status'] = "Error: Failed to process";
        $_SESSION['status_code'] = "error";
        header('location: superjudge.php');
        exit; 
    }
}

//update Judge area
if(isset($_POST['updateJudge'])){
 
    $updateJudgeUsername = $_POST['updateJudgeUsername'];
    $updateJudgePassword = $_POST['updateJudgePassword'];
    $updateJudgeName = $_POST['updateJudgeName'];
    $updateJudgeCategoryType = $_POST['updateJudgeCategoryType'];
    $updatedBy = $_POST['updatedBy'];
    
    $updateJudgeCode = $_POST['updateJudgeCode'];

    $sql = updateJudge;
    $stmt = $db->prepare($sql);
    // updateJudge signature: username, password, name, category, updated_by, code
    $stmt->bind_param("ssssss", $updateJudgeUsername, $updateJudgePassword, $updateJudgeName, $updateJudgeCategoryType, $updatedBy, $updateJudgeCode);
    $AddResult = $stmt->execute();

    if($AddResult) {
        $_SESSION['status'] = "Updated successfully";
        $_SESSION['status_code'] = "success";
        header('location: superjudge.php');
        exit; 
    }
    else {
        $_SESSION['status'] = "Error: Failed to process";
        $_SESSION['status_code'] = "error";
        header('location: superjudge.php');
        exit; 
    }

}


//judge delete Area Codes
if(isset($_POST['deleteJudgeCode'])){
    $deleteJudgeCode = $_POST['deleteJudgeCode'];
        
    $sqlDelete = $db->prepare(deleteJudge); 
    $sqlDelete->bind_param("s", $deleteJudgeCode); 
    $deleteResult = $sqlDelete->execute();
    $sqlDelete->close();

    if ($deleteResult === TRUE) {
        echo "User Deleted";
    } else {
        echo "Error Deleting: " . $sqlDelete->error;
    }

    
    $db->close();
}


//back up codes
if(isset($_POST['clearScoreButton'])) {

     // Execute the SQL query to update contestants
    $finalistUpdateSql = "UPDATE contestant SET is_finalist = '0'";
    $clearEventScoreSql = "DELETE FROM event_score";

    if ($db->query($finalistUpdateSql) === TRUE &&
        $db->query($clearEventScoreSql) === TRUE) {

 echo "Score Clear";
} else {
 echo "Error Clearing Score: " . $db->error;
}

// Close the database connection
$db->close();


}

if (isset($_POST['backupButton'])) {
    // Backup file path
    $backup_file = '../include/backup/' . $db_name . '-' . date('Y-m-d-H-i-s') . '.sql';

    // Open the backup file for writing
    $file = fopen($backup_file, 'w');
    if (!$file) {
        $_SESSION['status'] = "Failed to open backup file.";
        $_SESSION['status_code'] = "Error";
        header('location: ../500.php');
        exit();
    }

    // Function to write a query to the file
    function writeQuery($file, $query) {
        fwrite($file, $query . ";\n\n");
    }

    // Get all tables
    $tables_result = $db->query('SHOW TABLES');
    if (!$tables_result) {
        $_SESSION['status'] = "Failed to retrieve tables: " . $db->error;
        $_SESSION['status_code'] = "Error";
        fclose($file);
        header('location: ../500.php');
        exit();
    }

    while ($table = $tables_result->fetch_array()) {
        $table_name = $table[0];
        
        // Write the table creation statement
        $create_table_result = $db->query("SHOW CREATE TABLE `$table_name`");
        if (!$create_table_result) {
            $_SESSION['status'] = "Failed to retrieve table creation statement for $table_name: " . $db->error;
            $_SESSION['status_code'] = "Error";
            fclose($file);
            header('location: ../500.php');
            exit();
        }
        $create_table_row = $create_table_result->fetch_array();
        writeQuery($file, $create_table_row[1]);

        // Write the table data
        $data_result = $db->query("SELECT * FROM `$table_name`");
        if (!$data_result) {
            $_SESSION['status'] = "Failed to retrieve data for $table_name: " . $db->error;
            $_SESSION['status_code'] = "Error";
            fclose($file);
            header('location: ../500.php');
            exit();
        }
        while ($row = $data_result->fetch_assoc()) {
            $values = array_map([$db, 'real_escape_string'], array_values($row));
            $values = "'" . implode("', '", $values) . "'";
            $columns = implode(", ", array_keys($row));
            writeQuery($file, "INSERT INTO `$table_name` ($columns) VALUES ($values)");
        }
    }

    // Close file and connection
    fclose($file);
    $db->close();

    // Check if the backup file was created and has content
    if (file_exists($backup_file) && filesize($backup_file) > 0) {
        echo 'Backup created successfully!';
    } else {
        $_SESSION['status'] = "Failed to create backup or the backup file is empty.";
        $_SESSION['status_code'] = "Error";
        header('location: ../500.php');
    }
}


// User section logic===========================================================================

//add
if (isset($_POST['addUser'])) {

    // Retrieve form data
    $generated = $_POST['generated'];
    $addedBy = $_POST['addedBy'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $type = $_POST['type'];


    // Validate username and password
    $stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists
        $_SESSION['status'] = "Error: Username already exists.";
        $_SESSION['status_code'] = "error";
        header('location: superBackup.php'); // Redirect to the appropriate page
        exit;
    }


    // If username is unique, proceed to insert the new user
    $stmt = $db->prepare("INSERT INTO user (code, username, password, name, types, status, added_by, added_timestamp) VALUES (?, ?, ?, ?, ?, '1', ?, NOW())");

    // Bind parameters
    $stmt->bind_param("ssssss", $generated, $username, $password, $name, $type, $addedBy);

    // Execute the insert query
    if ($stmt->execute()) {
        $_SESSION['status'] = "User  added successfully.";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Error: Failed to add user.";
        $_SESSION['status_code'] = "error";
    }


    // Redirect to the appropriate page
    header('location: superUser.php');
    exit;
}

//update==========================================================================================
if (isset($_POST['updateUser'])) {

    // Prepare and bind
    $stmt = $db->prepare("UPDATE user SET username = ?, password = ?, name = ?, types = ?, updated_by = ?, updated_timestamp = NOW() WHERE code = ?");
    $stmt->bind_param("ssssss", $username, $password, $name, $type, $updatedBy, $code);

    // Set parameters
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $name = $_POST['name'];
    $type = $_POST['type'];
    $updatedBy = $_POST['updatedBy'];
    $code = $_POST['updateCode'];

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['status'] = "User Updated successfully.";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Error: Failed to add user.";
        $_SESSION['status_code'] = "error";
    }
    header('location: superUser.php');
    // Close the statement and connection
    $stmt->close();
    $db->close();
}

//delete =========================================================================================
if(isset($_POST['deleteCode'])){
    $deleteCode = $_POST['deleteCode'];
            
        $sqlDelete = $db->prepare("DELETE FROM user WHERE code = ?"); 
        $sqlDelete->bind_param("s", $deleteCode); 
        $deleteResult = $sqlDelete->execute();
    
        if ($deleteResult === TRUE) {
            echo "User Deleted";
        } else {
            echo "Error Deleting: " . $sqlDelete->error;
        }

        $db->close();
}

//settings========================================================================================

if (isset($_POST['addsettings'])) {
    $settingPageantName = $_POST['settingPageantName'];
    $settingCondition = $_POST['settingCondition'];
    $updateSettingCode = $_POST['updateSettingCode'];
    $settingStatus = $_POST['settingStatus'];
    $settingWeightedScoring = $_POST['settingWeightedScoring'];

    // File upload handling
    $logo = $_FILES['settingLogo']['name'] ?? null;
    $coverPhoto = $_FILES['settingCoverPhoto']['name'] ?? null;

    // File upload directory
    $uploadDir = "../assets/img/";

    // Allowed file types and max size
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 100 * 1024 * 1024; // 100MB

    // Validate files (logo)
    if ($logo) {
        if (!in_array($_FILES['settingLogo']['type'], $allowedTypes)) {
            $_SESSION['status'] = "Error: Invalid logo file type.";
            $_SESSION['status_code'] = "error";
            header('location: superBackup.php');
            exit;
        }
        if ($_FILES['settingLogo']['size'] > $maxSize) {
            $_SESSION['status'] = "Error: Logo file size exceeds the limit.";
            $_SESSION['status_code'] = "error";
            header('location: superBackup.php');
            exit;
        }
        // Store the original logo name
        $logoName = $_FILES['settingLogo']['name'];
    }

    // Validate files (cover photo)
    if ($coverPhoto) {
        if (!in_array($_FILES['settingCoverPhoto']['type'], $allowedTypes)) {
            $_SESSION['status'] = "Error: Invalid cover photo file type.";
            $_SESSION['status_code'] = "error";
            header('location: superBackup.php');
            exit;
        }
        if ($_FILES['settingCoverPhoto']['size'] > $maxSize) {
            $_SESSION['status'] = "Error: Cover photo file size exceeds the limit.";
            $_SESSION['status_code'] = "error";
            header('location: superBackup.php');
            exit;
        }
        // Store the original cover photo name
        $coverPhotoName = $_FILES['settingCoverPhoto']['name'];
    }

    // Validate the condition as an integer
    if (filter_var($settingCondition, FILTER_VALIDATE_INT) !== false) {
        // Fetch the previous settings to handle file deletions
        $Query = "SELECT * FROM setting WHERE id = ?";
        $stmt = $db->prepare($Query);
        $stmt->bind_param("i", $updateSettingCode);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetchResult = $result->fetch_assoc();

        // Handle file deletions before updating the database
        if ($fetchResult) {
            // Handle logo deletion
            if ($logo) {
                $previousLogo = $fetchResult['logo']; // Get the previous logo filename
                if ($previousLogo) {
                    $previousLogoPath = $uploadDir . $previousLogo;
                    if (file_exists($previousLogoPath)) {
                        unlink($previousLogoPath); // Delete the old logo
                    } else {
                        error_log("Old logo file not found: " . $previousLogoPath);
                    }
                }
            }

            // Handle cover photo deletion
            if ($coverPhoto) {
                $previousCoverPhoto = $fetchResult['cover_photo']; // Get the previous cover photo filename
                if ($previousCoverPhoto) {
                    $previousCoverPhotoPath = $uploadDir . $previousCoverPhoto;
                    if (file_exists($previousCoverPhotoPath)) {
                        unlink($previousCoverPhotoPath); // Delete the old cover photo
                    } else {
                        error_log("Old cover photo file not found: " . $previousCoverPhotoPath);
                    }
                }
            }
        }

        // Prepare the SQL query for updating
        $sql = "UPDATE setting SET condition_final = ?, pageant_name = ?, isGeneral = ?, weighted_scoring = ?";
        
        // Append file fields to the query if files are uploaded
        if ($logo) {
            $sql .= ", logo = ?";
        }
        if ($coverPhoto) {
            $sql .= ", cover_photo = ?";
        }
        $sql .= " WHERE id = ?";

        // Prepare the SQL statement
        $stmt = $db->prepare($sql);

        // Bind parameters dynamically based on the file uploads
        $types = "ssss"; // condition_final, pageant_name, isGeneral
 if ($logo) $types .= "s"; // logo
        if ($coverPhoto) $types .= "s"; // cover_photo
        $types .= "i"; // id

        // Bind the parameters
        if ($logo && $coverPhoto) {
            $stmt->bind_param($types, $settingCondition, $settingPageantName, $settingStatus, $settingWeightedScoring, $logoName, $coverPhotoName, $updateSettingCode);
        } elseif ($logo) {
            $stmt->bind_param($types, $settingCondition, $settingPageantName, $settingStatus, $settingWeightedScoring, $logoName, $updateSettingCode);
        } elseif ($coverPhoto) {
            $stmt->bind_param($types, $settingCondition, $settingPageantName, $settingStatus, $settingWeightedScoring, $coverPhotoName, $updateSettingCode);
        } else {
            $stmt->bind_param($types, $settingCondition, $settingPageantName, $settingStatus, $settingWeightedScoring, $updateSettingCode);
        }

        // Execute the query
        $AddResult = $stmt->execute();

        // Handle file uploads after the database update
        if ($logo) {
            // Upload the new logo
            $logoTarget = $uploadDir . $logoName;
            if (!move_uploaded_file($_FILES['settingLogo']['tmp_name'], $logoTarget)) {
                $_SESSION['status'] = "Error: Failed to upload logo.";
                $_SESSION['status_code'] = "error";
                header('location: superBackup.php');
                exit;
            }
        }

        if ($coverPhoto) {
            // Upload the new cover photo
            $coverTarget = $uploadDir . $coverPhotoName;
            if (!move_uploaded_file($_FILES['settingCoverPhoto']['tmp_name'], $coverTarget)) {
                $_SESSION['status'] = "Error: Failed to upload cover photo.";
                $_SESSION['status_code'] = "error";
                header('location: superBackup.php');
                exit;
            }
        }

        // Check if the execution was successful
        if ($AddResult) {
            $_SESSION['status'] = "Updated successfully";
            $_SESSION['status_code'] = "success";
            header('location: superBackup.php');
            exit;
        } else {
            $_SESSION['status'] = "Error: Failed to process";
            $_SESSION['status_code'] = "error";
            header('location: superBackup.php');
            exit;
        }
    } else {
        // Invalid condition input
        $_SESSION['status'] = "Error: Failed to process";
        $_SESSION['status_code'] = "error";
        header('location: superBackup.php');
        exit;
    }
}
?>