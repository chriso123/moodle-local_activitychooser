<?php

defined('MOODLE_INTERNAL') || die();

function xmldb_local_activitychooser_upgrade($oldversion) {
    global $CFG, $DB;

    require_once($CFG->libdir . '/db/upgradelib.php'); // Core Upgrade-related functions.

    $dbman = $DB->get_manager();

    if ($oldversion < 2019091001) {

        // Define table local_activitychooserstarred to be created.
        $table = new xmldb_table('local_activitychooserstarred');

        // Adding fields to table local_activitychooserstarred.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('activityid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('sortorder', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table local_activitychooserstarred.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);

        // Adding indexes to table local_activitychooserstarred.
        $table->add_index('unique_useractivity', XMLDB_INDEX_UNIQUE, ['userid', 'activityid']);

        // Conditionally launch create table for local_activitychooserstarred.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Activitychooser savepoint reached.
        upgrade_plugin_savepoint(true, 2019091001, 'local', 'activitychooser');
    }

    
    if ($oldversion < 2020022800) {
        set_config('enabled', 1, 'local_activitychooser');
    }

    return true;
}
