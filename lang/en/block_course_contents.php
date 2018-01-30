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
 * Defines the block strings
 *
 * @package    block_course_contents
 * @copyright  2009 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['config_autotitle'] = 'Auto title';
$string['config_autotitle_desc'] = 'If the section has no explicit title defined, the block can attempt to extract the title from the section summary text. This setting determines the default behaviour of this feature in block instances.';
$string['config_autotitle_forced_off'] = 'Disabled in all blocks';
$string['config_autotitle_forced_on'] = 'Enabled in all blocks';
$string['config_autotitle_help'] = 'If the section has no explicit title defined, the block can attempt to extract the title from the section summary text.

If the summary starts with a heading, it will use such heading text. If the summary starts with a bold text, it will be used as a section title. If the summary consists of several paragraphs, the first one will be used.';
$string['config_autotitle_label'] = 'Automatically extract title from the section summary text';
$string['config_autotitle_optional_off'] = 'Optional, disabled by default';
$string['config_autotitle_optional_on'] = 'Optional, enabled by default';
$string['config_blocktitle'] = 'Block title';
$string['config_blocktitle_default'] = 'Table of contents';
$string['config_blocktitle_help'] = 'Leave this field empty to use the default block title. If you define a title here, it will be used instead of the default one.';
$string['config_enumerate'] = 'Enumerate section titles';
$string['config_enumerate_desc'] = 'The section number can be displayed before the section title. This setting determines the default value of the enumeration mode in each block instance and whether it can be changed or not.';
$string['config_enumerate_forced_off'] = 'Disabled in all blocks';
$string['config_enumerate_forced_on'] = 'Enabled in all blocks';
$string['config_enumerate_label'] = 'If enabled, the section number is displayed before the section title';
$string['config_enumerate_optional_off'] = 'Optional, disabled by default';
$string['config_enumerate_optional_on'] = 'Optional, enabled by default';
$string['course_contents:addinstance'] = 'Add a new course contents block';
$string['notusingsections'] = 'This course format does not use sections.';
$string['pluginname'] = 'Course contents';

$string['config_enumerate_section_0'] = 'Enumerate general section';
$string['config_enumerate_section_0_desc'] = 'This setting controls the enumeration mode for the general section, also known as section 0.';
$string['config_enumerate_section_0_help'] = 'Setting this option will enumerate from the first section, usually known as section 0 or general section.';
$string['config_enumerate_section_0_label'] = 'Start enumerating from the general section.';

$string['config_display_course_link'] = 'Course page link';
$string['config_display_course_link_desc'] = 'Display course home page link at the top of all sections.';
$string['config_display_course_link_forced_off'] = 'Disabled in all blocks';
$string['config_display_course_link_forced_on'] = 'Enabled in all blocks';
$string['config_display_course_link_optional_off'] = 'Optional, disabled by default';
$string['config_display_course_link_optional_on'] = 'Optional, enabled by default';
$string['config_display_course_link_help'] = 'This will display a link to the course home page above all course section links.';

$string['config_display_course_link_text'] = 'Custom course page link text';
$string['config_display_course_link_text_desc'] = 'Default value of the course home page link anchor text. If left empty, the course shortname will be used.';
$string['config_display_course_link_text_help'] = 'Course home page link anchor text. If left empty, the site-level default value will be used, unless it is also empty. In that case, the course shortname will be used.';
