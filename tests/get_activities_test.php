<?php

use local_activitychooser\get_activities;

defined('MOODLE_INTERNAL') || die();

class get_activities_test extends advanced_testcase {
    public function setUp() {
        // Setup a course and enrol a teacher within
        $course = $this->getDataGenerator()->create_course();
        $user   = $this->getDataGenerator()->create_and_enrol($course, 'editingteacher');

        $this->setUser($user);

        global $COURSE;
        $COURSE = $course;
    }

    public function test_get_all_activities_as_teacher() {
        $this->resetAfterTest(true);

        $activities = new get_activities();
        $all        = $activities->get_activities(0);

        global $DB;
        $compare = $DB->count_records('modules', ['visible' => 1]);

        $this->assertEquals(0, count($all['starred']), 'There are no starred activities');
        $this->assertEquals(0, count($all['recommended']), 'There are no recommended activities');
        $this->assertEquals($compare, count($all['all']),
                            'All activities that are enabled should be in the all section of the array');
    }

    public function test_get_activities_with_starred_as_teacher() {
        $this->resetAfterTest(true);

        global $USER, $DB;

        // Teacher has starred assign, resource and quiz activity
        $starred             = new stdClass();
        $starred->userid     = $USER->id;
        $starred->activityid = 1;
        $starred->sortorder  = 0;
        $table               = 'local_activitychooserstarred';
        $DB->insert_record($table, $starred);
        $starred->activityid = 16;
        $DB->insert_record($table, $starred);
        $starred->activityid = 17;
        $DB->insert_record($table, $starred);

        $activities = new get_activities();
        $all        = $activities->get_activities(0);

        $compare = $DB->count_records('modules', ['visible' => 1]);

        $this->assertEquals(3, count($all['starred']), 'Three activites are starred');
        $this->assertEquals(0, count($all['recommended']), 'There are no recommended activities');
        $this->assertEquals($compare, count($all['all']),
                            'All activities that are enabled should be in the all section of the array');
    }

    public function test_get_activities_with_recommended_as_teacher() {
        $this->resetAfterTest(true);

        global $DB;
        // Workshop, folder, url and feedback are recommended
        set_config('recommended', '7,8,20,22', 'local_activitychooser');

        $activities = new get_activities();
        $all        = $activities->get_activities(0);

        $compare = $DB->count_records('modules', ['visible' => 1]);

        $this->assertEquals(0, count($all['starred']), 'There are no starred activities');
        $this->assertEquals(4, count($all['recommended']), 'There are four recommended activities');
        $this->assertEquals($compare, count($all['all']) + count($all['recommended']),
                            'Recommended added to all should be all enabled activities');
    }
}