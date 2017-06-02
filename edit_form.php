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
 * Provides the {@link block_course_contents_edit_form} class.
 *
 * @package     block_course_contents
 * @copyright   2012 David Mudrak <david@moodle.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Extends the block instance configuration.
 *
 * @copyright 2012 David Mudrak <david@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_course_contents_edit_form extends block_edit_form {

    /**
     * Defines fields to add to the settings form
     *
     * @param moodle_form $mform
     */
    protected function specific_definition($mform) {

        $config = get_config('block_course_contents');

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'core_block'));

        $mform->addElement('text', 'config_blocktitle', get_string('config_blocktitle', 'block_course_contents'));
        $mform->setDefault('config_blocktitle', '');
        $mform->setType('config_blocktitle', PARAM_MULTILANG);
        $mform->addHelpButton('config_blocktitle', 'config_blocktitle', 'block_course_contents');

        if ($config->enumerate === 'forced_off') {
            $mform->addElement('static', 'config_enumerate_info', get_string('config_enumerate', 'block_course_contents'),
                get_string('config_enumerate_forced_off', 'block_course_contents'));
            $mform->addElement('hidden', 'config_enumerate');

        } else if ($config->enumerate === 'forced_on') {
            $mform->addElement('static', 'config_enumerate_info', get_string('config_enumerate', 'block_course_contents'),
                get_string('config_enumerate_forced_on', 'block_course_contents'));
            $mform->addElement('hidden', 'config_enumerate');

        } else {
            $mform->addElement('advcheckbox', 'config_enumerate', get_string('config_enumerate', 'block_course_contents'),
                get_string('config_enumerate_label', 'block_course_contents'));

            if ($config->enumerate === 'optional_on') {
                $mform->setDefault('config_enumerate', 1);

            } else {
                $mform->setDefault('config_enumerate', 0);
            }
        }

        $mform->setType('config_enumerate', PARAM_BOOL);

        if ($config->autotitle === 'forced_off') {
            $mform->addElement('static', 'config_autotitle_info', get_string('config_autotitle', 'block_course_contents'),
                get_string('config_autotitle_forced_off', 'block_course_contents'));
            $mform->addHelpButton('config_autotitle_info', 'config_autotitle', 'block_course_contents');
            $mform->addElement('hidden', 'config_autotitle');

        } else if ($config->autotitle === 'forced_on') {
            $mform->addElement('static', 'config_autotitle_info', get_string('config_autotitle', 'block_course_contents'),
                get_string('config_autotitle_forced_on', 'block_course_contents'));
            $mform->addHelpButton('config_autotitle_info', 'config_autotitle', 'block_course_contents');
            $mform->addElement('hidden', 'config_autotitle');

        } else {
            $mform->addElement('advcheckbox', 'config_autotitle', get_string('config_autotitle', 'block_course_contents'),
                get_string('config_autotitle_label', 'block_course_contents'));
            $mform->addHelpButton('config_autotitle', 'config_autotitle', 'block_course_contents');

            if ($config->autotitle === 'optional_on') {
                $mform->setDefault('config_autotitle', 1);

            } else {
                $mform->setDefault('config_autotitle', 0);
            }
        }

        $mform->setType('config_autotitle', PARAM_BOOL);
    }
}
