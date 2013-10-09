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
 * The settings page of the plugin.
 *
 * @package    block
 * @subpackage eledia_course_archiving
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
if ($ADMIN->fulltree) {
    global $DB;
    $configs = array();
    $configs[] = new admin_setting_heading('block_eledia_course_archiving_header', '',
            get_string('configure_description', 'block_eledia_course_archiving'));


    $categories = $DB->get_records('course_categories');
    $options = array();
    foreach ($categories as $category) {
        $options[$category->id] = $category->name;
    }

    $configs[] = new admin_setting_configmultiselect('sourcecat', get_string('sourcecat', 'block_eledia_course_archiving'),
            '', null, $options);
    $options = array(get_string('choose')) + $options;
    $configs[] = new admin_setting_configselect('targetcat', get_string('targetcat', 'block_eledia_course_archiving'),
            '', null, $options);
    $configs[] = new admin_setting_configtext('days', get_string('days', 'block_eledia_course_archiving'),
            '', '365', PARAM_RAW, '10', '1');

    foreach ($configs as $config) {
        $config->plugin = 'block_eledia_course_archiving';
        $settings->add($config);
    }

}