<?php

namespace local_activitychooser;

defined('MOODLE_INTERNAL') || die();

class toggle_starred {
    public function toggle($activityid) {
        global $DB, $USER;

        $conditions = ['userid' => $USER->id, 'activityid' => $activityid];
        $table = 'local_activitychooserstarred';
        if($DB->record_exists($table, $conditions)) {
            $conditions['id'] = $DB->get_field($table, 'id', $conditions, MUST_EXIST);
            $DB->delete_records($table, $conditions);
        } else {
            $max = $DB->get_records($table, ['userid' => $USER->id], 'sortorder DESC', 'sortorder', 0, 1);
            $conditions['sortorder'] = $max ? reset($max)->sortorder + 1 : 1;
            $DB->insert_record($table, (object)$conditions);
        }

        return true; // it is true - else db would throw exception...
    }
}