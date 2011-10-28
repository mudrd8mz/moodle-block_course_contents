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
 * @package    block
 * @subpackage course_contents
 * @copyright  2009 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Course contents block generates a table of course contents based on the
 * section descriptions
 */
class block_course_contents extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_course_contents');
    }

    function applicable_formats() {
        return array('course' => true);
    }

    function get_content() {
        global $CFG, $USER, $COURSE, $DB;

        $highlight = 0;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->footer = '';
        $this->content->text   = '';

        if (empty($this->instance->pageid)) { // sticky
            if (!empty($COURSE)) {
                $this->instance->pageid = $COURSE->id;
            }
        }

        if (empty($this->instance)) {
            return $this->content;
        }

        if ($this->instance->pageid == $COURSE->id) {
            $course = $COURSE;
        } else {
            $course = $DB->get_record('course', array('id'=>$this->instance->pageid));
        }
        $context = get_context_instance(CONTEXT_COURSE, $course->id);

        if ($course->format == 'weeks' or $course->format == 'weekscss') {
            $highlight = ceil((time()-$course->startdate)/604800);
            $linktext = get_string('jumptocurrentweek', 'block_course_contents');
            $sectionname = 'week';
        }
        else if ($course->format == 'topics') {
            $highlight = $course->marker;
            $linktext = get_string('jumptocurrenttopic', 'block_course_contents');
            $sectionname = 'topic';
        }

        if (!empty($USER->id)) {
            $display = $DB->get_field('course_display', 'display', array('course'=>$this->instance->pageid, 'userid'=>$USER->id));
        }
        if (!empty($display)) {
            $link = $CFG->wwwroot.'/course/view.php?id='.$this->instance->pageid.'&amp;'.$sectionname.'=';
        } else {
            $link = $CFG->wwwroot.'/course/view.php?id='.$this->instance->pageid.'#sectionblock-';
        }

        $sql = "SELECT section, summary, visible
                  FROM {course_sections}
                 WHERE course = ? AND
                       section < ?
              ORDER BY section";

        if ($sections = $DB->get_records_sql($sql, array($course->id, $course->numsections+1))) {
            $text = '<ul class="section-list">';
            foreach ($sections as $section) {
                $i = $section->section;
                if (!isset($sections[$i]) or ($i == 0)) {
                    continue;
                }
                $isvisible = $sections[$i]->visible;
                if (!$isvisible and !has_capability('moodle/course:update', $context)) {
                    continue;
                }
                $title = $this->extract_title($section->summary);
                if (empty($title)) {
                    $title = get_string('emptysummary', 'block_course_contents', $i);
                }
                $style = ($isvisible) ? '' : ' class="dimmed"';
                $odd = $i % 2;
                if ($i == $highlight) {
                    $text .= "<li class=\"section-item current r$odd\">";
                } else {
                    $text .= "<li class=\"section-item r$odd\">";
                }
                $text .= "<a href=\"$link$i\"$style>";
                $text .= "<span class=\"section-number\">$i </span>";
                $text .= "<span class=\"section-title\">$title</span>";
                $text .= "</a>";
                $text .= "</li>\n";
            }
            $text .= '</ul>';
            if ($highlight and isset($sections[$highlight])) {
                $isvisible = $sections[$highlight]->visible;
                if ($isvisible or has_capability('moodle/course:update', $context)) {
                    $style = ($isvisible) ? '' : ' class="dimmed"';
                    $this->content->footer = "<a href=\"$link$highlight\"$style>$linktext</a>";
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
    function extract_title($summary) {
        global $CFG;
        require_once(dirname(__FILE__).'/lib/simple_html_dom.php');

        $node = new simple_html_dom;
        $node->load($summary);
        return $this->_node_plain_text($node);
    }


    /**
     * Recursively find the first suitable plaintext from the HTML DOM.
     *
     * Internal private function called only from {@link extract_title()}
     * 
     * @param mixed $node Current root node
     * @access private
     * @return void str 
     */
    private function _node_plain_text($node) {
        if ($node->nodetype == HDOM_TYPE_TEXT) {
            $t = trim($node->plaintext);
            if (!empty($t)) {
                return $t;
            }
        }
        $t = '';
        foreach ($node->nodes as $n) {
            $t = $this->_node_plain_text($n);
            if (!empty($t)) {
                break;
            }
        }
        return $t;
    }



}