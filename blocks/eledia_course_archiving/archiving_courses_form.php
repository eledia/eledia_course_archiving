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
 * The archiving Form to confirm the process.
 *
 * @package    block
 * @subpackage eledia_course_archiving
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->libdir.'/formslib.php');

class archiving_courses_form extends moodleform {

    public function definition() {
        global $DB, $CFG;
        $mform =& $this->_form;

        $config = get_config('block_eledia_course_archiving');
        $categories = explode(',', $config->sourcecat);

        $since = time() - ($config->days * 24 * 60 * 60);
        $now = time();
        list($qrypart, $params) = $DB->get_in_or_equal($categories);
        $params[] = $since;
        $params[] = $now;

        $sql = 'SELECT * FROM {course} WHERE category '.$qrypart.' AND startdate > ? AND startdate < ?';
        $courses = $DB->get_records_sql($sql, $params);

        $archive_list = '';
        foreach ($courses as $course) {
            $archive_list .= $course->fullname."<br />";
        }

        // Get older courses.
        $old_params = array($config->targetcat, $since);
        $sql = 'SELECT * FROM {course} WHERE category = ? AND startdate < ?';
        $old_courses = $DB->get_records_sql($sql, $old_params);

        $delete_list = '';
        foreach ($old_courses as $course) {
            $delete_list .= $course->fullname."<br />";
        }

        $a = new stdClass();
        $a->archived = $archive_list;
        $a->deleted = $delete_list;

        $mform->addElement('header', '', get_string('confirm_header', 'block_eledia_course_archiving'));
        $mform->addElement('static', '' , '', get_string('confirm_archiving', 'block_eledia_course_archiving', $a));

        $mform->addElement('submit', 'submitbutton', get_string('archive', 'block_eledia_course_archiving'));
        $mform->addElement('cancel', 'cancelbutton');
    }
}

