<?php

function local_helloworld_extend_navigation(global_navigation $nav) {
    return;
    $item = $nav->add('Hello World!', new moodle_url('/test/test.php'), navigation_node::TYPE_CUSTOM, null, null, new pix_icon('i/home', ''));
    $item->showinflatnavigation = true;
}

function local_helloworld_before_footer() {
    global $PAGE;

    $admin = get_admin();

    $params = [
        'adminemail' => $admin->email
    ];

    $PAGE->requires->js_call_amd('local_helloworld/main', 'init', $params);
}