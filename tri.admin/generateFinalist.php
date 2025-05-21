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

            // Update finalists for FE category
            $sqlUpdateFE = "UPDATE contestant AS c
                            JOIN (
                                    SELECT contestant_code 
                                    FROM (
                                        WITH ranked_contestants AS (
                                            SELECT SUM(po.score) AS overall_score, 
                                                po.contestant_code, 
                                                c.gender, 
                                            ROW_NUMBER() OVER(PARTITION BY c.gender ORDER BY SUM(po.score) DESC) AS gender_rank 
                                            FROM event_score AS po 
                                            INNER JOIN contestant AS c ON po.contestant_code = c.code 
                                            WHERE event_type_code = 'PR' 
                                            GROUP BY po.contestant_code, c.gender
                                        )
                                        SELECT overall_score, contestant_code, gender 
                                        FROM ranked_contestants 
                                            WHERE gender = 'F' AND gender_rank <= ?
                                        ORDER BY gender, gender_rank
                                    ) AS t
                            ) AS temp ON c.code = temp.contestant_code 
                            SET c.is_finalist = '1'
                            WHERE c.category_code = 'FE'";

        // Update finalists for MA category
        $sqlUpdateMA = "UPDATE contestant AS c
                        JOIN (
                                SELECT contestant_code 
                                FROM (
                                    WITH ranked_contestants AS (
                                        SELECT SUM(po.score) AS overall_score, 
                                            po.contestant_code, 
                                            c.gender, 
                                        ROW_NUMBER() OVER(PARTITION BY c.gender ORDER BY SUM(po.score) DESC) AS gender_rank 
                                        FROM event_score AS po 
                                        INNER JOIN contestant AS c ON po.contestant_code = c.code 
                                        WHERE event_type_code = 'PR' 
                                        GROUP BY po.contestant_code, c.gender
                                    )
                                    SELECT overall_score, contestant_code, gender 
                                    FROM ranked_contestants 
                                        WHERE gender = 'M' AND gender_rank <= ?
                                    ORDER BY gender, gender_rank
                                ) AS t
                        ) AS temp ON c.code = temp.contestant_code 
                        SET c.is_finalist = '1'
                        WHERE c.category_code = 'MA'";

        // Update finalists for LGBTQ-LES category
        $sqlUpdateLgbtqLes = "UPDATE contestant AS c
                            JOIN (
                                    SELECT contestant_code 
                                    FROM (
                                        WITH ranked_contestants AS (
                                            SELECT SUM(po.score) AS overall_score, 
                                                po.contestant_code, 
                                                c.gender, 
                                            ROW_NUMBER() OVER(PARTITION BY c.gender ORDER BY SUM(po.score) DESC) AS gender_rank 
                                            FROM event_score AS po 
                                            INNER JOIN contestant AS c ON po.contestant_code = c.code 
                                            WHERE event_type_code = 'PR' 
                                            GROUP BY po.contestant_code, c.gender
                                        )
                                        SELECT overall_score, contestant_code, gender 
                                        FROM ranked_contestants 
                                            WHERE gender = 'LGBTQ-F' AND gender_rank <= ?
                                        ORDER BY gender, gender_rank
                                    ) AS t
                            ) AS temp ON c.code = temp.contestant_code 
                            SET c.is_finalist = '1'
                            WHERE c.category_code = 'LGBTQ-LES'";

        // Update finalists for LGBTQ-GAY category
        $sqlUpdateLgbtqGay = "UPDATE contestant AS c
                            JOIN (
                                    SELECT contestant_code 
                                    FROM (
                                        WITH ranked_contestants AS (
                                            SELECT SUM(po.score) AS overall_score, 
                                                po.contestant_code, 
                                                c.gender, 
                                            ROW_NUMBER() OVER(PARTITION BY c.gender ORDER BY SUM(po.score) DESC) AS gender_rank 
                                            FROM event_score AS po 
                                            INNER JOIN contestant AS c ON po.contestant_code = c.code 
                                            WHERE event_type_code = 'PR' 
                                            GROUP BY po.contestant_code, c.gender
                                        )
                                        SELECT overall_score, contestant_code, gender 
                                        FROM ranked_contestants 
                                            WHERE gender = 'LGBTQ-M' AND gender_rank <= ?
                                        ORDER BY gender, gender_rank
                                    ) AS t
                            ) AS temp ON c.code = temp.contestant_code 
                            SET c.is_finalist = '1'
                            WHERE c.category_code = 'LGBTQ-GAY'";                    

        // Prepare and bind the parameters to prevent SQL injection
        if (($stmtFE = $db->prepare($sqlUpdateFE)) && ($stmtMA = $db->prepare($sqlUpdateMA))  && ($stmtLgbtqLes = $db->prepare($sqlUpdateLgbtqLes)) && ($stmtLgbtqGay = $db->prepare($sqlUpdateLgbtqGay))) {
        $stmtFE->bind_param("i", $feLimit); // Assuming $feLimit is an integer
        $stmtMA->bind_param("i", $maLimit); // Assuming $maLimit is an integer
        $stmtLgbtqLes->bind_param("i", $lesLimit); // Assuming $feLimit is an integer
        $stmtLgbtqGay->bind_param("i", $gayLimit); // Assuming $maLimit is an integer
        
        // Execute FE category update
        $stmtFE->execute();

        // Execute MA category update
        $stmtMA->execute();

        // Execute LES category update
        $stmtLgbtqLes->execute();

        // Execute GAY category update
        $stmtLgbtqGay->execute();

        // Check if any update was successful
        if ($stmtFE->affected_rows > 0 || $stmtMA->affected_rows > 0 || $stmtLgbtqLes->affected_rows > 0 || $stmtLgbtqGay->affected_rows > 0) {
            echo "Contestants Added to Finalist!";
        } else {
            echo "No Contestants Added!";
        }

        $stmtFE->close();
        $stmtMA->close();
        $stmtLgbtqLes->close();
        $stmtLgbtqGay->close();
        
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
