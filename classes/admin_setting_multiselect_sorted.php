<?php

namespace local_activitychooser;

defined('MOODLE_INTERNAL') || die();

class admin_setting_multiselect_sorted extends \admin_setting_configmultiselect_modules {
    /**
     * Just override output function, rest should be fine in parent classes.
     *
     * @param array  $data
     * @param string $query
     * @return string
     * @throws \coding_exception
     */
    public function output_html($data, $query = '') {
        global $OUTPUT;

        if (!$this->load_choices() or empty($this->choices)) {
            return '';
        }

        $default = $this->get_defaultsetting();
        if (is_null($default)) {
            $default = array();
        }
        if (is_null($data)) {
            $data = array();
        }

        $context = (object) [
                'id'   => $this->get_id(),
                'name' => $this->get_full_name(),
                'size' => min(10, count($this->choices))
        ];

        $defaults = [];
        $options  = [];
        $optionsselected  = [];
        $template = 'local_activitychooser/setting_configmultiselect_sort';

        foreach ($this->choices as $value => $name) {
            if (in_array($value, $default)) {
                $defaults[] = $name;
            }
            if (in_array($value, $data)) {
                $optionsselected[] = [
                        'value'    => $value,
                        'name'     => $name,
                        'selected' => false,
                ];
            } else {
                $options[] = [
                        'value'    => $value,
                        'name'     => $name,
                        'selected' => false,
                ];
            }

        }

        $context->options = $options;
        $context->optionsselected = $optionsselected;

        if (is_null($default)) {
            $defaultinfo = null;
        }
        if (!empty($defaults)) {
            $defaultinfo = implode(', ', $defaults);
        } else {
            $defaultinfo = get_string('none');
        }

        $element = $OUTPUT->render_from_template($template, $context);

        return format_admin_setting($this, $this->visiblename, $element, $this->description, true, '', $defaultinfo, $query);
    }
}