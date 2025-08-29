<?php

require '../include/connector/dbconn.php';
include "../include/settings.php";
include "../include/query.php";

if (isset($_POST['action'])) {
    // Reset the is_finalist column to 0 for all contestants
    $sqlReset = "UPDATE contestant SET is_finalist = '0'";
    
            // Execute the reset query
            if ($db->query($sqlReset) === TRUE) {

                $feLimit = $fetchSettings['condition_final'];
                $maLimit = $fetchSettings['condition_final'];
                $lesLimit = $fetchSettings['condition_final'];
                $gayLimit = $fetchSettings['condition_final'];
                $bothFMLimit = $fetchSettings['condition_final'];
                $lgbtqBothLimit = $fetchSettings['condition_final'];

                        // Update finalists for FE category (strict to FE only)
                        $sqlUpdateFE = "WITH ranked_contestants AS (
                                                                SELECT 
                                                                        po.contestant_code,
                                                                        ROW_NUMBER() OVER(ORDER BY SUM(CAST(po.score AS DECIMAL(10,2))) DESC) AS cat_rank
                                                                FROM event_score AS po
                                                                INNER JOIN contestant AS c2 ON po.contestant_code = c2.code
                                                                WHERE po.event_type_code = 'PR'
                                              AND c2.category_code = 'FE'
                                                                GROUP BY po.contestant_code
                                                        )
                                                        UPDATE contestant AS c
                                                        JOIN ranked_contestants AS temp 
                                                            ON c.code = temp.contestant_code AND temp.cat_rank <= ?
                                                        SET c.is_finalist = '1'";

        // Update finalists for MA category
            // Update finalists for MA category (strict to MA only)
            $sqlUpdateMA = "WITH ranked_contestants AS (
                                                        SELECT 
                                                                po.contestant_code,
                                                                ROW_NUMBER() OVER(ORDER BY SUM(CAST(po.score AS DECIMAL(10,2))) DESC) AS cat_rank
                                                        FROM event_score AS po
                                                        INNER JOIN contestant AS c2 ON po.contestant_code = c2.code
                                                        WHERE po.event_type_code = 'PR'
                          AND c2.category_code = 'MA'
                                                        GROUP BY po.contestant_code
                                                )
                                                UPDATE contestant AS c
                                                JOIN ranked_contestants AS temp 
                                                    ON c.code = temp.contestant_code AND temp.cat_rank <= ?
                                                SET c.is_finalist = '1'";

        // Update finalists for LGBTQ-LES category
        // Update finalists for LGBTQ-LES (strict)
        $sqlUpdateLgbtqLes = "WITH ranked_contestants AS (
                                                                SELECT 
                                                                        po.contestant_code,
                                                                        ROW_NUMBER() OVER(ORDER BY SUM(CAST(po.score AS DECIMAL(10,2))) DESC) AS cat_rank
                                                                FROM event_score AS po
                                                                INNER JOIN contestant AS c2 ON po.contestant_code = c2.code
                                                                WHERE po.event_type_code = 'PR'
                      AND c2.category_code = 'LGBTQ-LES'
                                                                GROUP BY po.contestant_code
                                                        )
                                                        UPDATE contestant AS c
                                                        JOIN ranked_contestants AS temp 
                                                            ON c.code = temp.contestant_code AND temp.cat_rank <= ?
                                                        SET c.is_finalist = '1'";

        // Update finalists for LGBTQ-GAY category
                    // Update finalists for LGBTQ-GAY (strict)
                    $sqlUpdateLgbtqGay = "WITH ranked_contestants AS (
                                                                SELECT 
                                                                        po.contestant_code,
                                                                        ROW_NUMBER() OVER(ORDER BY SUM(CAST(po.score AS DECIMAL(10,2))) DESC) AS cat_rank
                                                                FROM event_score AS po
                                                                INNER JOIN contestant AS c2 ON po.contestant_code = c2.code
                                                                WHERE po.event_type_code = 'PR'
                                                                        AND c2.category_code = 'LGBTQ-GAY'
                                                                GROUP BY po.contestant_code
                                                        )
                                                        UPDATE contestant AS c
                                                        JOIN ranked_contestants AS temp 
                                                            ON c.code = temp.contestant_code AND temp.cat_rank <= ?
                                                        SET c.is_finalist = '1'";                    

                    // Update finalists for FE/MA Both category (category_code = 'B')
                    $sqlUpdateBothFM = "WITH ranked_contestants AS (
                                                                    SELECT 
                                                                            po.contestant_code,
                                                                            ROW_NUMBER() OVER(ORDER BY SUM(CAST(po.score AS DECIMAL(10,2))) DESC) AS cat_rank
                                                                    FROM event_score AS po
                                                                    INNER JOIN contestant AS c2 ON po.contestant_code = c2.code
                                                                    WHERE po.event_type_code = 'PR'
                                                                        AND c2.category_code = 'B'
                                                                    GROUP BY po.contestant_code
                                                            )
                                                            UPDATE contestant AS c
                                                            JOIN ranked_contestants AS temp 
                                                                ON c.code = temp.contestant_code AND temp.cat_rank <= ?
                                                            SET c.is_finalist = '1'";

                    // Update finalists for LGBTQ Both category (category_code = 'LGBTQ-B')
                    $sqlUpdateLgbtqBoth = "WITH ranked_contestants AS (
                                                                    SELECT 
                                                                            po.contestant_code,
                                                                            ROW_NUMBER() OVER(ORDER BY SUM(CAST(po.score AS DECIMAL(10,2))) DESC) AS cat_rank
                                                                    FROM event_score AS po
                                                                    INNER JOIN contestant AS c2 ON po.contestant_code = c2.code
                                                                    WHERE po.event_type_code = 'PR'
                                                                        AND c2.category_code = 'LGBTQ-B'
                                                                    GROUP BY po.contestant_code
                                                            )
                                                            UPDATE contestant AS c
                                                            JOIN ranked_contestants AS temp 
                                                                ON c.code = temp.contestant_code AND temp.cat_rank <= ?
                                                            SET c.is_finalist = '1'";

        // Prepare and bind the parameters to prevent SQL injection
        if (($stmtFE = $db->prepare($sqlUpdateFE)) &&
            ($stmtMA = $db->prepare($sqlUpdateMA))  &&
            ($stmtLgbtqLes = $db->prepare($sqlUpdateLgbtqLes)) &&
            ($stmtLgbtqGay = $db->prepare($sqlUpdateLgbtqGay)) &&
            ($stmtBothFM = $db->prepare($sqlUpdateBothFM)) &&
            ($stmtLgbtqBoth = $db->prepare($sqlUpdateLgbtqBoth))) {
        $stmtFE->bind_param("i", $feLimit); // Assuming $feLimit is an integer
        $stmtMA->bind_param("i", $maLimit); // Assuming $maLimit is an integer
    $stmtLgbtqLes->bind_param("i", $lesLimit); // Assuming $lesLimit is an integer
    $stmtLgbtqGay->bind_param("i", $gayLimit); // Assuming $gayLimit is an integer
    $stmtBothFM->bind_param("i", $bothFMLimit); // Assuming $bothFMLimit is an integer
    $stmtLgbtqBoth->bind_param("i", $lgbtqBothLimit); // Assuming $lgbtqBothLimit is an integer
        
        // Execute FE category update
        $stmtFE->execute();

        // Execute MA category update
        $stmtMA->execute();

        // Execute LES category update
        $stmtLgbtqLes->execute();

        // Execute GAY category update
        $stmtLgbtqGay->execute();

    // Execute Both FE/MA category update
    $stmtBothFM->execute();

    // Execute LGBTQ Both category update
    $stmtLgbtqBoth->execute();

        // Check if any update was successful
    if ($stmtFE->affected_rows > 0 || $stmtMA->affected_rows > 0 || $stmtLgbtqLes->affected_rows > 0 || $stmtLgbtqGay->affected_rows > 0 || $stmtBothFM->affected_rows > 0 || $stmtLgbtqBoth->affected_rows > 0) {
            echo "Contestants Added to Finalist!";
        } else {
            echo "No Contestants Added!";
        }

        $stmtFE->close();
        $stmtMA->close();
        $stmtLgbtqLes->close();
    $stmtLgbtqGay->close();
    $stmtBothFM->close();
    $stmtLgbtqBoth->close();
        
        }

        else {
            echo "Error preparing statement: " . $db->error;
        }

    } else {
        echo "Error resetting is_finalist column: " . $db->error;
    }
    
    $db->close();
}

?>
