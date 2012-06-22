Course contents block
=====================

Course contents block produces a list of all visible topic/week in the course.
Clicking at one of these links will display that particular week or topic.

If the section name is defined, it is used in the course contents. Otherwise,
the block automatically extracts a suitable title for every week or topic from
the section summary. If you start summary with a heading (H1, H2, H3, etc), it
will use such heading text. If your summary starts with a bold text, it will be
used as a section title. If the summary consists of several paragraphs, the
first one will be used. Technically spoken, the plain text content of the first
non-empty HTML DOM node from the section summary is used as the summary title.
If no suitable title can be populated, the current course format's default is
used.


Maintainer
----------

The block has been written and is currently maintained by David Mudrak.


Documentation
-------------

See [the page at Moodle wiki](http://docs.moodle.org/en/Course_contents_block)
for more details.
