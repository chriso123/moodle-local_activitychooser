<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Webservices for Usersynchronisation via TUGraz IdentityManagement (IDM)
 *
 * @package    local_idm
 * @category   webservices
 * @author     Christian Ortner
 * @copyright  2019 Educational Technologies, Graz, University of Technology
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_activitychooser\get_activities;

define('CLI_SCRIPT', true);

require(__DIR__ . '/../../../config.php');

global $USER, $COURSE;

// just let moodle think admin is working in course with id 2
$COURSE = get_course(2);
$USER->id = 2;

$activities = new get_activities();
$acts = $activities->get_activities(0);