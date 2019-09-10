<?php

use local_activitychooser\toggle_starred;

defined('MOODLE_INTERNAL') || die();

class toggle_starred_test extends advanced_testcase {
    public function test_add_starred_item() {
        $this->resetAfterTest(true);
        $user = $this->getDataGenerator()->create_user();

        $this->setUser($user);
        $item = new stdClass();

        $toggle = new toggle_starred();
        $toggle->toggle(1);

        global $DB;
        $records = $DB->get_records('local_activitychooserstarred');
        $record = reset($records);
        $this->assertEquals($user->id, $record->userid);
        $this->assertEquals(1, $record->activityid);
    }

    public function test_remove_starred_item() {
        $this->resetAfterTest(true);
        $user = $this->getDataGenerator()->create_user();

        $this->setUser($user);
        $item = new stdClass();

        $toggle = new toggle_starred();
        $toggle->toggle(1);
        $toggle->toggle(1);

        global $DB;
        $records = $DB->get_records('local_activitychooserstarred');
        $this->assertEmpty($records);
    }
}