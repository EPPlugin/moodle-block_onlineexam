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

$string['pluginname'] = 'Exams (EvaExam)';

// settings page - general
$string['blocktitle'] = 'Title';
$string['blocktitle_description'] = '';

// #8984
$string['presentation'] = 'Presentation';
$string['presentation_description'] = 'The EvaExam Block can present either a brief summary or a detailed overview of the open exams.';
$string['presentation_brief'] = 'brief';
$string['presentation_detailed'] = 'detailed';
// END #8984

// #8977
$string['exam_hide_empty'] = 'Hide empty block';
$string['exam_hide_empty_description'] = 'If activated, the EvaExam block is hidden if the current user has no open exams.';
// END #8977

$string['useridentifier'] = 'User Identifier';
$string['useridentifier_description'] = 'You can either transmit the user login name or email address as unique identifier.';

$string['customfieldnumberinevaexam'] = 'Custom field in EvaExam';
$string['customfieldnumberinevaexam_description'] = 'When using the login name as identifier you can specifiy, which of the first three custom fields in EvaExam should be used for authentication.';
$string['customfieldnumber'] = 'Custom field No.';

$string['exam_show_popupinfo'] = 'Pop-up-Info active';
$string['exam_show_popupinfo_description'] = 'If activated, a pop-up message is displayed upon login of a user, giving notice of open exams.';

$string['exam_timeout'] = 'Connection timeout in seconds';
$string['exam_timeout_description'] = '';

$string['exam_debug'] = 'DEBUG';
$string['exam_debug_description'] = '';

$string['additionalcss'] = 'Additional CSS for iframe';
$string['additionalcss_description'] = 'Content here will be added as CSS to the bottom of HEAD in iframe. This only applies to the compact representation!';
// END: settings page - general

// settings page - LTI
$string['generalheadinglti'] = 'LTI';
$string['lti_general_information'] = 'The following information is required for communication via "LTI".';

$string['exam_lti_url'] = 'URL of the LTI Provider';
$string['exam_lti_url_description'] = '';

// "exam_lti_resourcekey" currently not used -> kept for future
$string['exam_lti_resourcekey'] = 'Consumer key';
$string['exam_lti_resourcekey_description'] = '';

$string['exam_lti_password'] = 'LTI password';
$string['exam_lti_password_description'] = '';

$string['lti_customparameters'] = 'Custom parameters';
$string['lti_customparameters_description'] = 'Custom parameters are settings used by the tool provider. For example, a custom parameter may be used to display
a specific resource from the provider. Each parameter should be entered on a separate line using a format of "name=value"; for example, "learner_show_completed_exams=1". For further information please refer to the EvaExam LTI Manual.';

// lti_regard_coursecontext is not yet supported by EvaExam LTI provider -> kept for future
$string['regard_coursecontext'] = 'Consider course context';
$string['regard_coursecontext_description'] = 'Consider course context: If selected, only exams of the current course are shown.';

$string['lti_instructormapping'] = 'Role mapping "Instructor"';
$string['lti_instructormapping_description'] = 'Here you can define which Moodle roles shall be mapped on the LTI role "instructor".';

$string['lti_learnermapping'] = 'Role mapping "Learner"';
$string['lti_learnermapping_description'] = 'Here you can define which Moodle roles shall be mapped on the LTI role "learner".';

$string['lti_regex_learner'] = 'Learner regular expression';
$string['lti_regex_learner_description'] = 'Regular expression to search for open online exams for "learners" in the LTI result.';

$string['lti_regex_instructor'] = 'Instructor regular expression';
$string['lti_regex_instructor_description'] = 'Regular expression to search for open online exams for "instructor" in the LTI result.';
// END: settings page - LTI

// capabilities
$string['onlineexam:addinstance'] = 'Add instance of the Exams (EvaExam) block';
$string['onlineexam:myaddinstance'] = 'Add instance of the Exams (EvaExam) block to my page';
$string['onlineexam:view'] = 'View Exams (EvaExam) block';
$string['onlineexam:view_debugdetails'] = 'View debug details';
// END: capabilities

// Block content
$string['tech_error'] = 'A technical problem occured while connecting to EvaExam.<p>';
$string['conn_works'] = 'Connection to EvaExam server tested successfully.<p>';
// #8977
$string['no_exams'] = 'No open exams available';
$string['exams_exist'] = 'Open exams available';
// END #8977
$string['popupinfo_dialog_title'] = 'Open exams';
$string['popupinfo'] = 'Dear student,<br />
<br />
there are currently one or more open online exams available for the courses you have visited.<br />
The exam links are displayed in the block "Exams". <br />
<br />
Good luck!<br />
Your exam team';

$string['exam_list_header'] = '';

$string['lti_settings_error'] = 'LTI settings error';
$string['lti_url_missing'] = 'URL for LTI provider missing';
$string['lti_resourcekey_missing'] = 'Consumer key missing';
$string['lti_password_missing'] = 'LTI Consumer key missing';
$string['lti_learnermapping_missing'] = 'Learner role mapping missing';
$string['userid_not_found'] = 'User ID not found';
$string['config_not_accessible'] = 'Configuration not accessible';
$string['error_occured'] = '<b>An error has occured:</b><br />{$a}<br />';
$string['warning_message'] = '<b>Warning:</b><br />{$a}<br />';
$string['wsdl_namespace'] = 'WSDL namespace parse error<br />';

$string['debugmode_missing_capability'] = 'The block is in debug mode. You do not have permission to view content.';

// #9403
$string['exam_curl_timeout_msg'] = 'The exams could not be queried.';
// END: Block content
