<?php

namespace local_activitychooser;

defined('MOODLE_INTERNAL') || die();

class get_activities {
    public function get_activities($sectionnum = null, $courseid = null) {
        global $DB, $USER, $COURSE, $CFG, $PAGE;
        require_once($CFG->dirroot . '/course/lib.php');

        $course = $courseid !== null ? get_course($courseid) :  $COURSE;

        $PAGE->set_context(\context_system::instance());

        $retval = [
                'starred'     => [],
                'recommended' => [],
                'all'         => [],
        ];

        $table      = 'local_activitychooserstarred';
        $starred    = $DB->get_records($table, ['userid' => $USER->id], 'sortorder ASC');
        $activities = $DB->get_records('modules', [], 'id ASC');

        $chosenstarred = [];

        foreach ($starred as $favorite) {
            $name                 = $DB->get_field('modules', 'name', ['id' => $favorite->activityid]);
            $chosenstarred[$name] = $name;
        }

        $starredmodules = get_module_metadata($course, $chosenstarred, $sectionnum);

        foreach ($starred as $star) {
            foreach ($starredmodules as $module) {
                $mod = $this->get_module_information($module, $sectionnum);
                if ($star->activityid == $mod['id']) {
                    $retval['starred'][] = $mod;
                }
            }
        }

        $acts = [];
        foreach ($activities as $id => $activity) {
            $acts[$activity->name] = $activity->name;
        }

        $acts    = get_module_types_names();
        $modules = get_module_metadata($course, $acts, $sectionnum);

        $recommended = get_config('local_activitychooser', 'recommended_sorted')
                ? explode(',', get_config('local_activitychooser', 'recommended_sorted'))
                : [];

        $tmp = [];
        foreach ($modules as $module) {
            $mod = $this->get_module_information($module, $sectionnum);
            $rec = false;
            foreach ($recommended as $value) {
                if ($value == $mod['id']) {
                    $rec = true;
                }
            }
            if ($rec) {
                $tmp[] = $mod;
            } else {
                $retval['all'][$mod['id']] = $mod;
            }
        }

        // Resort recommended because get_module_metadata ignores sort order and loads resources first.
        foreach ($recommended as $rec) {
            foreach ($tmp as $module) {
                if ($rec == $module['id']) {
                    $retval['recommended'][] = $module;
                }
            }
        }

        sort($retval['all']);

        return $retval;
    }

    private function get_module_information($module, $sectionnum) {
        global $DB, $USER;
        $activityid = $DB->get_field('modules', 'id', ['name' => $module->name]);
        return [
                'id'      => $activityid,
                'name'    => $module->name,
                'label'   => get_string("modulename", "$module->name"),
                'icon'    => $module->icon,
                'help'    => $module->help,
                'link'    => $module->link->out() . "&section=$sectionnum",
                'starred' => $DB->record_exists('local_activitychooserstarred',
                                                ['userid' => $USER->id, 'activityid' => $activityid])
        ];
    }
}