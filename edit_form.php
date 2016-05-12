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

defined('MOODLE_INTERNAL') || die();

/**
 * Extends the block instance coinfiguration
 */
class block_course_contents_edit_form extends block_edit_form {

    /**
     * Defines fields to add to the settings form
     *
     * @param moodle_form $mform
     */
    protected function specific_definition($mform) {
    
        $config = get_config('block_course_contents');
        
        if($config->admin_lock_blocktitle == 1 AND $config->admin_lock_enumerate== 1 AND $config->admin_lock_defaultsectiontitle == 1) {
        } // all possible seetings locked by admin setting
        else {
            $mform->addElement('header', 'configheader', get_string('blocksettings', 'core_block'));
        }

        if($config->admin_lock_blocktitle == 0) { //if not locked by admin
            $mform->addElement('text', 'config_blocktitle', get_string('config_blocktitle', 'block_course_contents'));
            $mform->setDefault('config_blocktitle', '');
            $mform->setType('config_blocktitle', PARAM_MULTILANG);
            $mform->addHelpButton('config_blocktitle', 'config_blocktitle', 'block_course_contents');
        }

        if($config->admin_lock_defaultsectiontitle == 0) { //if not locked by admin
            $mform->addElement('advcheckbox', 'config_defaultsectiontitle', get_string('config_defaultsectiontitle', 'block_course_contents'),
                get_string('config_defaultsectiontitle_label', 'block_course_contents'));
            $mform->setDefault('config_defaultsectiontitle', $config->admin_defaultsectiontitle);
            $mform->setType('config_defaultsectiontitle', PARAM_BOOL);
        }

        if($config->admin_lock_enumerate== 0) { //if not locked by admin
            $mform->addElement('advcheckbox', 'config_enumerate', get_string('config_enumerate', 'block_course_contents'),
                get_string('config_enumerate_label', 'block_course_contents'));
            $mform->setDefault('config_enumerate', 1);
            $mform->setType('config_enumerate', PARAM_BOOL);
        }
    }
}
