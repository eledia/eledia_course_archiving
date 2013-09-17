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

require_once('../../config.php');
require_once('../../course/lib.php');
global $DB, $CFG;
$config = get_config('block_eledia_course_archiving');

$PAGE->set_url('/blocks/eledia_course_archiving/archiving_courses.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_pagelayout('course');

$categories = explode(',', $config->sourcecat);

$since = time() - ($config->days * 24 * 60 * 60);
list($qrypart, $params) = $DB->get_in_or_equal($categories);
$params[] = $since;

$sql = 'SELECT * FROM {course} WHERE category '.$qrypart.' AND startdate > ?';
$courses = $DB->get_records_sql($sql, $params);

$archived_list = '';

foreach ($courses as $course) {

    // Move and hide.
    $course->category = $config->targetcat;
    $course->visible = 0;
    update_course($course);

    $archived_list .= $course->fullname."<br />";

    // Unenrol students.
    $context = CONTEXT_COURSE::instance($course->id);
    $role = $DB->get_record('role', array('shortname' => 'student'));
    $users = get_role_users($role->id, $context);
    foreach ($users as $user) {
        $instances = $DB->get_records('enrol', array('courseid' => $course->id));
        if (!empty ($instances)) {
            foreach ($instances as $instance) {
                $user_enrolment = $DB->get_record('user_enrolments', array('enrolid' => $instance->id, 'userid' => $user->id));
                if (!empty ($user_enrolment)) {
                    $plugin = enrol_get_plugin($instance->enrol);
                    $plugin->unenrol_user($instance, $user->id);
                }
            }
        }
    }
}

// Delete older courses.
$old_params = array($config->targetcat, $since);
$sql = 'SELECT * FROM {course} WHERE category = ? AND startdate < ?';
$old_courses = $DB->get_records_sql($sql, $old_params);

ob_start();
$deleted_list = '';
foreach ($old_courses as $course) {
    $sucess = delete_course($course);
    if ($sucess) {
        $deleted_list .= $course->fullname.get_string('remove_success', 'block_eledia_course_archiving')."<br />";
        fix_course_sortorder();
    } else {
        $deleted_list .= $course->fullname.get_string('remove_error', 'block_eledia_course_archiving')."<br />";
    }
}
ob_end_clean();

$a = new stdClass();
$a->archived = $archived_list;
$a->deleted = $deleted_list;

$header = get_string('title', 'block_eledia_course_archiving');
$PAGE->set_heading($header);
echo $OUTPUT->header();

notice(get_string('notice', 'block_eledia_course_archiving', $a), $CFG->wwwroot);
echo $OUTPUT->footer();
