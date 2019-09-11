<?php

use local_activitychooser\admin_setting_multiselect_sorted;

defined('MOODLE_INTERNAL') || die();
global $ADMIN, $PAGE;

if ($hassiteconfig) {
    $PAGE->requires->js_call_amd('local_activitychooser/setting_configmultiselect', 'init');

    $settings = new admin_settingpage('local_activitychooser', get_string('pluginname', 'local_activitychooser'));
    $ADMIN->add('localplugins', $settings);

    $settings->add(new admin_setting_configcheckbox('local_activitychooser/enable_in_nonedit_mode',
                                                    get_string('enablenonedit', 'local_activitychooser'),
                                                    get_string('enablenonedit_description', 'local_activitychooser'),
                                                    0));

    $modules = get_module_types_names();
    $settings->add(new admin_setting_multiselect_sorted('local_activitychooser/recommended_sorted',
                                                        get_string('recommended', 'local_activitychooser'),
                                                        get_string('recommended_description', 'local_activitychooser')));
}