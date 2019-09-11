<?php

namespace local_activitychooser;

class change_starred_sortorder {
    public function change_sort_order($neighbour, $activity) {
        global $DB, $USER;

        $table = 'local_activitychooserstarred';
        $items = $DB->get_records($table, ['userid' => $USER->id], 'sortorder ASC');

        $sortorder = 1;
        $activityitem = null;
        foreach($items as $item) {
            if($item->activityid == $activity) {
                $activityitem = $item;
            }
        }
        foreach($items as $item) {
            if($item->activityid == $neighbour) {
                $item->sortorder = $sortorder;
                $DB->update_record($table, $item);
                $sortorder++; // Increase by one for the new neigbour.
                $activityitem->sortorder = $sortorder;
                $DB->update_record($table, $activityitem);
            } else if ($item->activityid == $activity) {
                // Skip the current item it will be updated to be right of neigbour.
                continue;
            } else {
                $item->sortorder = $sortorder;
                $DB->update_record($table, $item);
            }
            $sortorder++;
        }
    }
}