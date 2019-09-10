<?php

function local_activitychooser_before_footer() {
    global $PAGE;

    $PAGE->requires->js_call_amd('local_activitychooser/main', 'init');
}