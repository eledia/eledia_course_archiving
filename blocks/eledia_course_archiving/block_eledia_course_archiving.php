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
 * Block Definition. The Block gives system informations about user count and moodledata filsize.
 *
 * @package    block
 * @subpackage eledia_course_archiving
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_eledia_course_archiving extends block_base {

    public function init() {
        $this->title   = get_string('title', 'block_eledia_course_archiving');
        $this->version = 2013091300;// Format yyyymmddvv.
    }

    public function applicable_formats() {
        return array('site' => true);
    }

    public function get_content() {
        global $DB, $CFG;
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        $config = get_config('block_eledia_course_archiving');
        if (empty($config->sourcecat)) {
            return $this->content;
        }
        if (empty($config->targetcat)) {
            return $this->content;
        }

        if (has_capability('block/eledia_course_archiving:use', CONTEXT_BLOCK::instance($this->instance->id))) {

            $this->content->text .= '<a href="'.$CFG->wwwroot.'/blocks/eledia_course_archiving/archiving_courses.php" >';
            $this->content->text .= get_string('archive', 'block_eledia_course_archiving');
            $this->content->text .= '</a>';
        }
        return $this->content;
    }

    public function has_config() {
            return true;
    }
}
