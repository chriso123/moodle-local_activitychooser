<?php

namespace local_activitychooser;

defined('MOODLE_INTERNAL') || die();

class get_activities {
    public function get_activities($sectionnum = null) {
        global $DB, $USER, $COURSE, $CFG, $PAGE;
        require_once($CFG->dirroot . '/course/lib.php');

        $PAGE->set_context(\context_system::instance());

        $retval = [
                'starred'     => [],
                'recommended' => [],
                'all'         => [],
        ];

        $table      = 'local_activitychooserstarred';
        $starred    = $DB->get_records($table, ['userid' => $USER->id]);
        $activities = $DB->get_records('modules');

        $chosenstarred = [];

        foreach ($starred as $favorite) {
            $name                 = $DB->get_field('modules', 'name', ['id' => $favorite->activityid]);
            $chosenstarred[$name] = $name;
        }

        $starredmodules = get_module_metadata($COURSE, $chosenstarred, $sectionnum);

        foreach ($starredmodules as $module) {
            $mod                 = $this->get_module_information($module, $sectionnum);
            $retval['starred'][] = $mod;
        }

        $acts = [];
        foreach ($activities as $id => $activity) {
            $acts[$activity->name] = $activity->name;
        }

        $acts    = get_module_types_names();
        $modules = get_module_metadata($COURSE, $acts, $sectionnum);

        $recommended = get_config('local_activitychooser', 'recommended')
                ? explode(',', get_config('local_activitychooser', 'recommended'))
                : [];

        foreach ($modules as $module) {
            $mod = $this->get_module_information($module, $sectionnum);
            $rec = false;
            foreach ($recommended as $value) {
                if ($value == $mod['id']) {
                    $rec = true;
                }
            }
            if ($rec) {
                $retval['recommended'][] = $mod;
            } else {
                $retval['all'][] = $mod;
            }

        }

        return $retval;
    }

    private function get_module_information($module, $sectionnum) {
        global $DB, $USER;
        $activityid = $DB->get_field('modules', 'id', ['name' => $module->name]);
        return [
                'id'    => $activityid,
                'name'  => $module->name,
                'label' => get_string("modulename", "$module->name"),
                'icon'  => $module->icon,
                'help'  => $module->help,
                'link'  => $module->link->out() . "&section=$sectionnum",
                'starred' => $DB->record_exists('local_activitychooserstarred', ['userid' => $USER->id, 'activityid' => $activityid])
        ];
    }
}