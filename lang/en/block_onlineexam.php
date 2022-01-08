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
 * Plugin "Exams (evaexam)"
 *
 * @package    block_onlineexam
 * @copyright  2018 Soon Systems GmbH on behalf of evasys GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/*************************/
/* General.
/*************************/

$string['pluginname'] = 'Exams (evaexam)';
$string['lti'] = 'LTI';
$string['soap'] = 'SOAP';


/*************************/
/* Appearance settings.
/*************************/

$string['setting_heading_appearance'] = 'Appearance';
$string['setting_heading_appearance_desc'] = 'The settings in this section define how the evaexam block will be displayed.';

$string['setting_blocktitle'] = 'Title';
$string['setting_blocktitle_desc'] = 'The text entered here is used as the block title.';

$string['setting_presentation'] = 'Display mode';
$string['setting_presentation_desc'] = 'In compact mode, the evaexam Block displays the number of open exams by means of a graphic. In this mode, an enlarged list view can be opened as soon as the user has at least one open exam by clicking on the graphic.<br />In detailed mode, the evaexam Block displays the list of available exams directly. In this mode, but only when using a SOAP connection, an enlarged list view can be opened as soon as the user has at least one open exam by clicking a button below the list.';
$string['setting_presentation_brief'] = 'Compact';
$string['setting_presentation_detailed'] = 'Detailed';

$string['setting_exam_hide_empty'] = 'Hide empty block';
$string['setting_exam_hide_empty_desc'] = 'If activated, the evaexam block is hidden when the user has no exams. If it is not activated, in the compact view a graphic with the text “No open exams available” is displayed and in the detailed view an empty list is presented.<br /><em>Please note: If the LTI template you are using is configured in a way that participants are allowed to see and/or access results for exams they have taken part in, you may not want to hide the block. Otherwise, the participants would no longer be able to access the results.</em>';

$string['setting_offer_zoom'] = 'Always offer enlarged list view';
$string['setting_offer_zoom_desc'] = 'If activated, the user will always be able to open the enlarged list view. If not activated, the use will only be able to open the enlarged list view if he has open exams.<br /><em>Please note: If the LTI template you are using is configured in a way that participants are allowed to see and/or access results for exams they have taken part in, you will want to enable this setting. Otherwise, the participants would no longer be able to access the results.</em>';

$string['setting_show_spinner'] = 'Show spinner';
$string['setting_show_spinner_desc'] = 'If activated, a spinner icon will be shown in the block until the open exams are loaded from evaexam.';

$string['setting_exam_show_popupinfo'] = 'Pop-up info active';
$string['setting_exam_show_popupinfo_desc'] = 'If activated, a pop-up with an information about open online exams (if existing) is displayed every time a student logs in to Moodle.';

$string['setting_exam_popupinfo_title'] = 'Pop-up title';
$string['setting_exam_popupinfo_title_desc'] = 'If needed, the title of the pop-up can be modified with this setting.';
$string['setting_exam_popupinfo_title_default'] = 'Open exams';

$string['setting_exam_popupinfo_content'] = 'Pop-up content';
$string['setting_exam_popupinfo_content_desc'] = 'If needed, the content which is presented in the pop-up can be modified with this setting.';
$string['setting_exam_popupinfo_content_default'] = '<p>Dear student,</p>
<p>there are currently one or more open online exams available for the courses you have visited.<br />
The exam links are displayed in the block "Exams".</p>
<p>Good luck!<br />
Your exam team</p>';


/*************************/
/* Communication settings.
/*************************/

$string['setting_heading_communication'] = 'Communication';
$string['setting_heading_communication_desc'] = 'The settings in this section define how the evaexam block will communicate with evaexam.';

$string['setting_communication_interface'] = 'Communication protocol';
$string['setting_communication_interface_desc'] = 'Here you can define whether Moodle should communicate with evaexam via SOAP or LTI. <br /><em>Depending on the communication protocol selected here, please do your further settings in the corresponding protocol section below.</em>';

$string['setting_useridentifier'] = 'User identifier';
$string['setting_useridentifier_desc'] = 'Select whether a user\'s email address or username should be used as unique user identifier.';

$string['setting_customfieldnumberinevaexam'] = 'Custom field in evaexam';
$string['setting_customfieldnumberinevaexam_desc'] = 'If the username is selected as user identifier, one of the first three custom fields in evaexam can be used for authentication.<br /><em>Please note: This setting is only relevant for learners. If you decide to use the username for instructors, the username must be stored in evaexam in the field "External ID" of the user settings.</em>';
$string['setting_customfieldnumber'] = 'Custom field No.';

$string['setting_exam_timeout'] = 'Connection timeout';
$string['setting_exam_timeout_desc'] = 'Maximum response time (in seconds) of the evaexam server. If the evaexam server didn\'t answer within this time, the request is aborted and the exams are not shown to the user.';


/*************************/
/* SOAP settings.
/*************************/

$string['setting_heading_soap'] = 'SOAP settings';
$string['setting_heading_soap_desc'] = 'The settings in this section define how the evaexam block will communicate with evaexam.<br /><em>These settings are only required if you selected "SOAP" in the "Communication protocol" setting.</em>';

$string['setting_exam_server'] = 'evaexam SOAP WSDL URL';
$string['setting_exam_server_desc'] = 'URL of the web service description file on the evaexam server (https://[SERVERNAME]/evaexam/services/soapserver-v61.wsdl).<br /><em>Please note: If evaexam is operated with several servers (dual server option), the backend server on which users and administrators work, must be specified here. This prevents a too high load on the online exam server.</em>';

$string['setting_exam_login'] = 'evaexam SOAP path for online exams';
$string['setting_exam_login_desc'] = 'URL of the evaexam online exam login (https://[SERVERNAME]/evaexam/).';

$string['setting_exam_user'] = 'evaexam SOAP username';
$string['setting_exam_user_desc'] = 'User name of the evaexam SOAP user.';

$string['setting_exam_pwd'] = 'evaexam SOAP password';
$string['setting_exam_pwd_desc'] = 'Password of the evaexam SOAP user.';

$string['setting_soap_request_eachtime'] = 'Request SOAP data on every rendering';
$string['setting_soap_request_eachtime_desc'] = 'If activated, the data which is rendered in the evaexam block will be requested from evaexam each time the block is rendered. If not activated, the data is only requested once per session (i.e. only once a user logged into Moodle).';


/*************************/
/* LTI settings.
/*************************/

$string['setting_heading_lti'] = 'LTI settings';
$string['setting_heading_lti_desc'] = 'The settings in this section define how the evaexam block will communicate with evaexam.<br /><em>These settings are only required if you selected "LTI" in the "Communication protocol" setting.</em>';

$string['setting_exam_lti_url'] = 'evaexam LTI provider URL';
$string['setting_exam_lti_url_desc'] = 'URL of the LTI provider PHP file on the evaexam server (https://[SERVERNAME]/customer/lti/lti_provider.php).';

$string['setting_exam_lti_password'] = 'evaexam LTI password';
$string['setting_exam_lti_password_desc'] = 'Password of the evaexam LTI interface.';

$string['setting_lti_customparameters'] = 'evaexam LTI Custom parameter';
$string['setting_lti_customparameters_desc'] = 'Here the custom parameters are stored, which can be used to define settings for displaying the exams, e.g. whether the student view should also display completed exams (learner_show_completed_exams=1) or whether the reports of the exams can also be called up in the instructor view (instructor_show_report=1). Each parameter has to be added on a separate line. For detailed information on the available parameters, please consult the evaexam LTI manual.';

$string['setting_lti_instructormapping'] = 'LTI Role mapping "Instructor"';
$string['setting_lti_instructormapping_desc'] = 'Defines which Moodle roles should correspond to the LTI role "Instructor" who will see the evaexam block content as instructors.';

$string['setting_lti_learnermapping'] = 'LTI Role mapping "Learner"';
$string['setting_lti_learnermapping_desc'] = 'Defines which Moodle roles should correspond to the LTI role "Learner" who will see the evaexam block content as students.';


/*************************/
/* Expert settings.
/*************************/

$string['setting_heading_expert'] = 'Expert settings';
$string['setting_heading_expert_desc'] = 'The settings in this section normally don\'t need any modification and are provided for special usage scenarios.';

$string['setting_exam_debug'] = 'Debug mode';
$string['setting_exam_debug_desc'] = 'If activated, debugging and error messages are shown within the evaexam block.';

$string['setting_additionalcss'] = 'Additional CSS for iframe';
$string['setting_additionalcss_desc'] = 'Here, you can add CSS code which will be added to the page which is loaded in the evaexam block. You can use this setting to re-style the evaexam block content according to your needs.<br /><em>Please note: This setting is used in compact mode for LTI and SOAP connections as well as in detailed mode for SOAP connections. It is not used in detailed mode for LTI connections - if you need to add custom styles in this mode, please change your LTI template in evaexam.</em>';

$string['setting_lti_regex_learner'] = 'LTI - Learner regular expression';
$string['setting_lti_regex_learner_desc'] = 'Regular expression which searches the content of the LTI-Response for open online exams. This only needs to be adjusted if customized templates have been created or modified in a way that the functions differ from the standard templates.<br /><em>Please note: This setting is only processed if you selected "LTI" in the "Communication protocol" setting.</em>';

$string['setting_lti_regex_instructor'] = 'LTI - Instructor regular expression';
$string['setting_lti_regex_instructor_desc'] = 'Regular expression which searches the content of the LTI-Response for open online exams. This only needs to be adjusted if customized templates have been created or modified in a way that the functions differ from the standard templates.<br /><em>Please note: This setting is only processed if you selected "LTI" in the "Communication protocol" setting.</em>';


/*************************/
/* Capabilities.
/*************************/

$string['onlineexam:addinstance'] = 'Add instance of the Exams (evaexam) block';
$string['onlineexam:myaddinstance'] = 'Add instance of the Exams (evaexam) block to my page';
$string['onlineexam:view'] = 'View Exams (evaexam) block';
$string['onlineexam:view_debugdetails'] = 'View debug details';


/*************************/
/* Block content.
/*************************/

$string['exams_exist'] = 'Open exams available';
$string['exams_exist_not'] = 'No open exams available';
$string['allexams'] = 'All exams';
$string['zoomexamlist'] = 'Zoom exam list';


/*************************/
/* Block error messages.
/*************************/

$string['error_config_not_accessible'] = 'Configuration not accessible';
$string['error_debugmode_missing_capability'] = 'The block is in debug mode. You do not have permission to view content.';
$string['error_lti_learnermapping_missing'] = 'Learner role mapping missing';
$string['error_lti_password_missing'] = 'LTI Consumer key missing';
$string['error_lti_settings_error'] = 'LTI settings error';
$string['error_lti_url_missing'] = 'URL for LTI provider missing';
$string['error_occured'] = '<b>An error has occured:</b><br />{$a}<br />';
$string['error_soap_settings_error'] = 'SOAP settings error';
$string['error_exam_curl_timeout_msg'] = 'The exams could not be queried.';
$string['error_exam_login_missing'] = 'Path for online exams missing';
$string['error_exam_pwd_missing'] = 'SOAP password missing';
$string['error_exam_server_missing'] = 'URL for evaexam server missing';
$string['error_exam_user_missing'] = 'SOAP user missing';
$string['error_userid_not_found'] = 'User ID not found';
$string['error_warning_message'] = '<b>Warning:</b><br />{$a}<br />';
$string['error_wsdl_namespace'] = 'WSDL namespace parse error<br />';


/*************************/
/* Privacy.
/*************************/

$string['privacy:metadata:block_onlineexam'] = 'The evaexam block plugin does not store any personal data, but does transmit user data from Moodle to the connected evaexam instance.';
$string['privacy:metadata:block_onlineexam:email'] = 'The user\'s email sent to evaexam to check for existing exams.';
$string['privacy:metadata:block_onlineexam:username'] = 'The user\'s username value sent to evaexam to check for existing exams.';


/*************************/
/* Misc.
/*************************/

$string['setting_blocktitle_multilangnote'] = 'You can define more than one language (e.g. English and German) by using the Moodle multilanguage filter syntax (see https://docs.moodle.org/en/Multi-language_content_filter for details).';

/*************************/
/* Update notices.
/*************************/

$string['upgrade_notice_2020010900'] = 'The recommended version for the EvaExam SOAP API was changed from version 51 to version 61. Thus, the plugin settings where automatically modified during the plugin update.<br />The EvaExam SOAP WSDL URL was up to now: {$a->old}<br />The EvaExam SOAP WSDL URL is now: {$a->new}<br />Please verify that the automatically modified URL is correct.';
$string['upgrade_notice_2021112700'] = 'The block_onlineexam plugin has been upgraded to match the latest version and feature set of block_onlinesurvey. From now on, both plugins will be maintained simultaneously. Due to the fundamental changes, please review the plugin settings and test the plugin thoroughly.';
