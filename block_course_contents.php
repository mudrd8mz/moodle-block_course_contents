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
 * @package    block_course_contents
 * @copyright  2009 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/lib.php');

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
     * Which page types this block may appear on
     * @return array
     */
    public function applicable_formats() {
        return (array('course-view-weeks' => true, 'course-view-topics' => true));
    }

    /**
     * Populate this block's content object
     * @return stdClass block content info
     */
    public function get_content() {
        global $CFG, $DB;

        $current = optional_param('section', null, PARAM_INT);

        $highlight = 0;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text   = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        $course = $this->page->course;
        $context = context_course::instance($course->id);

        if ($course->format == 'weeks') {
            $highlight = ceil((time()-$course->startdate)/604800);
            $linktext = get_string('jumptocurrentweek', 'block_course_contents');

        } else if ($course->format == 'scorm' or $course->format == 'social') {
            // this formats do not have sections at all, no need for this block there
            return $this->content;

        } else {
            // anything else defaults to 'topics'
            $highlight = $course->marker;
            $linktext = get_string('jumptocurrenttopic', 'block_course_contents');
        }

        // depending on whether there should be just one section displayed or all sections
        // displayed, prepare the base URL to jump to
        if ($course->coursedisplay == COURSE_DISPLAY_SINGLEPAGE) {
            $link = '#section-';
        } else if ($course->coursedisplay == COURSE_DISPLAY_MULTIPAGE) {
            $link = $CFG->wwwroot.'/course/view.php?id='.$course->id.'&section=';
        } else {
            debugging('Unsupported course display mode', DEBUG_DEVELOPER);
            $link = '#section-';
        }

        $sql = "SELECT section, name, summary, summaryformat, visible
                  FROM {course_sections}
                 WHERE course = ? AND
                       section < ?
              ORDER BY section";

        if ($sections = $DB->get_records_sql($sql, array($course->id, $course->numsections+1))) {
            $text = html_writer::start_tag('ul', array('class' => 'section-list'));
            foreach ($sections as $section) {
                $i = $section->section;
                if (!isset($sections[$i]) or ($i == 0)) {
                    continue;
                }
                $isvisible = $sections[$i]->visible;
                if (!$isvisible and !has_capability('moodle/course:update', $context)) {
                    continue;
                }
                if (!empty($section->name)) {
                    $title = format_string($section->name, true, array('context' => $context));
                } else {
                    $summary = format_text($section->summary, $section->summaryformat,
                        array('para' => false, 'context' => $context));
                    $title = format_string($this->extract_title($summary), true, array('context' => $context));
                    if (empty($title)) {
                        $title = get_generic_section_name($course->format, $section);
                    }
                }
                $odd = $i % 2;
                if ($i == $highlight) {
                    $text .= html_writer::start_tag('li', array('class' => 'section-item current r'.$odd));
                } else {
                    $text .= html_writer::start_tag('li', array('class' => 'section-item r'.$odd));
                }
                $title = html_writer::tag('span', $i.' ', array('class' => 'section-number')).
                         html_writer::tag('span', $title, array('class' => 'section-title'));
                if (is_null($current) or $i <> $current) {
                    $text .= html_writer::link($link.$i, $title, array('class' => $isvisible ? '' : 'dimmed'));
                } else {
                    $text .= $title;
                }
                $text .= html_writer::end_tag('li');
            }
            $text .= html_writer::end_tag('ul');
            if ($highlight and isset($sections[$highlight])) {
                $isvisible = $sections[$highlight]->visible;
                if ($isvisible or has_capability('moodle/course:update', $context)) {
                    $this->content->footer = html_writer::link($link.$highlight, $linktext,
                            array('class' => $isvisible ? '' : 'dimmed'));
                }
            }
        }

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