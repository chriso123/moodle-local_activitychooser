<?php

namespace local_activitychooser\ajax;

class change_starred_sortorder extends \external_api {
    public static function service_parameters() {
        return new \external_function_parameters(
                [
                        'leftneighbourid' => new \external_value(PARAM_INT,
                                                                 'Left neigbour activity id, zero if no left neighbor exist',
                                                                 VALUE_REQUIRED),
                        'activityid'      => new \external_value(PARAM_INT, 'Activity id of activity to sort', VALUE_REQUIRED),
                ]
        );
    }

    public static function service_returns() {
        return new \external_value(PARAM_BOOL, 'Bool if succeeded');
    }

    public static function service($leftneighbour, $activityid) {
        $params = self::validate_parameters(self::service_parameters(), [
                'leftneighbourid' => $leftneighbour,
                'activityid'      => $activityid,
        ]);

        $sort = new \local_activitychooser\change_starred_sortorder();
        $sort->change_sort_order($params['leftneighbourid'], $params['activityid']);
        return true;
    }
}