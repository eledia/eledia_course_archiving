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
 * De language file for the plugin.
 *
 * @package    block
 * @subpackage eledia_course_archiving
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['archive'] = 'Start Archiving';

$string['configure_description'] = 'Here you can configure the archiving process. Archiving means the course will be set invisible,
moved to the confiruged archive category and all student users will be unenroled.
All courses which are located directly in the source categories will be checked against the choosen timestamp.
Depending on the timestamp setting there will be the follwoing flow.<br />

Course start date:<br />
If the date is within the timespan of now and the choosen days in the past,
the course will be archived. In a second step all courses in archive categorie are checked.
If it is more than the chosen number of days in the past the course will be deleted.<br />
<br />
Last course activity:<br />
If the date is more than the choosne days in the past , the courses will be archived.
In a second step all courses in archive categorie are checked.
If the courses there are inactive for more than the double number of days in the setting the coruses will be finally deleted.<br />
<br />
The process can be initiated through a form which is linked in the block. The block can be added to the main page only.
As alternative you can set the process to run as a cron job.';
$string['confirm_archiving'] = 'The follwoing courses will be archived:<br />
<br />
{$a->archived}<br />
<br />
The follwoing courses will be deleted:<br />
<br />
{$a->deleted}';
$string['confirm_header'] = 'Confirm Archiving';
$string['course_archiving_task'] = 'Archiving courses';

$string['days'] = 'Number of days to archive';

$string['eledia_course_archiving:addinstance'] = 'add course archiving block';
$string['eledia_course_archiving:use'] = 'use course archiving block';

$string['include_subcategories'] = 'Include all subcategories';

$string['last_activity'] = 'last course activity';

$string['notice'] = 'The follwoing courses were archived:<br />
<br />
{$a->archived}<br />
<br />
The follwoing courses where deleted:<br />
<br />
{$a->deleted}';

$string['remove_success'] = ' - Successful removed';
$string['remove_error'] = ' - Errors while removing';
$string['run_cron'] = 'activate cron task for archivation';

$string['sourcecat'] = 'Categories to archivate';

$string['targetcat'] = 'Archive categorie';
$string['targettimestamp'] = 'Timestamp to check';
$string['title'] = 'Course Archiving';

$string['pluginname'] = 'Course Archiving';
