<?php

use local_activitychooser\toggle_starred;

defined('MOODLE_INTERNAL') || die();

class toggle_starred_test extends advanced_testcase {
    public function setUp() {
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
    }

    public function test_add_starred_item() {
        $this->resetAfterTest(true);

        global $DB, $USER;

        $toggle = new toggle_starred();
        $toggle->toggle(1);

        $records = $DB->get_records('local_activitychooserstarred');
        $record = reset($records);
        $this->assertEquals($USER->id, $record->userid);
        $this->assertEquals(1, $record->activityid);
    }

    public function test_remove_starred_item() {
        $this->resetAfterTest(true);

        global $DB;

        $toggle = new toggle_starred();
        $toggle->toggle(3);
        $records = $DB->get_records('local_activitychooserstarred');
        $this->assertEquals(1, count($records));

        $toggle->toggle(3);

        $records = $DB->get_records('local_activitychooserstarred');
        $this->assertEmpty($records);
    }

    public function test_sort_order_on_starring() {
        $this->resetAfterTest(true);

        global $DB, $USER;

        $toggle = new toggle_starred();
        $toggle->toggle(1);
        $toggle->toggle(3);
        $toggle->toggle(22);
        $toggle->toggle(8);

        $records = $DB->get_records('local_activitychooserstarred', ['userid' => $USER->id]);
        $this->assertEquals(4, count($records));
        $this->assertEquals(1, reset($records)->sortorder);
        $this->assertEquals(4, end($records)->sortorder);

        // Remove first element - first element sortorder then should have the value 2
        $toggle->toggle(1);

        $records = $DB->get_records('local_activitychooserstarred', ['userid' => $USER->id]);
        $this->assertEquals(3, count($records));
        $this->assertEquals(2, reset($records)->sortorder);

        // Add one again - should now be last element and have sortorder 5
        $toggle->toggle(1);
        $records = $DB->get_records('local_activitychooserstarred', ['userid' => $USER->id]);
        $this->assertEquals(4, count($records));
        $this->assertEquals(5, end($records)->sortorder);
    }
}