<?php

namespace local_activitychooser;

class toggle_starred {
    public function toggle($activityid) {
        global $DB, $USER;

        $conditions = ['userid' => $USER->id, 'activityid' => $activityid];
        $table = 'local_activitychooserstarred';
        if($DB->record_exists($table, $conditions)) {
            $conditions['id'] = $DB->get_field($table, 'id', $conditions, MUST_EXIST);
            $DB->delete_records($table, $conditions);
        } else {
            $conditions['sortorder'] = 0; // TODO get highest count from database
            $DB->insert_record($table, (object)$conditions);
        }

        return true; // it is true - else db would return exception...
    }
}