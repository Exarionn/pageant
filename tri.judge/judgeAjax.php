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

if(isset($_POST['event_category'], $_POST['event_judge'], $_POST['category_judge'])) {
    $event_category = sanitizeInput($_POST['event_category']);
    $event_judge = sanitizeInput($_POST['event_judge']);
    $category_judge = sanitizeInput($_POST['category_judge']);
    $conGeneral = isset($_POST['conGeneral']) ? $_POST['conGeneral'] : 0;

    // Fetch contestants strictly by judge's category
    $contestants = [];
    $q = contestantCategoryByJudge; // expects one parameter: category_code
    $stmt = $db->prepare($q);
    $stmt->bind_param("s", $category_judge);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res) {
        while ($r = $res->fetch_assoc()) { $contestants[] = $r; }
    }

    // Fetch criteria into an array
    $criteriaRows = [];
    $stmt = $db->prepare(criteriaList);
    $stmt->bind_param("s", $event_category);
    $stmt->execute();
    $resCrit = $stmt->get_result();
    if ($resCrit) {
        while ($row = $resCrit->fetch_assoc()) { $criteriaRows[] = $row; }
    }

    if (count($criteriaRows) === 0) {
        echo "<h4 align='center'>No Criteria Found</h4>";
        exit;
    }

    // Fetch event name
    $eventName = '';
    $stmt = $db->prepare(eventListPreliminaryList);
    $stmt->bind_param("s", $event_category);
    $stmt->execute();
    $resEvent = $stmt->get_result();
    if ($resEvent && ($fe = $resEvent->fetch_assoc())) { $eventName = $fe['event_name']; }

    // Build HTML
    $html = '';
    $html .= '<h3 class="mt-4 text-muted" align="center">'. htmlspecialchars($eventName) .'</h3>';
    $html .= '<div class="card-body table-responsive-sm">';
    $html .= '<table class="table table-hover" id="data">';
    $html .= '<thead><tr><th><div class="small" align="center">Candidate No.</div></th>';

    foreach ($criteriaRows as $c) {
        $html .= '<th><div class="small ms-3 me-3" align="center">'. htmlspecialchars($c['criteria_name']) .'('. htmlspecialchars($c['percent']) .')</div></th>';
    }

    $html .= '<th><div class="small"></div></th></tr></thead><tbody>';

    if (count($contestants) === 0) {
        $html .= '<tr><td colspan="50" align="center"><h4 class="text-muted">No contestants found for your assigned category.</h4></td></tr>';
    } else {
        foreach ($contestants as $cont) {
            $contestantCode = htmlspecialchars($cont['code']);
            $contestantSequence = htmlspecialchars($cont['sequence']);
            $contestantGender = isset($cont['gender']) ? htmlspecialchars($cont['gender']) : '';
            $eventTypeCode = 'PR';

            $html .= '<tr>';
            $html .= '<td><div class="small text-center">'. $contestantSequence;
            if ($contestantGender !== '' && $conGeneral == 0) { $html .= ' - '. $contestantGender .' '; }
            $html .= '</div></td>';

            $html .= '<input type="hidden" name="generateKeyCode[]" value="'. generateKey(eventScoreLast, 6) .'" />';
            $html .= '<input type="hidden" name="judgeCategoryCode" value="'. $category_judge .'" />';
            $html .= '<input type="hidden" name="contestantCode" value="'. $contestantCode .'" />';
            $html .= '<input type="hidden" name="eventTypeCode" value="'. $eventTypeCode .'" />';
            $html .= '<input type="hidden" name="judgesCode" value="'. $event_judge .'" />';

            // Criteria inputs
            foreach ($criteriaRows as $cr) {
                $html .= '<input type="hidden" name="criteriaCode[]" value="'. htmlspecialchars($cr['code']) .'" />';
                $html .= '<td><div class="col-lg-12"><input type="text" name="score[]" class="judge form-control" placeholder="Enter in Decimal" maxlength="5" required data-percent="'. htmlspecialchars($cr['percent']) .'" /></div></td>';
            }

            $html .= '<td class="col-sm-2" style="width: 185px"><button data-event="'. htmlspecialchars($event_category) .'" data-category="'. htmlspecialchars($category_judge) .'" data-contestant="'. $contestantCode .'" data-eventtype="'. $eventTypeCode .'" data-judges="'. htmlspecialchars($event_judge) .'" class="insertScoreCode btn btn-outline-success btn-sm mt-1 rounded">Submit</button></td>';
            $html .= '</tr>';
        }
    }

    $html .= '</tbody></table></div>';

    echo $html;
}
?>
<script>
$(document).ready(function() {
    $('.judge').on('input', function() {
        var value = this.value;
        var percentage = $(this).data('percent') || 100;
        value = value.replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1');
        if(parseFloat(value) < 1.00) { value = '1.00'; }
        else if(parseFloat(value) > percentage) { value = percentage.toString(); }
        this.value = value;
    });

    $('.insertScoreCode').on('click', function() {
        var generated = $(this).data('generated');
        var judgeCategoryCode = $(this).data('category');
        var eventCode = $(this).data('event');
        var eventTypeCode = $(this).data('eventtype'); 
        var contestantCode = $(this).data('contestant');
        var judgesCode = $(this).data('judges');

        var criteriaCodes = $(this).closest('tr').find('input[name="criteriaCode[]"]').map(function() { return $(this).val(); }).get();
        var scores = $(this).closest('tr').find('input[name="score[]"]').map(function() { return $(this).val(); }).get();
        var generateKeyCodes = $(this).closest('tr').find('input[name="generateKeyCode[]"]').map(function() { return $(this).val(); }).get();

        if (!isValidInput(scores)) {
            Swal.fire({ title: 'Please Fill in the Field!', icon: 'warning', timer: 1800, showConfirmButton: false, timerProgressBar: true });
            return;
        }

        var formData = new FormData();
        formData.append('generated', generated);
        formData.append('judgeCategoryCode', judgeCategoryCode);
        formData.append('eventCode', eventCode);
        formData.append('eventTypeCode', eventTypeCode);
        formData.append('contestantCode', contestantCode);
        formData.append('judgesCode', judgesCode);

        criteriaCodes.forEach(function(criteriaCode, index) {
            formData.append('criteriaCodes[]', criteriaCode);
            formData.append('scores[]', scores[index]);
            formData.append('generateKeyCodes[]', generateKeyCodes[index]);
        });

        $.ajax({ type: 'POST', url: 'judgeCode.php', data: formData, contentType: false, processData: false,
            success: function(response) { Swal.fire({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, icon: 'success', title: 'Score Submitted!' }); },
            error: function(error) { console.error(error); }
        });
    });

    function isValidInput(scores) {
        for (var i = 0; i < scores.length; i++) {
            if (scores[i] === '' || isNaN(scores[i])) { return false; }
        }
        return true;
    }
});
</script>
<script>


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
