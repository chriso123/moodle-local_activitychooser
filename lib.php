<?php

function local_activitychooser_before_footer() {
    global $PAGE;

    if (!empty(get_config('local_activitychooser', 'enabled'))) {
        $PAGE->requires->js_call_amd('local_activitychooser/main', 'init');
    }
}