<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace block_course_contents;

/**
 * The autotitle feature test.
 *
 * @package    block_course_contents
 * @copyright  2021 David Mudrák <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class autotitle_test extends \advanced_testcase {

    /**
     * Test extracting suitable title from the summary HTML text.
     *
     * @dataProvider extract_title_data
     * @param string $summary
     * @param string $title
     */
    public function test_extract_title(string $summary, string $title) {
        $this->assertEquals($title, autotitle::extract_title($summary));
    }

    /**
     * Provides data for {@see self::test_extract_title()}.
     *
     * @return array
     */
    public function extract_title_data(): array {
        return [
            'Plain text' => [
                'summary' => 'Welcome to this course!',
                'title' => 'Welcome to this course!',
            ],
            'Invalid HTML' => [
                'summary' => '</span>Hello<<h1>',
                'title' => 'Hello',
            ],
            'Heading' => [
                'summary' => '<h3>Welcome!</h3><p>In this course, you will learn a lot.</p>',
                'title' => 'Welcome!',
            ],
            'Bold' => [
                'summary' => '<p><b>Welcome!</b> In this course, you will learn a lot.</p>',
                'title' => 'Welcome!',
            ],
            'First non-empty' => [
                'summary' => '<p class="test"><strong>  </strong><i></i></p><p></p><br /><p class="test">Hello</p>',
                'title' => 'Hello',
            ],
            'Siblings' => [
                'summary' => '<div><span>First</span><span>Two</span></div>',
                'title' => 'First',
            ],
            'No actual text content, just HTML' => [
                'summary' => "<br />\n\t<p>\n</p>",
                'title' => '',
            ],
            'Empty string' => [
                'summary' => '',
                'title' => '',
            ],
            'Break lines' => [
                'summary' => 'Hello  <br> students',
                'title' => 'Hello',
            ],
            'Multi-byte' => [
                'summary' => "\u{a0}µ déjà\u{a0}ěščřžýáíé &nbsp; \u{a0}",
                'title' => "µ déjà\u{a0}ěščřžýáíé",
            ],
            'Non-breakable spaces' => [
                'summary' => '<h2>&nbsp;<span style="font-family:tahoma">Lesson 4: Your first game &nbsp;' . "\xC2\xA0" .
                    "\xc2\xa0" . '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span> </h2>',
                'title' => 'Lesson 4: Your first game',
            ],
        ];
    }
}
