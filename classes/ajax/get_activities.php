<?php

namespace local_activitychooser\ajax;

class get_activities extends \external_api {
    public static function service_parameters() {
        return new \external_function_parameters(
            [
                'course' => new \external_value(PARAM_INT, 'Course id', VALUE_REQUIRED),
                'sectionnum' => new \external_value(PARAM_INT, 'Section id', VALUE_OPTIONAL)
            ]
        );
    }

    public static function service_returns() {
        return new \external_single_structure(
                [
                        'starred'     => self::return_value_structure(),
                        'recommended' => self::return_value_structure(),
                        'all'         => self::return_value_structure(),
                ]);
    }

    private static function return_value_structure() {
        return new \external_multiple_structure(
                new \external_single_structure(
                        [
                                'id'      => new \external_value(PARAM_INT, 'id of activity in modules table', VALUE_REQUIRED),
                                'name'    => new \external_value(PARAM_ALPHANUMEXT, 'Database name of activity', VALUE_REQUIRED),
                                'label'   => new \external_value(PARAM_RAW, 'Localised name of activity', VALUE_REQUIRED),
                                'icon'    => new \external_value(PARAM_RAW, 'Icon url', VALUE_REQUIRED),
                                'help'    => new \external_value(PARAM_RAW, 'Description of activity', VALUE_REQUIRED),
                                'link'    => new \external_value(PARAM_URL, 'Link to add activity site', VALUE_REQUIRED),
                                'starred' => new \external_value(PARAM_RAW, 'Bool if item is starred', VALUE_REQUIRED),
                        ]
                )
        );
    }

    public static function service($course, $sectionnum) {
        $params  = self::validate_parameters(self::service_parameters(), [
            'course' => $course,
            'sectionnum' => $sectionnum
        ]);

        $activites = new \local_activitychooser\get_activities();
        return json_encode($activites->get_activities($params['sectionnum'], $params['course']));
    }
}