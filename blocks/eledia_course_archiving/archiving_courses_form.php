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
//require_once($CFG->dirroot.'/blocks/eledia_course_archiving/locallib.php');

class archiving_courses_form extends moodleform {

    public function definition() {
        $mform =& $this->_form;

        $config = get_config('block_eledia_course_archiving');
        $archivement = new block_eledia_course_archiving\course_archiving_helper();
        $result = $archivement->check_courses($config);

        $a = new stdClass();
        $a->archived = '';
        $a->deleted = '';

        if (!empty($result->archive)) {
            $archive_list = '';
            foreach ($result->archive as $course) {
                $archive_list .= $course->fullname."<br />";
            }
            $a->archived = $archive_list;
        }
        if (!empty($result->delete)) {
            $delete_list = '';
            foreach ($result->delete as $course) {
                $delete_list .= $course->fullname."<br />";
                $a->deleted = $delete_list;
            }
        }

        $mform->addElement('header', '', get_string('confirm_header', 'block_eledia_course_archiving'));
        if (empty($result->archive) && empty($result->delete)) {
            $mform->addElement('static', '' , '', get_string('nothing_to_archive', 'block_eledia_course_archiving'));
        } else {
            $mform->addElement('static', '' , '', get_string('confirm_archiving', 'block_eledia_course_archiving', $a));
        }

        $mform->addElement('submit', 'submitbutton', get_string('archive', 'block_eledia_course_archiving'));
        $mform->addElement('cancel', 'cancelbutton');
    }
}

