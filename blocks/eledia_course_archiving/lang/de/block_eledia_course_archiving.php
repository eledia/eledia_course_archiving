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
 * En language file for the plugin.
 *
 * @package    block
 * @subpackage eledia_course_archiving
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['archive'] = 'Archivierung starten';

$string['configure_description'] = 'Hier kann der Archivierungsprozess konfiguriert werden.
    Alle Kurse, die in den ausgewählten Kategorien liegen, werden gegen Ihren Kursbeginn geprüft. Liegt der Kursbeginn zwischen
    dem aktuellen Datum und der ausgwählten Anzahl an Tagen in der Vergangenheit, wird der Kurs archiviert.
    Archivierung bedeutet, dass der Kurs unsichtbar geschaltet wird, in die ausgewählte Archivierungskategorie verschoben
    und alle Nutzer mit der Rolle student aus dem Kurs ausgetragen werden. Im zweiten Schritt werden alle Kurs in der Archivierungskategorie
    gegen ihren Kursbeginn geprüft. Wenn der Kursbeginn weiter zurückliegt als die ausgewählte Anzahl an Tagen in der Vergangenheit, wird der Kurs gelöscht.<br /><br />
    Angestoßen wird der Prozess mit einem Formular das im Block verlinkt ist. Der Block kann nur auf der Startseite eingbunden werden.';
$string['confirm_archiving'] = 'Die folgenden Kurse werden archiviert:<br />
<br />
{$a->archived}<br />
<br />
Die folgenden Kurse werden gelöscht:<br />
<br />
{$a->deleted}';
$string['confirm_header'] = 'Archivierung Bestätigen';
$string['course_archiving_task'] = 'Kurse Archivieren';

$string['days'] = 'Anzahl der Tage die rückwirkend betrachtet werden.';

$string['eledia_course_archiving:addinstance'] = 'Kurs-Archivierungs-Block hinzufügen';
$string['eledia_course_archiving:use'] = 'Kurs-Archivierungs-Block verwenden';

$string['notice'] = 'Die folgenden Kurse wurden archiviert:<br />
<br />
{$a->archived}<br />
<br />
Die folgenden Kurse wurden gelöscht:<br />
<br />
{$a->deleted}';

$string['remove_success'] = ' - Erfolgreich gelöscht';
$string['remove_error'] = ' - Fehler beim löschen.';
$string['run_cron'] = 'cron zur Archivierung aktivieren';

$string['sourcecat'] = 'Zu archivierde Kategorien';

$string['targetcat'] = 'Archivkategorie';
$string['title'] = 'Kurs-Archivierung';

$string['pluginname'] = 'Kurs-Archivierung';
