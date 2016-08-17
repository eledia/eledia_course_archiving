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

$string['archive'] = 'Archivierung starten';

$string['configure_description'] = 'Die Archivierung und Löschung von Kursen konfigurieren Sie hier.
Archivierung bedeutet, dass der Kurs unsichtbar geschaltet und in die ausgewählte Archivierungskategorie (Kursbereich) verschoben wird.
Alle Nutzer/innen mit der Rolle „student“ (Teilnehmer/in) werden aus dem Kurs ausgetragen.
Alle Kurse, die in den ausgewählten Kategorien liegen, werden gegen den eingestellten Zeitstempel geprüft.
Je nach Einstellung des Zeitstempels gibt es dabei folgenden Ablauf für die Archivierung und Löschung.<br />
<br />
Kursbeginn:<br />
Liegt der Kursbeginn zeitlich zwischen der Anzahl an Tagen in der Vergangenheit und dem aktuellen Datum,
wird der Kurs archiviert. Im zweiten Schritt werden alle Kurse in der Archivierungskategorie geprüft.
Wenn der Kursbeginn weiter zurückliegt als die ausgewählte Anzahl an Tagen in der Vergangenheit, wird der Kurs gelöscht.<br />
<br />
Letzte Kursaktivität:<br />
War die letzte Kursaktivität länger her als die eingestellte Anzahl an Tagen, wird der Kurs archiviert.
Im zweiten Schritt werden die Kurse in der Archivierungskategorie geprüft. Diesmal wird verglichen,
ob die letzte Aktivität länger zurückliegt als das doppelte der ausgewählten Anzahl an Tagen.
Wenn das der Fall ist, wird der Kurs endgültig gelöscht.<br />
<br />
Angestoßen wird der Prozess der Archivierung über den Block Kursarchivierung auf der Startseite. Der Link „Archivierung starten“ öffnet eine Seite, die zum einen die Anzahl der zu archivierenden Kurse anzeigt, zum anderen die zu löschenden Kurse auflistet. Über die Schaltfläche „Archivierung starten“ werden die beiden Prozesse ausgelöst.
Alternativ können Sie den Prozess automatisieren über einen Cronjob.';
$string['confirm_archiving'] = 'Die folgenden Kurse werden archiviert:<br />
<br />
{$a->archived}<br />
<br />
Die folgenden Kurse werden gelöscht:<br />
<br />
{$a->deleted}';
$string['confirm_header'] = 'Archivierung Bestätigen';
$string['course_archiving_task'] = 'Kurse Archivieren';

$string['days'] = 'Anzahl der Tage, die rückwirkend betrachtet werden.';

$string['eledia_course_archiving:addinstance'] = 'Kurs-Archivierungs-Block hinzufügen';
$string['eledia_course_archiving:use'] = 'Kurs-Archivierungs-Block verwenden';

$string['include_subcategories'] = 'Alle Unterbereiche einbeziehen';

$string['last_activity'] = 'letzte Kursaktivität';

$string['notice'] = 'Die folgenden Kurse wurden archiviert:<br />
<br />
{$a->archived}<br />
<br />
Die folgenden Kurse wurden gelöscht:<br />
<br />
{$a->deleted}';

$string['remove_success'] = ' - Erfolgreich gelöscht';
$string['remove_error'] = ' - Fehler beim löschen.';
$string['run_cron'] = 'Cron zur Archivierung aktivieren';

$string['sourcecat'] = 'Zu archivierende Kategorien';

$string['targetcat'] = 'Archivkategorie';
$string['targettimestamp'] = 'Zu prüfender Zeitstempel';
$string['title'] = 'Kurs-Archivierung';

$string['pluginname'] = 'Kurs-Archivierung und Löschung';
