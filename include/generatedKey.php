<?php
        
function checkKey($query, $randStr) {
    global $db;

    $resultCheck = mysqli_query($db, $query);

    while ($rowCheck = mysqli_fetch_assoc($resultCheck)) {
        if ($rowCheck['code'] == $randStr) {
            return true;
        }
    }

    return false;
}

function generateKey($query, $lengthUser) {
    global $db;

    $result = mysqli_query($db, $query);
    $userLastCodeRow = mysqli_fetch_assoc($result);

    if ($userLastCodeRow) {
        $lastCode = $userLastCodeRow['code'];

        if ($lastCode === '') {
            // Return '000000001' if the column is empty
            return sprintf('%0' . $lengthUser . 'd', 1);
        } else {
            $newCode = sprintf('%0' . $lengthUser . 'd', intval($lastCode) + 1);
        }
    } else {
        // Return '000000001' if there is no last code
        return sprintf('%0' . $lengthUser . 'd', 1);
    }

    while (checkKey($query, $newCode)) {
        $newCode = sprintf('%0' . $lengthUser . 'd', intval($newCode) + 1);
    }

    return $newCode;
}


// Example usage:
//echo generateKey($qryUserLast, 9); -- (<SQL QUERY>, <LENGTH>)

?>