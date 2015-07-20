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
 * eledia_course_archiving cron task.
 *
 * @package block_eledia_course_archiving
 * @author Benjamin Wolf <support@eledia.de>
 * @copyright 2015 eLeDia GmbH
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_eledia_course_archiving\task;

defined('MOODLE_INTERNAL') || die();

class eledia_course_archiving_task extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('course_archiving_task', 'block_eledia_course_archiving');
    }

    /**
     * Do the job.
     */
    public function execute() {
        global $CFG, $DB;
        $config = get_config('block_eledia_course_archiving');
        if ($config->run_cron) {
            include_once($CFG->dirroot.'/blocks/eledia_course_archiving/locallib.php');
            $archivement = new \block_eledia_course_archiving();
            $a = $archivement->process_archivment($config);
            mtrace(strip_tags(get_string('notice', 'block_eledia_course_archiving', $a)));
        }
    }
}
