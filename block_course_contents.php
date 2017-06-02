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
 * Provides the {@link block_course_contents} class.
 *
 * @package    block_course_contents
 * @copyright  2009 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->dirroot.'/course/format/lib.php');

/**
 * Course contents block generates a table of course contents based on the
 * section descriptions
 */
class block_course_contents extends block_base {

    /**
     * Initializes the block, called by the constructor
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_course_contents');
    }

    /**
     * Amend the block instance after it is loaded
     */
    public function specialization() {
        if (!empty($this->config->blocktitle)) {
            $this->title = $this->config->blocktitle;
        } else {
            $this->title = get_string('config_blocktitle_default', 'block_course_contents');
        }
    }

    /**
     * Which page types this block may appear on
     * @return array
     */
    public function applicable_formats() {
        return array('site-index' => true, 'course-view-*' => true);
    }

    /**
     * Does the block have a global settings.
     *
     * @return bool
     */
    public function has_config() {
        return true;
    }

    /**
     * Populate this block's content object
     * @return stdClass block content info
     */
    public function get_content() {

        if (!is_null($this->content)) {
            return $this->content;
        }

        $selected = optional_param('section', null, PARAM_INT);

        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text   = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        $format = course_get_format($this->page->course);
        $course = $format->get_course(); // Needed to have numsections property available.

        if (!$format->uses_sections()) {
            if (debugging()) {
                $this->content->text = get_string('notusingsections', 'block_course_contents');
            }
            return $this->content;
        }

        $sections = $format->get_sections();

        if (empty($sections)) {
            return $this->content;
        }

        $context = context_course::instance($course->id);
        $globalconfig = get_config('block_course_contents');

        $text = html_writer::start_tag('ul', array('class' => 'section-list'));
        $r = 0;
        foreach ($sections as $section) {
            $i = $section->section;
            if (isset($course->numsections) && $i > $course->numsections) {
                break;
            }
            if (!$section->uservisible) {
                continue;
            }

            if ($globalconfig->autotitle === 'forced_off') {
                $autotitle = false;

            } else if ($globalconfig->autotitle === 'forced_on') {
                $autotitle = true;

            } else if (empty($this->config) or !isset($this->config->autotitle)) {
                // Instance not configured, use the globally defined default value.
                if ($globalconfig->autotitle === 'optional_on') {
                    $autotitle = true;
                } else {
                    $autotitle = false;
                }

            } else if (!empty($this->config->autotitle)) {
                $autotitle = true;

            } else {
                $autotitle = false;
            }

            $title = null;

            if (!empty($section->name)) {
                // If the section has explic title defined, it is used.
                $title = format_string($section->name, true, array('context' => $context));

            } else if ($autotitle) {
                // Attempt to extract the title from the section summary.
                $summary = file_rewrite_pluginfile_urls($section->summary, 'pluginfile.php', $context->id, 'course',
                    'section', $section->id);
                $summary = format_text($summary, $section->summaryformat, array('para' => false, 'context' => $context));
                $title = format_string($this->extract_title($summary), true, array('context' => $context));
            }

            // If at this point we have no title available, use the default one.
            if (empty($title)) {
                $title = $format->get_section_name($section);
            }

            $odd = $r % 2;
            if ($format->is_section_current($section)) {
                $text .= html_writer::start_tag('li', array('class' => 'section-item current r'.$odd));
            } else {
                $text .= html_writer::start_tag('li', array('class' => 'section-item r'.$odd));
            }

            if ($i == 0) {
                // Never enumerate the section number 0.
                $enumerate = false;

            } else if ($globalconfig->enumerate === 'forced_off') {
                $enumerate = false;

            } else if ($globalconfig->enumerate === 'forced_on') {
                $enumerate = true;

            } else if (empty($this->config) or !isset($this->config->enumerate)) {
                // Instance not configured, use the globally defined default value.
                if ($globalconfig->enumerate === 'optional_on') {
                    $enumerate = true;
                } else {
                    $enumerate = false;
                }

            } else if (!empty($this->config->enumerate)) {
                $enumerate = true;

            } else {
                $enumerate = false;
            }

            if ($enumerate) {
                $title = html_writer::span($i, 'section-number').' '.html_writer::span($title, 'section-title');

            } else {
                $title = html_writer::span($title, 'section-title not-enumerated');
            }

            if (is_null($selected) or $i <> $selected) {
                $text .= html_writer::link($format->get_view_url($section), $title, ['class' => $section->visible ? '' : 'dimmed']);
            } else {
                $text .= $title;
            }
            $text .= html_writer::end_tag('li');
            $r++;
        }
        $text .= html_writer::end_tag('ul');

        $this->content->text = $text;
        return $this->content;
    }


    /**
     * Given a section summary, exctract a text suitable as a section title
     *
     * @param string $summary Section summary as returned from database (no slashes)
     * @return string Section title
     */
    private function extract_title($summary) {
        global $CFG;
        require_once(dirname(__FILE__).'/lib/simple_html_dom.php');

        $node = new simple_html_dom();
        $node->load($summary);
        return $this->node_plain_text($node);
    }


    /**
     * Recursively find the first suitable plaintext from the HTML DOM.
     *
     * Internal private function called only from {@link extract_title()}
     *
     * @param simple_html_dom $node Current root node
     * @return string
     */
    private function node_plain_text($node) {
        if ($node->nodetype == HDOM_TYPE_TEXT) {
            $t = trim($node->plaintext);
            if (!empty($t)) {
                return $t;
            }
        }
        $t = '';
        foreach ($node->nodes as $n) {
            $t = $this->node_plain_text($n);
            if (!empty($t)) {
                break;
            }
        }
        return $t;
    }
}