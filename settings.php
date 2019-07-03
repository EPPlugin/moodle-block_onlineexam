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

defined('MOODLE_INTERNAL') || die;

require_once $CFG->dirroot . '/blocks/onlineexam/lib.php';

if ($ADMIN->fulltree) {
    
    /* Block title */
    $settings->add(
            new admin_setting_configtext(
                    'block_onlineexam/blocktitle',
                    get_string('blocktitle', 'block_onlineexam'),
                    get_string('blocktitle_description', 'block_onlineexam'),
                    get_string('pluginname', 'block_onlineexam')
            )
    );
    
    $userdataoptions = array();
    $userdataoptions["email"] = get_string('email');
    $userdataoptions["username"] = get_string('username');
    $settings->add(
            new admin_setting_configselect('block_onlineexam/useridentifier', get_string('useridentifier', 'block_onlineexam'),
                    get_string('useridentifier_description', 'block_onlineexam'),
                    "email", $userdataoptions
            )
    );
    unset($userdataoptions);
    
    $customfieldidoptions = array();
    $customfieldnr = get_string('customfieldnumber', 'block_onlineexam');
    $customfieldidoptions[1] = $customfieldnr." 1";
    $customfieldidoptions[2] = $customfieldnr." 2";
    $customfieldidoptions[3] = $customfieldnr." 3";
    $settings->add(
            new admin_setting_configselect('block_onlineexam/customfieldnumber', get_string('customfieldnumberinevaexam', 'block_onlineexam'),
                    get_string('customfieldnumberinevaexam_description', 'block_onlineexam'),
                    "1", $customfieldidoptions
            )
    );
    unset($customfieldidoptions);
    
    
    // #8984
    $presentationoptions = array();
    $presentationoptions["brief"] = get_string('presentation_brief', 'block_onlineexam');
    $presentationoptions["detailed"] = get_string('presentation_detailed', 'block_onlineexam');
    $settings->add(new admin_setting_configselect('block_onlineexam/presentation', get_string('presentation', 'block_onlineexam'),
            get_string('presentation_description', 'block_onlineexam'),
            "brief", $presentationoptions));
    unset($presentationoptions);
    // END #8984
    
    // #8977
    $settings->add(
            new admin_setting_configcheckbox(
                    'block_onlineexam/exam_hide_empty',
                    get_string('exam_hide_empty', 'block_onlineexam'),
                    get_string('exam_hide_empty_description', 'block_onlineexam'),
                    0
            )
    );
    // END #8977
    
    $settings->add(
            new admin_setting_configcheckbox(
                    'block_onlineexam/exam_show_popupinfo',
                    get_string('exam_show_popupinfo', 'block_onlineexam'),
                    get_string('exam_show_popupinfo_description', 'block_onlineexam'),
                    0
            )
    );
    
    $settings->add(
            new admin_setting_configtext(
                    'block_onlineexam/exam_timeout',
                    get_string('exam_timeout', 'block_onlineexam'),
                    get_string('exam_timeout_description', 'block_onlineexam'),
                    0,
                    PARAM_INT
            )
    );
    
    $settings->add(
            new admin_setting_configcheckbox(
                    'block_onlineexam/exam_debug',
                    get_string('exam_debug', 'block_onlineexam'),
                    get_string('exam_debug_description', 'block_onlineexam'),
                    0
            )
    );
    
    // Addition CSS for iframe content
    $settings->add(
            new admin_setting_configtextarea(
                    'block_onlineexam/additionalcss',
                    get_string('additionalcss', 'block_onlineexam'),
                    get_string('additionalcss_description', 'block_onlineexam'),
                    '',
                    PARAM_RAW,
                    50,
                    6
            )
    );
    
    // Add LTI heading.
    $settings->add(
            new admin_setting_heading('block_onlineexam/generalheadinglti',
                    get_string('generalheadinglti', 'block_onlineexam'),
                    get_string('lti_general_information', 'block_onlineexam')
            )
    );
    
    /* LTI settings */
    $settings->add(
            new admin_setting_configtext(
                    'block_onlineexam/lti_url',
                    get_string('exam_lti_url', 'block_onlineexam'),
                    get_string('exam_lti_url_description', 'block_onlineexam'),
                    '',
                    PARAM_RAW,
                    80
            )
    );
    // Hide "consumer key" for LTI in configurationen -> currently not evaluated in EvaExam
//     $settings->add(
//             new admin_setting_configtext(
//                             'block_onlineexam/lti_resourcekey',
//                             get_string('exam_lti_resourcekey', 'block_onlineexam'),
//                             get_string('exam_lti_resourcekey_description', 'block_onlineexam'),
//                             ''
//             )
//     );
    
    $settings->add(
            new admin_setting_configpasswordunmask(
                    'block_onlineexam/lti_password',
                    get_string('exam_lti_password', 'block_onlineexam'),
                    get_string('exam_lti_password_description', 'block_onlineexam'),
                    ''
            )
    );
    
    // lti custom parameters
    $settings->add(
            new admin_setting_configtextarea(
                    'block_onlineexam/lti_customparameters',
                    get_string('lti_customparameters', 'block_onlineexam'),
                    get_string('lti_customparameters_description', 'block_onlineexam'),
                    '',
                    PARAM_RAW,
                    50,
                    6
            )
    );
    
    // lti role mapping Instructor
    $choices = array();
    // Get some basic data we are going to need.
    $roles = get_all_roles();
    $systemcontext = context_system::instance();
    $rolenames = role_fix_names($roles, $systemcontext, ROLENAME_ORIGINAL);
    if(!empty($rolenames)){
        foreach ($rolenames as $key => $role) {
            if(!array_key_exists($role->id, $choices)){
                $choices[$role->id] = $role->localname;
            }
        }
    }
    $settings->add(
            new admin_setting_configmultiselect(
                    'block_onlineexam/lti_instructormapping',
                    get_string('lti_instructormapping', 'block_onlineexam'),
                    get_string('lti_instructormapping_description', 'block_onlineexam'),
                    array(3,4),
                    $choices
            )
    );
    // lti role mapping Learner
    $settings->add(
            new admin_setting_configmultiselect(
                    'block_onlineexam/lti_learnermapping',
                    get_string('lti_learnermapping', 'block_onlineexam'),
                    get_string('lti_learnermapping_description', 'block_onlineexam'),
                    array(5),
                    $choices
            )
    );
    unset($roles);
    unset($rolenames);
    unset($choices);
    
    $settings->add(
            new admin_setting_configtext(
                    'block_onlineexam/lti_regex_learner',
                    get_string('lti_regex_learner', 'block_onlineexam'),
                    get_string('lti_regex_learner_description', 'block_onlineexam'),
                    BLOCK_ONLINEEXAM_LTI_REGEX_LEARNER_DEFAULT,
                    PARAM_RAW,
                    80
            )
    );
    
    $settings->add(
            new admin_setting_configtext(
                    'block_onlineexam/lti_regex_instructor',
                    get_string('lti_regex_instructor', 'block_onlineexam'),
                    get_string('lti_regex_instructor_description', 'block_onlineexam'),
                    BLOCK_ONLINEEXAM_LTI_REGEX_INSTRUCTOR_DEFAULT,
                    PARAM_RAW,
                    80
            )
    );
    /* END LTI settings */
}
