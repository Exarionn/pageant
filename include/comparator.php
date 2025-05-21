<?php
function generateEventDropdownOptions($eventQuery, $db, $eventCodeColumn, $eventNameColumn, $selectedCode = null)
{
    $html = '';

    // Fetch events
    $resultEvent = mysqli_query($db, $eventQuery) or die("Event Query Unsuccessful.");

    // Generate options for event dropdown
    while ($rowEvent = mysqli_fetch_assoc($resultEvent)) {
        // Check if this event matches the selected code and add 'selected' attribute if it does
        $selected = ($rowEvent[$eventCodeColumn] == $selectedCode) ? 'selected' : '';
        $html .= '<option value="' . $rowEvent[$eventCodeColumn] . '" ' . $selected . '>' . $rowEvent[$eventNameColumn] . '</option>';
    }

    return $html;
}
?>
