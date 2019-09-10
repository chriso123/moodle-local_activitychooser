<?php

defined('MOODLE_INTERNAL') || die();
global $ADMIN;

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_activitychooser', get_string('pluginname', 'local_activitychooser'));
    $ADMIN->add('localplugins', $settings);

    $settings->add(new admin_setting_configcheckbox('local_activitychooser/enable_in_nonedit_mode',
                                                    get_string('enablenonedit', 'local_activitychooser'),
                                                    get_string('enablenonedit_description', 'local_activitychooser'),
                                                    0));
}