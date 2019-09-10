<?php

namespace local_activitychooser\ajax;

class toggle_starred extends \external_api {
    public static function service_parameters() {
        return new \external_function_parameters(
                [
                        'activityid' => new \external_value(PARAM_INT, 'Activity id', VALUE_REQUIRED),
                ]
        );
    }

    public static function service_returns() {
        return new \external_value(PARAM_BOOL, 'Boolean if adding/removing starred item succeeded');
    }

    public static function service($activityid) {
        $params = self::validate_parameters(self::service_parameters(), [
                'activityid' => $activityid,
        ]);

        $toggle = new \local_activitychooser\toggle_starred();
        return $toggle->toggle($params['activityid']);
    }
}