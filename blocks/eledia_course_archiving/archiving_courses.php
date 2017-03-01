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
 * The page to confirm the process.
 *
 * @package    block
 * @subpackage eledia_course_archiving
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('../../course/lib.php');
global $DB, $CFG;

$context = context_system::instance();
require_login(0, false);
require_capability('moodle/site:config', $context);

$PAGE->set_url('/blocks/eledia_course_archiving/archiving_courses.php');
$PAGE->set_context($context);
$PAGE->set_pagelayout('course');

require_once('archiving_courses_form.php');
$mform = new archiving_courses_form();

// Execute the form.
if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot);
} else if ($genparams = $mform->get_data() && $mform->is_submitted()) {
//    include_once('locallib.php');
    $config = get_config('block_eledia_course_archiving');
    $archivement = new block_eledia_course_archiving\course_archiving_helper();
    $a = $archivement->process_archivment($config);
    notice(get_string('notice', 'block_eledia_course_archiving', $a), $CFG->wwwroot);
}

$header = get_string('title', 'block_eledia_course_archiving');
$PAGE->set_heading($header);

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
