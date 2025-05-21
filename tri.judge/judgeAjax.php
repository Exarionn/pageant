<?php
// Ensure that errors are properly handled and not displayed to users
ini_set('display_errors', 0);
error_reporting(0);

require '../include/connector/dbconn.php';
include "../include/generatedKey.php"; 
include "../include/query.php"; 
include "../include/settings.php"; 

// Function to sanitize user inputs
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

// Function to validate input data
function validateInput($input) {
    // Perform validation logic here
    // For example, check if input is not empty, is within expected range, etc.
    return !empty($input); // For demonstration purposes, simple check for non-empty values
}

if(isset($_POST['event_category'], $_POST['event_judge'], $_POST['category_judge'])) {
    $event_category = sanitizeInput($_POST['event_category']);
    $event_judge = sanitizeInput($_POST['event_judge']);
    $category_judge = sanitizeInput($_POST['category_judge']);
    $conGeneral = $_POST['conGeneral'];


    // Initialize an array to hold contestant data
    $contestantsFemaleMale = [];
    $contestantsLgbtq = [];

    // Fetch contestant female and male list using parameterized query
    $eventContestantQuery = contestantListFemaleMaleBoth;
    $stmt = $db->prepare($eventContestantQuery);
    $stmt->execute();
    $resultEventContestant = $stmt->get_result();

    if ($resultEventContestant) {
        while ($row = $resultEventContestant->fetch_assoc()) {
            $contestantsFemaleMale[] = $row;
        }
    } else {
        // Handle database query error without revealing sensitive information
        echo "Error fetching contestant list";
        exit;
    }

    // Fetch contestant Lgbtq female and male list using parameterized query
    $eventContestantQuery = contestantListLgbtq;
    $stmt = $db->prepare($eventContestantQuery);
    $stmt->execute();
    $resultEventContestant = $stmt->get_result();

    if ($resultEventContestant) {
        while ($row = $resultEventContestant->fetch_assoc()) {
            $contestantsLgbtq[] = $row;
        }
    } else {
        // Handle database query error without revealing sensitive information
        echo "Error fetching contestant list";
        exit;
    }

    // Fetch criteria list using parameterized query
    $eventCriteriaQuery = criteriaList;
    $stmt = $db->prepare($eventCriteriaQuery);
    $stmt->bind_param("s", $event_category);
    $stmt->execute();
    $resultEventCriteria = $stmt->get_result();

    if ($resultEventCriteria->num_rows <= 0) {
        echo "<h4 align='center'>No Criteria Found</h4>";
        exit;
    }

    // Build HTML for criteria table
    $criteria = '';

    // Fetch event details using parameterized query
    $eventQuery = eventListPreliminaryList;
    $stmt = $db->prepare($eventQuery);
    $stmt->bind_param("s", $event_category);
    $stmt->execute();
    $resultEvent = $stmt->get_result();
    $fetchResultEvent = $resultEvent->fetch_assoc();

    // Include event name in HTML if available
    if($fetchResultEvent != NULL){
        $criteria .= '<h3 class="mt-4 text-muted" align="center">'.$fetchResultEvent['event_name'].'</h3>';
    } else {
        $criteria .= '<h3 class="mt-4 text-muted" align="center"></h3>';
    }

    // Build table header
    $criteria .= '<div class="card-body table-responsive-sm">
                    <table class="table table-hover" id="data">
                        <thead>
                            <tr>
                                <th>
                                    <div class="small" align="center">Candidate No.</div>
                                </th>';

    // Add criteria headers
    while ($eventCriteriaResult = $resultEventCriteria->fetch_assoc()) {
        $criteriaHeader = $eventCriteriaResult['criteria_name'];
        $criteriaHeaderPercent = $eventCriteriaResult['percent'];
        $criteria .= '<th>
                            <div class="small ms-3 me-3" align="center">'.$criteriaHeader.'('.$criteriaHeaderPercent.')</div>
                      </th>';
    }

    // Add buttons header
    $criteria .= '              <th>
                                    <div class="small"></div>
                                </th>
                            </tr>
                        </thead>
                    <tbody>';

    // get category of judge list
    $eventCategoryByjudgeQuery = judgeByCategoryList;
    $stmt = $db->prepare($eventCategoryByjudgeQuery);
    $stmt->bind_param("s", $event_judge);
    $stmt->execute();
    $resultEventCategoryByjudge = $stmt->get_result();
    $fetchResultEventCategoryByJudge = $resultEventCategoryByjudge->fetch_assoc();

//start
if($resultEventCategoryByjudge->num_rows > 0) {
    $judgeCategory = $fetchResultEventCategoryByJudge['category'];
    $judgeCategoryIsBoth = $fetchResultEventCategoryByJudge['is_both'];
    
    
    // echo $judgeCategoryIsBoth;
    // echo $judgeCategory;

    $eventContestantCategoryByJudgeQuery = contestantCategoryByJudge;
    $stmt = $db->prepare($eventContestantCategoryByJudgeQuery);
    $stmt->bind_param("s", $judgeCategory);
    $stmt->execute();
    $resultEventContestantCategoryByJudge = $stmt->get_result();


    if($judgeCategoryIsBoth == "0") {

        echo "here1";
                foreach ($resultEventContestantCategoryByJudge as $eventContestantResult) {
                    $contestantCode = htmlspecialchars($eventContestantResult['code']);            
                    $contestantSequence = htmlspecialchars($eventContestantResult['sequence']);
                    $contestantName = htmlspecialchars($eventContestantResult['name']);
                    $contestantCategory = isset($eventContestantResult['category_code']) ? htmlspecialchars($eventContestantResult['category_code']) : '';
                    $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                    $eventTypeCode = htmlspecialchars('PR');
    
                    $criteria .= '
                                <tr>
                                    <td>
                                        <div class="small text-center">
                                        '. $contestantSequence .' ';

                    if ($contestantGender != null && $conGeneral == 0) {
                        // Add your content when $contestantGender is true
                        $criteria .= ' - '. $contestantGender .' ';
                    }
                    else{
                        $criteria .= '';
                    }
                                            
                        $criteria .= '                
                                        </div>
                                    </td>
                                    <input type="hidden" name="generateKeyCode[]" value="'. generateKey(eventScoreLast, 6) .'" />
                                    <input type="hidden" name="judgeCategoryCode" value="'. $category_judge .'" />
                                    <input type="hidden" name="contestantCode" value="'. $contestantCode.'" />
                                    <input type="hidden" name="eventTypeCode" value="'.$eventTypeCode.'" />
                                    <input type="hidden" name="judgesCode" value="'. $event_judge.'" />
                                    ';
    
                        if ($resultEventCriteria->num_rows > 0) {
                            foreach ($resultEventCriteria as $eventCriteriaResult) {
                                $criteriaCode = $eventCriteriaResult['code'];
                                $criteriaPercent = $eventCriteriaResult['percent'];
                                $criteria .= '
                                    <input type="hidden" name="criteriaCode[]" value="'. $criteriaCode.'" />
                                    <td>
                                        <div class="col-lg-12">
                                            <input type="text" name="score[]" class="judge form-control" placeholder="Enter in Decimal" value="" maxlength="5" required data-percent="'.$criteriaPercent.'"/>
                                        </div>
                                    </td>';
                            }
                        }
    
                        $criteria .= '
                                    <td class="col-sm-2" style="width: 185px">
                                        <button data-event="'.$event_category.'" data-category="'.$category_judge.'" data-contestant="'.$contestantCode.'" data-eventtype="'.$eventTypeCode.'" data-judges="'.$event_judge.'" class="insertScoreCode btn btn-outline-success btn-sm mt-1 rounded">Submit</button>
                                    </td>
                                </tr>';
    
                    }
    }
    else {

        //both Female and Male
        if ($judgeCategoryIsBoth == "1") {
            echo "here2";

            foreach ($contestantsFemaleMale as $eventContestantResult) {
                $contestantCode = htmlspecialchars($eventContestantResult['code']);            
                $contestantSequence = htmlspecialchars($eventContestantResult['sequence']);
                $contestantName = htmlspecialchars($eventContestantResult['name']);
                $contestantCategory = isset($eventContestantResult['category_code']) ? htmlspecialchars($eventContestantResult['category_code']) : '';
                $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                $eventTypeCode = htmlspecialchars('PR');

                $criteria .= '
                        <tr>
                            <td>
                                <div class="small text-center">
                                '. $contestantSequence .' ';

                if ($contestantGender != null && $conGeneral == 0) {
                    // Add your content when $contestantGender is true
                    $criteria .= ' - '. $contestantGender .' ';
                }
                else{
                    $criteria .= '';
                }
                                        
                    $criteria .= '                
                                    </div>
                            </td>
                            <input type="hidden" name="generateKeyCode[]" value="'. generateKey(eventScoreLast, 6) .'" />
                            <input type="hidden" name="judgeCategoryCode" value="'. $category_judge .'" />
                            <input type="hidden" name="contestantCode" value="'. $contestantCode.'" />
                            <input type="hidden" name="eventTypeCode" value="'.$eventTypeCode.'" />
                            <input type="hidden" name="judgesCode" value="'. $event_judge.'" />
                            ';

                if ($resultEventCriteria->num_rows > 0) {
                    foreach ($resultEventCriteria as $eventCriteriaResult) {
                        $criteriaCode = $eventCriteriaResult['code'];
                        $criteriaPercent = $eventCriteriaResult['percent'];
                        $criteria .= '
                            <input type="hidden" name="criteriaCode[]" value="'. $criteriaCode.'" />
                            <td>
                                <div class="col-lg-12">
                                <input type="text" name="score[]" class="judge form-control" placeholder="Enter in Decimal" maxlength="5" required data-percent="'.$criteriaPercent.'" />
                                </div>
                            </td>';
                    }
                }

                $criteria .= '
                            <td class="col-sm-2" style="width: 185px">
                                <button data-event="'.$event_category.'" data-category="'.$category_judge.'" data-contestant="'.$contestantCode.'" data-eventtype="'.$eventTypeCode.'" data-judges="'.$event_judge.'" class="insertScoreCode btn btn-outline-success btn-sm mt-1 rounded">Submit</button>
                            </td>
                        </tr>';

                }
            }
            else{

                echo "here3";
                // Both LGBTQ GAY and LESBIAN
                foreach ($contestantsLgbtq as $eventContestantResult) {
                    $contestantCode = htmlspecialchars($eventContestantResult['code']);            
                    $contestantSequence = htmlspecialchars($eventContestantResult['sequence']);
                    $contestantName = htmlspecialchars($eventContestantResult['name']);
                    $contestantCategory = isset($eventContestantResult['category_code']) ? htmlspecialchars($eventContestantResult['category_code']) : '';
                    $contestantGender = isset($eventContestantResult['gender']) ? htmlspecialchars($eventContestantResult['gender']) : '';
                    $eventTypeCode = htmlspecialchars('PR');
    
                    $criteria .= '
                                <tr>
                                    <td>
                                        <div class="small text-center">
                                        '. $contestantSequence .' ';

                    if ($contestantGender != null && $conGeneral == 0) {
                        // Add your content when $contestantGender is true
                        $criteria .= ' - '. $contestantGender .' ';
                    }
                    else{
                        $criteria .= '';
                    }
                                            
                        $criteria .= '                
                                        </div>
                                    </td>
                                    <input type="hidden" name="generateKeyCode[]" value="'. generateKey(eventScoreLast, 6) .'" />
                                    <input type="hidden" name="judgeCategoryCode" value="'. $category_judge .'" />
                                    <input type="hidden" name="contestantCode" value="'. $contestantCode.'" />
                                    <input type="hidden" name="eventTypeCode" value="'.$eventTypeCode.'" />
                                    <input type="hidden" name="judgesCode" value="'. $event_judge.'" />
                                    ';
    
                        if ($resultEventCriteria->num_rows > 0) {
                            foreach ($resultEventCriteria as $eventCriteriaResult) {
                                $criteriaCode = $eventCriteriaResult['code'];
                                $criteriaPercent = $eventCriteriaResult['percent'];
                                $criteria .= '
                                    <input type="hidden" name="criteriaCode[]" value="'. $criteriaCode.'" />
                                    <td>
                                        <div class="col-lg-12">
                                            <input type="text" name="score[]" class="judge form-control" placeholder="Enter in Decimal" value="" maxlength="5" required data-percent="'.$criteriaPercent.'"/>
                                        </div>
                                    </td>';
                            }
                        }
    
                        $criteria .= '
                                    <td class="col-sm-2" style="width: 185px">
                                        <button data-event="'.$event_category.'" data-category="'.$category_judge.'" data-contestant="'.$contestantCode.'" data-eventtype="'.$eventTypeCode.'" data-judges="'.$event_judge.'" class="insertScoreCode btn btn-outline-success btn-sm mt-1 rounded">Submit</button>
                                    </td>
                                </tr>';
    
                    }
            }
                    //end
        }
    }

    $criteria .= '
                </tbody>
            </table>
        </div>';

    echo $criteria;
}
?>
<script>
    //convert to decimal
    $(document).ready(function() {
    $('.judge').on('input', function() {
        var value = this.value;
        
        // Retrieve the percentage value
        var percentage = $(this).data('percent'); 
        console.log("Percentage attribute:", percentage);
        
        // Ensure that the entered value is within the allowed range
        value = value.replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1');
        if(parseFloat(value) < 1.00) {
            value = '1.00'; // Set the minimum score to 1.00
        } else if(parseFloat(value) > percentage) {
            value = percentage.toString(); // Set the value to the maximum allowed score
            let timerInterval;
            Swal.fire({
                title: 'You Exceeeded the Maximum Percentage, Please Enter Your Desired Score Again!',
                icon: 'warning',
                timer: 5000,
                showConfirmButton: false,
                timerProgressBar: true,
                willClose: () => {
                    clearInterval(timerInterval);
                }
            });
        }
        
        this.value = value;
    });
});




    // Insert Score button click event
    $('.insertScoreCode').on('click', function() {
        var generated = $(this).data('generated');
        var judgeCategoryCode = $(this).data('category');
        var eventCode = $(this).data('event');
        var eventTypeCode = $(this).data('eventtype'); 
        var contestantCode = $(this).data('contestant');
        var judgesCode = $(this).data('judges');

        // Get an array of criteriaCode, scores, and generateKeyCodes
        var criteriaCodes = $(this).closest('tr').find('input[name="criteriaCode[]"]').map(function() {
            return $(this).val();
        }).get();

        var scores = $(this).closest('tr').find('input[name="score[]"]').map(function() {
            return $(this).val();
        }).get();

        var generateKeyCodes = $(this).closest('tr').find('input[name="generateKeyCode[]"]').map(function() {
            return $(this).val();
        }).get();

        if (!isValidInput(scores)) {
            // If validation fails, you can return or display an error message
            let timerInterval;
            Swal.fire({
                title: 'Please Fill in the Field!',
                icon: 'warning',
                timer: 1800,
                showConfirmButton: false,
                timerProgressBar: true,
                willClose: () => {
                    clearInterval(timerInterval);
                }
            });

            return;
        }

        // Ensure that scores, criteriaCodes, and generateKeyCodes are sent as arrays
        var formData = new FormData();
        formData.append('generated', generated);
        formData.append('judgeCategoryCode', judgeCategoryCode);
        formData.append('eventCode', eventCode);
        formData.append('eventTypeCode', eventTypeCode);
        formData.append('contestantCode', contestantCode);
        formData.append('judgesCode', judgesCode);

        // Append criteriaCodes, scores, and generateKeyCodes as arrays
        criteriaCodes.forEach(function(criteriaCode, index) {
            formData.append('criteriaCodes[]', criteriaCode);
            formData.append('scores[]', scores[index]);
            formData.append('generateKeyCodes[]', generateKeyCodes[index]);
        });

        $.ajax({
            type: 'POST',
            url: 'judgeCode.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Score Submitted!"
                });
            },
            error: function(error) {
                // Handle error
                console.error(error);
            }
        });
    });

    function isValidInput(scores) {
        // Check if any score is empty or not a valid number
        for (var i = 0; i < scores.length; i++) {
            if (scores[i] === '' || isNaN(scores[i])) {
                return false;
            }
        }
        return true;
    }

</script>
