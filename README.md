Course contents block
=====================

[![Build status](https://travis-ci.org/mudrd8mz/moodle-block_course_contents.svg?branch=master)](https://travis-ci.org/mudrd8mz/moodle-block_course_contents)

Course contents block is a plugin for Moodle that displays a list of all
visible sections (such as topics or weeks) in the course. Clicking at a link
scrolls to that section or displays just that particular section, depending on
the course layout setting.

If the section name is explicitly defined, it is displayed in the course
contents outline. If enabled, the block can eventually extract a suitable
section title from the section summary text.

Section titles can be enumerated.

Background
----------

In older Moodle versions, course sections could not be named explicitly. Many
teachers used to put headings manually to the course summary text fields. This
block did an awesome job that it automagically extracted these headings from
the summary fields and generated a nice course contents from them.

This feature is still available but it is less useful in modern Moodle versions
where course sections can have explicit section titles defined.

Automatic section title
-----------------------

If the section name is not explicitly defined and the auto title feature is
enabled, the block automatically extracts a suitable title for the section from
the section summary text.

If the summary starts with a heading (H1, H2, H3, etc), the heading will use
such heading text. If the summary starts with a bold text, it will be used as a
section title. If the summary consists of several paragraphs, the first one
will be used.

Technically speaking, the plain text content of the first non-empty HTML DOM
node from the section summary can be used as the summary title.

Maintainer
----------

The block has been written and is currently maintained by David Mudrák.

Documentation
-------------

See [the block page at Moodle
wiki](http://docs.moodle.org/en/Course_contents_block) for more details.
