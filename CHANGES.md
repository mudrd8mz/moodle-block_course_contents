### 5.1.1 ###

* Fixed the reported coding style violations.
* Updated travis-ci config.

### 5.1 ###

* Fixed support for Moodle 3.3 - topics and weeks format no longer provide the
  numsections property and the block must not rely on it. Credit goes to
  Nicolas Dunand.
* Fixed Behat tests syntax for Moodle 3.3

### 5.0 ###

* All features and fixes included in the v4.0 release, just Behat tests
  supported by Moodle 3.0 and 3.1.

### 4.0 ###

* Added site level settings for controlling the enumeration mode and automatic
  title feature. The new site level settings determine the default values for
  instances and whether or not they can be changed.
* As a result, the automatic title feature can be now switched off.
* Improved the styling of the table of contents, particularly the way how
  enumerated items look.
* Added behat tests for all combinations of display modes.
* Added Travis-CI integration.
* Versions 4.x should support Moodle 2.7, 2.8 and 2.9.

### 3.0 ###

* Version numbering scheme changed. No longer this plugin will have separate
  branch for Moodle major version.
* Bug #14 fixed.

### 2.6.0 ###

* Just a maintenance release tested against Moodle 2.6.2 with no modified
  functionality.

### 2.5.0 ###

* No real changes, just tested against Moodle 2.5.0.
* Confirmed that the Restrict access section setting is taking into account
  correctly (issue #8).

### 2.4.1 ###

* Number of sections defined in the course setting is respected (issue #9)
* Block plugin name is used in the Add a block drop down menu

### 2.4.0 ###

* Moodle 2.4 support
* Added capability "addinstance" (required by Moodle core)
* Rewritten to use the new course formats API
* The section titles enumeration is now configurable (issue #2)
* The block title is now configurable (issue #3)
