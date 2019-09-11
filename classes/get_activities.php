<?php

namespace local_activitychooser;

class get_activities {
    public function get_activities($sectionnum = null) {
        global $DB, $USER, $OUTPUT, $COURSE, $CFG;
        require_once($CFG->dirroot . '/course/lib.php');

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
            $mod                 = $this->get_module_information($module);
            $retval['starred'][] = $mod;
        }

        $acts = [];
        foreach ($activities as $id => $activity) {
            $acts[$activity->name] = $activity->name;
        }

        $acts        = get_module_types_names();
        $modules     = get_module_metadata($COURSE, $acts, $sectionnum);
        $recommended = get_config('local_activitychooser', 'recommended')
                ? explode(',', get_config('local_activitychooser', 'recommended'))
                : [];

        foreach ($modules as $module) {
            $mod = $this->get_module_information($module);
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

    private function get_module_information($module) {
        global $DB;
        return [
                'id'   => $DB->get_field('modules', 'id', ['name' => $module->name]),
                'name' => $module->name,
                'icon' => $module->icon,
                'help' => $module->help,
                'link' => $module->link->out(),
        ];
    }
}