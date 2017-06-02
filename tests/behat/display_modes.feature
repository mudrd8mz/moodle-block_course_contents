@block @block_course_contents @javascript
Feature: Configuring various display modes how the course sections are displayed
  In order to help students to navigate through the course
  As a teacher
  I need to be able to configure how the block displays the course contents

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email            |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname | shortname | format | coursedisplay | numsections |
      | Course 1 | C1        | topics | 0             | 3           |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
    And I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    # Rename the general section (the first click is needed in js mode only).
    And I click on "Edit" "link" in the "li#section-0" "css_element"
    And I click on "Edit section" "link" in the "li#section-0" "css_element"
    And I set the following fields to these values:
      | Custom | 1 |
      | New value for Section name | Welcome to C1 |
    And I press "Save changes"
    # Add a summary text to the topic 1 section.
    And I edit the section "1" and I fill the form with:
      | Custom | 0 |
      | Summary | <h2>Unit One</h2> |
    # Add both explicit name and a summary text to the topic 2 section.
    And I edit the section "2" and I fill the form with:
      | Custom | 1 |
      | New value for Section name | Topic Two |
      | Summary | This is topic 2. |
    # Add the course context block instance and enter its configuration.
    And I add the "Course contents" block
    And I configure the "Table of contents" block

  Scenario: Customizing the block title
    Given I set the field "Block title" to "Course units"
    When I press "Save changes"
    Then I should not see "Table of contents"
    And "Course units" "block" should exist

  Scenario: Enumeration off, auto title off
    Given I set the following fields to these values:
      | Enumerate section titles  | 0 |
      | Auto title                | 0 |
    When I press "Save changes"
    Then I should see "Welcome to C1" in the "block_course_contents" "block"
    And I should not see "0 Welcome to C1" in the "block_course_contents" "block"
    And I should see "Topic 1" in the "block_course_contents" "block"
    And I should not see "1 Topic 1" in the "block_course_contents" "block"
    And I should see "Topic Two" in the "block_course_contents" "block"
    And I should not see "Topic 2" in the "block_course_contents" "block"
    And I should see "Topic 3" in the "block_course_contents" "block"
    And I should not see "3 Topic 3" in the "block_course_contents" "block"

  Scenario: Enumeration on, auto title off
    Given I set the following fields to these values:
      | Enumerate section titles  | 1 |
      | Auto title                | 0 |
    When I press "Save changes"
    Then I should see "Welcome to C1" in the "block_course_contents" "block"
    And I should not see "0 Welcome to C1" in the "block_course_contents" "block"
    And I should see "1 Topic 1" in the "block_course_contents" "block"
    And I should see "2 Topic Two" in the "block_course_contents" "block"
    And I should see "3 Topic 3" in the "block_course_contents" "block"

  Scenario: Enumeration off, auto title on
    Given I set the following fields to these values:
      | Enumerate section titles  | 0 |
      | Auto title                | 1 |
    When I press "Save changes"
    Then I should see "Welcome to C1" in the "block_course_contents" "block"
    And I should not see "0 Welcome to C1" in the "block_course_contents" "block"
    And I should see "Unit One" in the "block_course_contents" "block"
    And I should not see "1 Unit One" in the "block_course_contents" "block"
    And I should not see "Topic 1" in the "block_course_contents" "block"
    And I should see "Topic Two" in the "block_course_contents" "block"
    And I should not see "Topic 2" in the "block_course_contents" "block"
    And I should see "Topic 3" in the "block_course_contents" "block"
    And I should not see "3 Topic 3" in the "block_course_contents" "block"

  Scenario: Enumeration on, auto title on
    Given I set the following fields to these values:
      | Enumerate section titles  | 1 |
      | Auto title                | 1 |
    When I press "Save changes"
    Then I should see "Welcome to C1" in the "block_course_contents" "block"
    And I should not see "0 Welcome to C1" in the "block_course_contents" "block"
    And I should see "1 Unit One" in the "block_course_contents" "block"
    And I should not see "Topic 1" in the "block_course_contents" "block"
    And I should see "2 Topic Two" in the "block_course_contents" "block"
    And I should not see "Topic 2" in the "block_course_contents" "block"
    And I should see "3 Topic 3" in the "block_course_contents" "block"

  Scenario: Enumeration off, auto title off, but the values are overwritten on site level
    Given I set the following fields to these values:
      | Enumerate section titles  | 0 |
      | Auto title                | 0 |
    And I press "Save changes"
    When the following config values are set as admin:
      | enumerate | forced_on | block_course_contents |
      | autotitle | forced_on | block_course_contents |
    And I am on "Course 1" course homepage
    Then I should see "Welcome to C1" in the "block_course_contents" "block"
    And I should not see "0 Welcome to C1" in the "block_course_contents" "block"
    And I should see "1 Unit One" in the "block_course_contents" "block"
    And I should not see "Topic 1" in the "block_course_contents" "block"
    And I should see "2 Topic Two" in the "block_course_contents" "block"
    And I should not see "Topic 2" in the "block_course_contents" "block"
    And I should see "3 Topic 3" in the "block_course_contents" "block"

  Scenario: Enumeration on, auto title on, but the values are overwritten on site level
    Given I set the following fields to these values:
      | Enumerate section titles  | 1 |
      | Auto title                | 1 |
    And I press "Save changes"
    When the following config values are set as admin:
      | enumerate | forced_off | block_course_contents |
      | autotitle | forced_off | block_course_contents |
    And I am on "Course 1" course homepage
    Then I should see "Welcome to C1" in the "block_course_contents" "block"
    And I should not see "0 Welcome to C1" in the "block_course_contents" "block"
    And I should see "Topic 1" in the "block_course_contents" "block"
    And I should not see "1 Topic 1" in the "block_course_contents" "block"
    And I should see "Topic Two" in the "block_course_contents" "block"
    And I should not see "Topic 2" in the "block_course_contents" "block"
    And I should see "Topic 3" in the "block_course_contents" "block"
    And I should not see "3 Topic 3" in the "block_course_contents" "block"
