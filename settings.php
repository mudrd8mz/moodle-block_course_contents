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
 * Defines the global settings of the block
 *
 * @package     block_course_contents
 * @copyright   2016 David Mudrák <david@moodle.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    $enumerate = [
        'forced_on' => get_string('config_enumerate_forced_on', 'block_course_contents'),
        'optional_on' => get_string('config_enumerate_optional_on', 'block_course_contents'),
        'optional_off' => get_string('config_enumerate_optional_off', 'block_course_contents'),
        'forced_off' => get_string('config_enumerate_forced_off', 'block_course_contents'),
    ];

    $settings->add(new admin_setting_configselect(
        'block_course_contents/enumerate',
        get_string('config_enumerate', 'block_course_contents'),
        get_string('config_enumerate_desc', 'block_course_contents'),
        'optional_on',
        $enumerate
    ));

    // Enumerate section 0.
    $enumeratesection0 = [
            'forced_on' => get_string('config_enumerate_section_0_forced_on', 'block_course_contents'),
            'optional_on' => get_string('config_enumerate_section_0_optional_on', 'block_course_contents'),
            'optional_off' => get_string('config_enumerate_section_0_optional_off', 'block_course_contents'),
            'forced_off' => get_string('config_enumerate_section_0_forced_off', 'block_course_contents'),
    ];

    $settings->add(new admin_setting_configselect(
            'block_course_contents/enumerate_section_0',
            get_string('config_enumerate_section_0', 'block_course_contents'),
            get_string('config_enumerate_section_0_desc', 'block_course_contents'),
            'optional_off',
            $enumeratesection0
            ));

    // Display course page link.
    $displaycourselink = [
            'forced_on' => get_string('config_display_course_link_forced_on', 'block_course_contents'),
            'optional_on' => get_string('config_display_course_link_optional_on', 'block_course_contents'),
            'optional_off' => get_string('config_display_course_link_optional_off', 'block_course_contents'),
            'forced_off' => get_string('config_display_course_link_forced_off', 'block_course_contents'),
    ];

    $settings->add(new admin_setting_configselect(
            'block_course_contents/display_course_link',
            get_string('config_display_course_link', 'block_course_contents'),
            get_string('config_display_course_link_desc', 'block_course_contents'),
            'optional_off',
            $displaycourselink
            ));

    // Course page link custom text.
    $settings->add(new admin_setting_configtext('block_course_contents/display_course_link_text',
                   new lang_string('config_display_course_link_text', 'block_course_contents'),
                   new lang_string('config_display_course_link_text_desc', 'block_course_contents'), ''));

    $autotitle = [
        'forced_on' => get_string('config_autotitle_forced_on', 'block_course_contents'),
        'optional_on' => get_string('config_autotitle_optional_on', 'block_course_contents'),
        'optional_off' => get_string('config_autotitle_optional_off', 'block_course_contents'),
        'forced_off' => get_string('config_autotitle_forced_off', 'block_course_contents'),
    ];

    $settings->add(new admin_setting_configselect(
        'block_course_contents/autotitle',
        get_string('config_autotitle', 'block_course_contents'),
        get_string('config_autotitle_desc', 'block_course_contents'),
        'optional_off',
        $autotitle
    ));
}
