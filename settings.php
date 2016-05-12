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
 * @package     block_course_contents
 * @copyright   2012 David Mudrak <david@moodle.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    /* Blocktitle */ 
    // Heading
    $settings->add(new admin_setting_heading('block_course_contents/admin_heading_blocktitle', get_string('admin_heading_blocktitle', 'block_course_contents'), NULL));

    // Lock setting
    $settings->add(new admin_setting_configcheckbox('block_course_contents/admin_lock_blocktitle', get_string('admin_lock', 'block_course_contents'), get_string('admin_lock_desc', 'block_course_contents'), 0));

    /* Titles */
    // Heading
    $settings->add(new admin_setting_heading('block_course_contents/admin_heading_defaultsectiontitle', get_string('admin_heading_titles', 'block_course_contents'), NULL));

    // Setting
    $settings->add(new admin_setting_configcheckbox('block_course_contents/admin_defaultsectiontitle', get_string('config_defaultsectiontitle', 'block_course_contents'), get_string('config_defaultsectiontitle_label', 'block_course_contents'), 1));
    
    // Lock setting
    $settings->add(new admin_setting_configcheckbox('block_course_contents/admin_lock_defaultsectiontitle', get_string('admin_lock', 'block_course_contents'), get_string('admin_lock_desc', 'block_course_contents'), 0));

    /* Enumeration */
    // Heading
    $settings->add(new admin_setting_heading('block_course_contents/admin_heading_enumerate', get_string('admin_heading_enumeration', 'block_course_contents'), NULL));

    // Setting
    $settings->add(new admin_setting_configcheckbox('block_course_contents/admin_enumerate', get_string('config_enumerate', 'block_course_contents'), get_string('config_enumerate_label', 'block_course_contents'), 1));
    
    // Lock setting
    $settings->add(new admin_setting_configcheckbox('block_course_contents/admin_lock_enumerate', get_string('admin_lock', 'block_course_contents'), get_string('admin_lock_desc', 'block_course_contents'), 0));

}
