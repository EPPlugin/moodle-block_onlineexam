<?php

/*
EvaExam Online Exams - Moodle Block
Copyright (C) 2018 Soon Systems GmbH on behalf of Electric Paper Evaluationssysteme GmbH

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

Contact:
Soon-Systems GmbH
Syrlinstr. 5
89073 Ulm
Deutschland

E-Mail: info@soon-systems.de
*/

$string['pluginname'] = 'Prüfungen (EvaExam)';

// settings page - general
$string['blocktitle'] = 'Titel';
$string['blocktitle_description'] = '';

$string['useridentifier'] = 'Nutzer-Identifikator';
$string['useridentifier_description'] = 'Als eindeutiger Identifikator eines Nutzers kann wahlweise der Nutzername oder die E-Mail-Adresse übermittelt werden.';

$string['customfieldnumberinevaexam'] = 'Benutzerdatenfeld in EvaExam';
$string['customfieldnumberinevaexam_description'] = 'Bei Verwendung des Nutzernamens als Identifikator können Sie hier festlegen, welches der ersten drei EvaExam-Benutzerdatenfelder zur Authentifizierung verwendet werden soll.';
$string['customfieldnumber'] = 'Benutzerdatenfeld Nr.';

// #8984
$string['presentation'] = 'Darstellungsmodus';
$string['presentation_description'] = 'Die vorhandenen Prüfungen können im EvaExam Block entweder kompakt oder detailiert dargestellt werden.';
$string['presentation_brief'] = 'Kompakt';
$string['presentation_detailed'] = 'Detailliert';
// END #8984

// #8977
$string['exam_hide_empty'] = 'Leeren Block Verbergen';
$string['exam_hide_empty_description'] = 'Wenn aktiviert, wird der EvaExam Block verborgen, wenn kein Prüfungen für den Nutzer vorhanden sind.';
// END #8977
        
$string['exam_show_popupinfo'] = 'Pop-up-Meldung aktiv';
$string['exam_show_popupinfo_description'] = 'Wenn aktiviert, wird Teilnehmern nach dem Login eine Pop-up-Meldung zum Hinweis auf offene Prüfungen angezeigt.';

$string['exam_timeout'] = 'Verbindungstimeout in Sekunden';
$string['exam_timeout_description'] = '';

$string['exam_debug'] = 'DEBUG';
$string['exam_debug_description'] = '';

$string['additionalcss'] = 'Zusätzliches CSS für iframe';
$string['additionalcss_description'] = 'Dieses CSS wird am Ende des HEAD im iframe eingefügt. Dies gilt nur für die Kompaktdarstellung!';
// END: settings page - general

// settings page - LTI
$string['generalheadinglti'] = 'LTI';
$string['lti_general_information'] = 'Die folgenden Angaben sind für die Kommunikation über "LTI" erforderlich.';

$string['exam_lti_url'] = 'URL des LTI-Providers';
$string['exam_lti_url_description'] = '';

// "exam_lti_resourcekey" currently not used -> kept for future
$string['exam_lti_resourcekey'] = 'Anwenderschlüssel';
$string['exam_lti_resourcekey_description'] = '';

$string['exam_lti_password'] = 'LTI-Passwort';
$string['exam_lti_password_description'] = '';

$string['lti_customparameters'] = 'Custom Parameter';
$string['lti_customparameters_description'] = 'Custom Parameter sind Einstellungen, die vom Tool-Provider verwendet werden. Ein Custom-Parameter kann z.B. verwendet werden, um eine bestimmte Information des Providers anzuzeigen. Jeder Parameter sollte in einer eigenen Zeile eingegeben werden, wobei das Format „Name=Wert“ verwendet wird, z.B. "learner_show_completed_exams=1". Für weitere Informationen konsultieren Sie bitte das EvaExam LTI-Handbuch.';

// lti_regard_coursecontext is not yet supported by EvaExam LTI provider -> kept for future
$string['regard_coursecontext'] = 'Kurskontext berücksichtigen';
$string['regard_coursecontext_description'] = 'Kurskontext berücksichtigen: falls ausgewählt, werden nur Prüfungen zum aktuellen Kurs gelistet (sofern) vorhanden';

$string['lti_instructormapping'] = 'Rollenzuweisung "Instructor"';
$string['lti_instructormapping_description'] = 'Hier legen sie fest, welche Moodle-Rollen der LTI-Rolle "Instructor" (= Dozent/in) zugeordnet werden sollen.';

$string['lti_learnermapping'] = 'Rollenzuweisung "Learner"';
$string['lti_learnermapping_description'] = 'Hier legen Sie fest, welche Moodle-Rollen der LTI-Rolle "Learner" (= Studierende/r) zugeordnet werden sollen.';

$string['lti_regex_learner'] = 'Regulärer Ausdruck "Learner"';
$string['lti_regex_learner_description'] = 'Regulärer Ausdruck, der den Inhalt des LTI-Ergebnisses für "Learner" nach offenen Prüfungen durchsucht.';

$string['lti_regex_instructor'] = 'Regulärer Ausdruck "Instructor"';
$string['lti_regex_instructor_description'] = 'Regulärer Ausdruck, der den Inhalt des LTI-Ergebnisses für "Instructor" nach offenen Prüfungen durchsucht.';
// END: settings page - LTI

// capabilities
$string['onlineexam:addinstance'] = 'Instanz des Blocks Prüfungen (EvaExam) hinzufügen';
$string['onlineexam:myaddinstance'] = 'Instanz des Blocks Prüfungen (EvaExam) zu meiner Seite hinzufügen';
$string['onlineexam:view'] = 'Block Prüfungen (EvaExam) anzeigen';
$string['onlineexam:view_debugdetails'] = 'Debug-Details anzeigen';
// END: capabilities

// Block content
$string['tech_error'] = 'Es besteht ein technisches Problem mit dem EvaExam Server.<p>';
$string['conn_works'] = 'Verbindung zum EvaExam-Server erfolgreich getestet.<p>';

// #8977
$string['no_exams'] = 'Keine offenen Prüfungen';
$string['exams_exist'] = 'Offene Prüfungen';
// END #8977

$string['popupinfo_dialog_title'] = 'Offene Prüfungen';
$string['popupinfo'] = 'Liebe(r) Studierende,<br />
<br />
aktuell sind Sie für eine oder mehrere Prüfungen der von Ihnen besuchten Lehrveranstaltungen freigeschaltet.<br />
Die Links zu den Prüfungen werden Ihnen im Block "Prüfungen" angezeigt.<br />
<br />
Viel Erfolg!<br />
<br />
Ihr Prüfungsteam';

$string['exam_list_header'] = '';

$string['lti_settings_error'] = 'LTI - Einstellungsfehler';
$string['lti_url_missing'] = 'URL des LTI-Providers fehlt';
$string['lti_resourcekey_missing'] = 'Anwenderschlüssel fehlt';
$string['lti_password_missing'] = 'LTI Passwort fehlt';
$string['lti_learnermapping_missing'] = 'Learner Rollenmapping fehlt';
$string['userid_not_found'] = 'User-ID nicht gefunden';
$string['config_not_accessible'] = 'Konfiguration nicht zugreifbar';
$string['error_occured'] = '<b>Ein Fehler ist aufgetreten:</b><br /> {$a} <br />';
$string['warning_message'] = '<b>Warnung:</b><br />{$a}<br />';
$string['wsdl_namespace'] = 'WSDL Namespace Fehler beim Parsen<br />';

$string['debugmode_missing_capability'] = 'Der Block befindet sich im Debug-Modus. Ihnen fehlen die Rechte, um Inhalte gelistet zu bekommen.';

// #9403
$string['exam_curl_timeout_msg'] = 'Die Prüfungen konnten leider nicht abgefragt werden.';
// END: Block content
