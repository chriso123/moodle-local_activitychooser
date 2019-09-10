<?php

namespace local_activitychooser\ajax;

class get_activities extends \external_api
{
    public static function service_parameters()
    {
        return new \external_function_parameters(
                [
                        'sectionnum' => new \external_value(PARAM_INT, 'Section id', VALUE_OPTIONAL),
                ]
        );
    }

    public static function service_returns()
    {
        return new \external_value(PARAM_RAW, 'Metadata');
    }

    public static function service($sectionnum)
    {
        $params  = self::validate_parameters(self::service_parameters(), ['sectionnum' => $sectionnum]);

        $activites = new \local_activitychooser\get_activities();
        return json_encode($activites->get_activities($params['sectionnum']));
    }
}