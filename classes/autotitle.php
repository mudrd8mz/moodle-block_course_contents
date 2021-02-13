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
 * Provides section autotitle functionality for the Course contents block
 *
 * @package    block_course_contents
 * @copyright  2021 David Mudrák <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class autotitle {

    /**
     * Extract suitable title from the HTML section summary text
     *
     * @param string $summary
     * @return string
     */
    public static function extract_title(string $summary): string {

        $summary = trim($summary);

        if ($summary === '') {
            return '';
        }

        $dom = new \DOMDocument();
        $dom->loadHTML($summary);

        return static::find_first_nonempty_text_node_value($dom);
    }

    /**
     * Find the first non-empty text node value in the DOM tree.
     *
     * Recursively traverse through the DOMNode and its child nodes to seek for the
     * first text node with non-empty value.
     *
     * @param \DOMNode $node
     * @return string
     */
    public static function find_first_nonempty_text_node_value(\DOMNode $node): string {

        if ($node->nodeType == XML_TEXT_NODE) {
            $text = trim($node->textContent);

            if ($text !== '') {
                return $text;
            }
        }

        $text = '';

        foreach ($node->childNodes as $child) {
            $text = static::find_first_nonempty_text_node_value($child);

            if ($text !== '') {
                break;
            }
        }

        return $text;
    }
}
