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
 * course_archiving Testcase.
 *
 * @package    local
 * @subpackage eledia_course_archiving
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2020 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class local_eledia_course_archiving_testcase extends advanced_testcase {
    public function test_generator() {
        global $DB;

        $this->resetAfterTest(true);
        $generator = $this->getDataGenerator();
        $archivement = new block_eledia_course_archiving\course_archiving_helper();

        // General setting.
        set_config('include_subcategories', 1, 'block_eledia_course_archiving');
        set_config('days', 10, 'block_eledia_course_archiving');

        // Create course categories.
        $cat1 = $generator->create_category(array('name' => 'Testcat'));
        $cat2 = $generator->create_category(array('name' => 'Testcat', 'parent' => $cat1->id));
        $archive = $generator->create_category(array('name' => 'Archiv'));
        set_config('sourcecat', $cat1->id.','.$cat2->id, 'block_eledia_course_archiving');
        set_config('targetcat', $archive->id, 'block_eledia_course_archiving');

        // Testcase 1 check by start date_______________________________________________.
        set_config('targettimestamp', 'startdate', 'block_eledia_course_archiving');
        $config = get_config('block_eledia_course_archiving');

        // Create test courses.
        $course1 = $generator->create_course(array('startdate' => (time() + 100),
            'category' => $cat1->id) );// Course to let be.
        $course2 = $generator->create_course(array('startdate' => (time() - (60 * 60 * 24 * 5)),
            'category' => $cat1->id) );// Course to archive.
        $course3 = $generator->create_course(array('startdate' => (time() - (60 * 60 * 24 * 5)),
            'category' => $cat2->id) );// Course to delete in subcat.

        // Enrol student to delete and teacher to stay.
        $teacher = $generator->create_user(array('username' => 'teacher'));
        $student = $generator->create_user(array('username' => 'student'));
        $generator->enrol_user($teacher->id, $course2->id, 4);
        $generator->enrol_user($student->id, $course2->id, 5);

        // Test the check.
        $result = $archivement->check_courses($config);
        $this->assertEquals(2, count($result->archive), '2 Courses should be found to archive.');
        $this->assertTrue(isset($result->archive[$course2->id]), 'Course 2 not marked for archiving.');
        $this->assertTrue(isset($result->archive[$course3->id]), 'Course 3 not marked for archiving.');

        // Test the process.
        $archivement->process_archivment($config);
        $DB->set_field('course', 'startdate', time() - (60 * 60 * 24 * 15),
            array('id' => $course3->id));// Course to delete in subcat.

        // Test course move.
        $course2 = $DB->get_record('course', array('id' => $course2->id));
        $course3 = $DB->get_record('course', array('id' => $course3->id));
        $this->assertEquals($archive->id, $course2->category, 'Course 2 was not moved to archive.');
        $this->assertEquals($archive->id, $course3->category, 'Course 3 was not moved to archive.');

        // Test enrolments.
        $enrolment = $DB->get_record('enrol', array('enrol' => 'manual', 'courseid' => $course2->id));
        $teacher_enrolment = $DB->record_exists('user_enrolments',
            array('userid' => $teacher->id, 'enrolid' => $enrolment->id));
        $student_enrolment = $DB->record_exists('user_enrolments',
            array('userid' => $student->id, 'enrolid' => $enrolment->id));
        $this->assertTrue($teacher_enrolment, 'Teacher should stay enrolled here but is missing in course.');
        $this->assertFalse($student_enrolment, 'Student should be unenrolled here but is still in course.');

        // Test the check2.
        $result = $archivement->check_courses($config);
        $this->assertTrue(isset($result->delete[$course3->id]), 'Course 3 should be marked for deletion here.');
        $archivement->process_archivment($config);

        // Testcourse deletion.
        $course3_exists = $DB->record_exists('course', array('id' => $course3->id));
        $this->assertEquals(false, $course3_exists, 'Course 3 should be deleted here.');

        // Testcase 2 check by last activity___________________________________________________________________.
        set_config('targettimestamp', 'last_activity', 'block_eledia_course_archiving');
        $config = get_config('block_eledia_course_archiving');

        // Create test courses.
        $course1 = $generator->create_course(array('category' => $cat1->id) );// Course to let be.
        $course2 = $generator->create_course(array('category' => $cat1->id) );// Course to archive.
        $course3 = $generator->create_course(array('category' => $cat2->id) );// Course to delete in subcat.

        // Prepare log unit tests.
        $this->preventResetByRollback();
        set_config('enabled_stores', 'logstore_standard', 'tool_log');
        set_config('buffersize', 0, 'logstore_standard');
        get_log_manager(true);

        // Fake course acticity.
        $eventdata = array('context' => context_course::instance($course1->id));
        $event = \core\event\course_viewed::create($eventdata);
        $event->trigger();
        $eventdata = array('context' => context_course::instance($course2->id));
        $event = \core\event\course_viewed::create($eventdata);
        $event->trigger();
        $eventdata = array('context' => context_course::instance($course3->id));
        $event = \core\event\course_viewed::create($eventdata);
        $event->trigger();

        // Set course2 activity to the past for this test.
        $DB->set_field('logstore_standard_log', 'timecreated',
            (time() - (60 * 60 * 24 * 11)), array('courseid' => $course2->id));
        // Set course3 activity to the past for this test.
        $DB->set_field('logstore_standard_log', 'timecreated',
            (time() - (60 * 60 * 24 * 30)), array('courseid' => $course3->id));

        // Enrol student to delete and teacher to stay.
        $teacher = $generator->create_user(array('username' => 'teacher2'));
        $student = $generator->create_user(array('username' => 'student2'));
        $generator->enrol_user($teacher->id, $course2->id, 4);
        $generator->enrol_user($student->id, $course2->id, 5);

        // Test the check.
        $result = $archivement->check_courses($config);
        $this->assertEquals(2, count($result->archive), '2 Courses should be found to archive.');
        $this->assertTrue(isset($result->archive[$course2->id]), 'Course 2 not marked for archiving.');
        $this->assertTrue(isset($result->archive[$course3->id]), 'Course 3 not marked for archiving.');
        $archivement->process_archivment($config);
        $DB->set_field('course', 'startdate', time() - (60 * 60 * 24 * 15),
            array('id' => $course3->id));// Course to delete in subcat.

        // Test course move.
        $course2 = $DB->get_record('course', array('id' => $course2->id));
        $course3 = $DB->get_record('course', array('id' => $course3->id));
        $this->assertEquals($archive->id, $course2->category, 'Course 2 was not moved to archive.');
        $this->assertEquals($archive->id, $course3->category, 'Course 3 was not moved to archive.');

        // Test enrolments.
        $enrolment = $DB->get_record('enrol', array('enrol' => 'manual', 'courseid' => $course2->id));
        $teacher_enrolment = $DB->record_exists('user_enrolments',
            array('userid' => $teacher->id, 'enrolid' => $enrolment->id));
        $student_enrolment = $DB->record_exists('user_enrolments',
            array('userid' => $student->id, 'enrolid' => $enrolment->id));
        $this->assertTrue($teacher_enrolment, 'Teacher should stay enrolled here but is missing in course.');
        $this->assertFalse($student_enrolment, 'Student should be unenrolled here but is still in course.');

        // Test the check2.
        $result = $archivement->check_courses($config);
        $this->assertTrue(isset($result->delete[$course3->id]), 'Course 3 should be marked for deletion here.');
        $archivement->process_archivment($config);

        // Testcourse deletion.
        $course3_exists = $DB->record_exists('course', array('id' => $course3->id));
        $this->assertEquals(false, $course3_exists, 'Course 3 should be deleted here.');
    }
}
