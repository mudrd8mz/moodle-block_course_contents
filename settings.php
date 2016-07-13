<?php
/**
 * course_contents global settings.
 *
 * @package    block_course_contents
 * @copyright  2012 David Mudrak <david@moodle.com>
 * @copyright  2016 COMETE (Paris Ouest University)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$settings->add(new admin_setting_heading(
  'defaults',
  get_string('defaults_header', 'block_course_contents'),
  get_string('defaults_desc',   'block_course_contents')
));

$settings->add(new admin_setting_configcheckbox(
  'course_contents/enumerate_default',
  get_string('config_enumerate', 'block_course_contents'),
  get_string('config_enumerate_label', 'block_course_contents'),
  '1'
));

$settings->add(new admin_setting_configtext(
  'course_contents/blocktitle_default',
  get_string('config_blocktitle', 'block_course_contents'),
  get_string('config_blocktitle_default_help', 'block_course_contents'),
  get_string('config_blocktitle_default', 'block_course_contents')
));
