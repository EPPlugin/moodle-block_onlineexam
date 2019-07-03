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

define('BLOCK_ONLINEEXAM_COMM_LTI', "LTI");
define('BLOCK_ONLINEEXAM_DEFAULT_TIMEOUT', 15);

define('BLOCK_ONLINEEXAM_LTI_REGEX_LEARNER_DEFAULT', '/<(p){1}(.){0,}[\s]{0,}(data-participated="false"){1}[\s]{0,}/');
define('BLOCK_ONLINEEXAM_LTI_REGEX_INSTRUCTOR_DEFAULT', '/<(div){1}[\s]{1,}(class=){1}["|\']{1}[a-z]{0,}[\s]{0,}(response-box){1}[\s]{0,}[a-z]{0,}[\s]{0,}["|\']{1}>/');

/**
 * @param $examCount number of exams
 *
 * @return string
 */
function block_onlineexam_createSummary($examCount) {
    global $USER;

    if ($examCount == 0) {
        $content_str = "<div id=\"block_onlineexam_area\" class=\"block_onlineexam_area\">";
        
        $content_str .=     "<div class=\"block_onlineexam_circle\" >";
        $content_str .=         "<span class=\"block_onlineexam_number\">";
        $content_str .=             "<i class=\"block_onlineexam_number_content\"></i>";
        $content_str .=         "</span>";
        $content_str .=     "</div>";
        
        $content_str .=     '<div class="block_onlineexam_text">' . get_string('no_exams', 'block_onlineexam') . '</div>';
        
        $content_str .= "</div>";
    }
    else {
        $content_str = "<div id=\"block_onlineexam_area\" class=\"block_onlineexam_area block_onlineexam_examsexist\" ".
                "onClick=\"parent.document.getElementById('block_onlineexam_exams_content').click(parent.document);\">";
        
        $content_str .= "<div class=\"block_onlineexam_circle\" >";
        $content_str .= "<span class=\"block_onlineexam_number\">";
        $content_str .= $examCount;
        $content_str .= "</span>";
        $content_str .= "</div>";
        
        $content_str .= '<div class="block_onlineexam_text">' . get_string('exams_exist', 'block_onlineexam') . '</div>';
        
        $content_str .= "</div>";
    }
    
    return $content_str;
}

// #8977
function block_onlineexam_viewScript() {
    return '<script language="JavaScript">'."\n".
            //'   var hiddenelements = parent.document.getElementsByClassName("block_onlineexam card");'."\n".
    '   var hiddenelements = parent.document.getElementsByClassName("block_onlineexam");'."\n".
    '   for (var i = 0; i < hiddenelements.length; i++) {'."\n".
    '       hiddenelements[i].style.display = "block";'."\n".
    '   }'."\n".
    '</script>';
}

/**
 * Helper function that returns an error string
 * @param Array|object|string $err
 * @return string human readable representation of an error
 */
function block_onlineexam_handle_error($err) {
    $error = '';
    if (is_array($err)) {
        // Configuration validation error.
        if (!$err[0]) {
            $error = $err[1];
        }
    } else if (is_string($err)) {
        // Simple error message.
        $error = $err;
    } else {
        // Error should be an exception.
        $error = block_onlineexam_print_exceptions($err);
    }
    return $error;
}

/**
 * Helper function for exceptions
 * @param object $e should be an exception
 * @return string formatted error message of the excetion
 */
function block_onlineexam_print_exceptions($e) {
    $msg = '';
    $msg = $e->getMessage();
    return $msg;
}

/**
 * Request exams via LTI for the current user according to email or username and displays the result.
 * This functions uses functions of '/mod/lti/locallib.php'.
 * Performs a second request via curl to check the result for learner content in order to include code to display popupinfo dialog - if option is selected in the settings.
 * @param string $config block settings of "block_onlineexam"
 * @param string $context context for LTI request - not yet supported by LTI provider
 * @param string $course course for LTI request - not yet supported by LTI provider
 */
function block_onlineexam_get_lti_content($config = null, $context = null, $course = null, $modalZoom = 0){
    global $CFG, $SESSION;
    
    require_once $CFG->dirroot.'/mod/lti/locallib.php';
    
    // #8977
    if(empty($config)){
        $config = get_config("block_onlineexam");
    }
    // END #8977
    
    $courseid = (!empty($course->id)) ? $course->id : 1;
    
    list($endpoint, $parameter) = block_onlineexam_get_launch_data($config, $context, $course);
    
    $debuglaunch = $config->exam_debug;
    
    // #8977
    $examCount = 0;
    
    // Check for learner content in LTI result
    // #8977 + #8984
    if($config->presentation == BLOCK_ONLINEEXAM_PRESENTATION_BRIEF || $config->exam_hide_empty || (!isset($SESSION->block_onlineexam_curl_checked) && !empty($config->exam_show_popupinfo))){
        
        // #9403
        try {
            $content2 = block_onlineexam_lti_post_launch_html_curl($parameter, $endpoint, $config);
        } catch (Exception $e) {
            $lti_content_str = $e->getMessage();
            echo $lti_content_str;
            return '';
        }
        // END #9403
        
        // Search in $content2 for e.g.: <div class="cell participate centered">
        // If match found and exam_show_popupinfo is set, add code to generate popup
        if(!empty($content2)){
            if(isset($config->lti_regex_learner) && !empty($config->lti_regex_learner)){
                $re = $config->lti_regex_learner;
            }
            // No regex in config -> use default regex
            else{
                $re = BLOCK_ONLINEEXAM_LTI_REGEX_LEARNER_DEFAULT;
            }
            
            if(!empty($re)){
                $examCount = preg_match_all($re, $content2, $matches, PREG_SET_ORDER, 0);
                
                $SESSION->block_onlineexam_curl_checked = true;
                
                if(!empty($matches) && !empty($config->exam_show_popupinfo)){
                    // Check to display dialog is (also) done in JS function "evaexamGeneratePopupinfo"
                    echo '<script language="JavaScript">if (typeof window.parent.evaexamGeneratePopupinfo == "function"){ window.parent.evaexamGeneratePopupinfo(); }</script>';
                }
            }
            
            if(isset($config->lti_regex_instructor) && !empty($config->lti_regex_instructor)){
                $re_instructor = $config->lti_regex_instructor;
            }
            // No regex in config -> use default regex
            else{
                $re_instructor = BLOCK_ONLINEEXAM_LTI_REGEX_INSTRUCTOR_DEFAULT;
            }
            if(empty($matches) && !empty($re_instructor)){
                $examCount = preg_match_all($re_instructor, $content2, $matches, PREG_SET_ORDER, 0);
            }
        }
    }
    
    $lti_content_str = '';
    
    // #8977
    if ($config->exam_hide_empty && $examCount > 0 && !$modalZoom) {
        $lti_content_str .= block_onlineexam_viewScript();
    }
    // END #8977
    
    // #8984
    if ($config->presentation == BLOCK_ONLINEEXAM_PRESENTATION_BRIEF && !$modalZoom) {
        $lti_content_str .= block_onlineexam_createSummary($examCount);
    } else {
        
        // #8975
        if(empty($context)){
            $context = context_system::instance();
        }
        if(empty($debuglaunch) || has_capability('block/onlineexam:view_debugdetails', $context)){
            $lti_content_str .= lti_post_launch_html($parameter, $endpoint, $debuglaunch);
            
            if($debuglaunch && has_capability('block/onlineexam:view_debugdetails', $context)){
                $debuglaunch = false;
                //$lti_content_str2 = lti_post_launch_html($parameter, $endpoint, $debuglaunch);
                //echo "$lti_content_str2 <br><br>";
            }
        }
        else{
            $lti_content_str = get_string('debugmode_missing_capability', 'block_onlineexam');
        }
        // END #8975
    }
    // END #8984
    
    echo $lti_content_str;
}

/**
 * Return the endpoint and parameter for lti request based on the block settings.
 * This function uses '/mod/lti/locallib.php'.
 * @param string $config block settings of "block_onlineexam"
 * @param string $context optional context for LTI request - not yet supported by LTI provider
 * @param string $course optional course for LTI request - not yet supported by LTI provider
 * @return multitype:string
 */
function block_onlineexam_get_launch_data($config = null, $context = null, $course = null) {
    global $CFG, $PAGE;
    
    require_once $CFG->dirroot.'/mod/lti/locallib.php';
    
    if(empty($config)){
        $config = get_config("block_onlineexam");
    }
    // Default the organizationid if not specified.
    if (empty($config->lti_tool_consumer_instance_guid)) {
        $urlparts = parse_url($CFG->wwwroot);
        $config->lti_tool_consumer_instance_guid = $urlparts['host'];
    }
    
    if (isset($config->proxyid)) {
        // No proxy support
    }
    else {
        $toolproxy = null;
        if (!empty($config->lti_resourcekey)) {
            $key = $config->lti_resourcekey;
        } else if (is_array($config) && !empty($config['lti_resourcekey'])) {
            $key = $config['lti_resourcekey'];
        } else {
            $key = '';
        }
        if (!empty($config->lti_password)) {
            $secret = $config->lti_password;
        } else if (is_array($config) && !empty($config['lti_password'])) {
            $secret = $config['lti_password'];
        } else {
            $secret = '';
        }
    }
    
    $endpoint = !empty($config->lti_url) ? $config->lti_url : $config['lti_url'];
    $endpoint = trim($endpoint);
    
    // If the current request is using SSL and a secure tool URL is specified, use it.
    if (lti_request_is_using_ssl() && !empty($config->securetoolurl)) {
        $endpoint = trim($config->securetoolurl);
    }
    
    // If SSL is forced, use the secure tool url if specified. Otherwise, make sure https is on the normal launch URL.
    if (isset($config->forcessl) && ($config->forcessl == '1')) {
        if (!empty($config->securetoolurl)) {
            $endpoint = trim($config->securetoolurl);
        }
        
        $endpoint = lti_ensure_url_is_https($endpoint);
    } else {
        if (!strstr($endpoint, '://')) {
            $endpoint = 'http://' . $endpoint;
        }
    }
    
    $orgid = $config->lti_tool_consumer_instance_guid;
    
    if(empty($course)){
        $course = $PAGE->course;
    }
    
    $islti2 = isset($config->proxyid);
    
    $allparams = block_onlineexam_build_request_lti($config, $course);
    
    if(!isset($config->id)){
        $config->id = null;
    }
    $requestparams = $allparams;
    $requestparams = array_merge($requestparams, lti_build_standard_request($config, $orgid, $islti2));
    $customstr = '';
    if (isset($config->lti_customparameters)) {
        $customstr = $config->lti_customparameters;
    }
    
    // The function 'lti_build_custom_parameters' expects some parameters that are not part of the block setting - so we build "dummys"
    $toolproxy = new stdClass();
    $tool = new stdClass();
    $tool->parameter = '';
    $tool->enabledcapability = array();
    $instance = null;
    $instructorcustomstr = null;
    
    $requestparams = array_merge($requestparams, lti_build_custom_parameters($toolproxy, $tool, $instance, $allparams, $customstr, $instructorcustomstr, $islti2));
    
    $target = 'iframe';
    if (!empty($target)) {
        $requestparams['launch_presentation_document_target'] = $target;
    }
    
    // Consumer key currently not used -> $key can be '' --> check "(true or !empty(key))"
    if ((true or !empty($key)) && !empty($secret)) {
        $parms = lti_sign_parameters($requestparams, $endpoint, "POST", $key, $secret);
        
        $endpointurl = new \moodle_url($endpoint);
        $endpointparams = $endpointurl->params();
        
        // Strip querystring params in endpoint url from $parms to avoid duplication.
        if (!empty($endpointparams) && !empty($parms)) {
            foreach (array_keys($endpointparams) as $paramname) {
                if (isset($parms[$paramname])) {
                    unset($parms[$paramname]);
                }
            }
        }
        
    } else {
        // If no key and secret, do the launch unsigned.
        $returnurlparams['unsigned'] = '1';
        $parms = $requestparams;
    }
    
    return array($endpoint, $parms);
}

/**
 * Builds array of parameters for the LTI request
 * @param object $config block settings of "block_onlineexam"
 * @param object $course course that is used for some context attributes
 * @return multitype:string NULL
 */
function block_onlineexam_build_request_lti($config, $course) {
    global $USER;
    
    $roles = block_onlineexam_get_ims_roles($USER, $config);
    
    $intro = '';
    $requestparams = array(
                    'user_id' => $USER->id,
                    'lis_person_sourcedid' => $USER->idnumber,
                    'roles' => $roles,
                    'context_id' => $course->id,
                    'context_label' => $course->shortname,
                    'context_title' => $course->fullname,
    );
    if ($course->format == 'site') {
        $requestparams['context_type'] = 'Group';
    } else {
        $requestparams['context_type'] = 'CourseSection';
        $requestparams['lis_course_section_sourcedid'] = $course->idnumber;
    }
    
    // E-mail address is evaluated in EVERY case, even if it is decided to use the Username instead
    $requestparams['lis_person_contact_email_primary'] = $USER->email;
    
    if (strpos($roles, 'Learner') !== false) {
        if($config->useridentifier == 'email'){
            $requestparams['custom_learner_lms_identifier'] = 'lis_person_contact_email_primary';
            $requestparams['lis_person_contact_email_primary'] = $USER->email;
        }
        else if($config->useridentifier == 'username'){
            $requestparams['custom_learner_lms_identifier'] = 'ext_user_username';
            $requestparams['ext_user_username'] = $USER->username;
            $requestparams['custom_learner_provider_identifier'] = "custom".$config->customfieldnumber;
        }
    }
    if (strpos($roles, 'Instructor') !== false) {
        //$requestparams['custom_instructor_lms_identifier'] = 'ext_user_username';
        //$requestparams['ext_user_username'] = $USER->username;
        
        if($config->useridentifier == 'email'){
            $requestparams['custom_instructor_lms_identifier'] = 'lis_person_contact_email_primary';
            $requestparams['lis_person_contact_email_primary'] = $USER->email;
        }
        else if($config->useridentifier == 'username'){
            $requestparams['custom_instructor_lms_identifier'] = 'ext_user_username';
            $requestparams['ext_user_username'] = $USER->username;
            //$requestparams['custom_instructor_provider_identifier'] = "custom".$config->customfieldnumber;
        }
    }
    
    return $requestparams;
}


/**
 * Gets the LTI role string for the specified user according to lti rolemappings
 *
 * @param object $user user object
 * @param object $config block settings of "block_onlineexam"
 * @return string A role string suitable for passing with an LTI launch
 */
function block_onlineexam_get_ims_roles($user, $config) {
    global $DB;
    
    $roles = array();
    
    // Check if user has "mapped" roles
    $isinstructor = false;
    $lti_mapping = $config->lti_instructormapping;
    if(!empty($lti_mapping)){
        try {
            $lti_mapping = explode(',', $lti_mapping);
            list($sql, $params) = $DB->get_in_or_equal($lti_mapping, SQL_PARAMS_NAMED, 'lti_mapping');
            $params['userid'] = $user->id;
            $isinstructor = $DB->record_exists_select('role_assignments', "userid = :userid and roleid $sql", $params);
        } catch (Exception $e) {
            error_log("error check user roles for 'instructor': ".$e->getMessage());
        }
    }
    $islearner = false;
    $lti_mapping = $config->lti_learnermapping;
    if(!empty($lti_mapping)){
        try {
            $lti_mapping = explode(',', $lti_mapping);
            list($sql, $params) = $DB->get_in_or_equal($lti_mapping, SQL_PARAMS_NAMED, 'lti_mapping');
            $params['userid'] = $user->id;
            $islearner = $DB->record_exists_select('role_assignments', "userid = :userid and roleid $sql", $params);
        } catch (Exception $e) {
            error_log("error check user roles for 'learner': ".$e->getMessage());
        }
    }
    
    
    if (!empty($isinstructor)) {
        array_push($roles, 'Instructor');
    }
    if (!empty($islearner)) {
        array_push($roles, 'Learner');
    }
    
    // #9382: User has NO role in moodle -> use role mapping for learner
    if(empty($roles)){
        array_push($roles, 'Learner');
    }
    // END #9382
    
    if (is_siteadmin($user)) {
        array_push($roles, 'urn:lti:sysrole:ims/lis/Administrator', 'urn:lti:instrole:ims/lis/Administrator');
    }
    
    return join(',', $roles);
}


/**
 * @param array $parameter parameter for LTI request
 * @param string $endpoint endpoint for LTI request
 * @return string result of the curl LTI request
 */
function block_onlineexam_lti_post_launch_html_curl($parameter, $endpoint, $config) {
    
    $retval = '';
    
    $url = $endpoint;
    
    // Set POST variables
    $fields = array();
    
    // Contruct html for the launch parameters.
    foreach ($parameter as $key => $value) {
        $key = htmlspecialchars($key);
        $value = htmlspecialchars($value);
        if ( $key == "ext_submit" ) {
            //
        } else {
            $fields[$key] = urlencode($value);
        }
    }
    // url-ify the data for the POST
    $fields_string = '';
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string, '&');
    
    
    $ch = curl_init($url);
    // Set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    // #9393
    $timeout = isset($config->exam_timeout) ? $config->exam_timeout : BLOCK_ONLINEEXAM_DEFAULT_TIMEOUT;
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    
    $xmlstr = curl_exec($ch);
    
    if ($error_number = curl_errno($ch)) {
        $error_msg_str = curl_error($ch);
        curl_close($ch);
        $retval = $error_msg_str;
        //return $retval;
        
        // #9403
        $msg_output = get_string('exam_curl_timeout_msg', 'block_onlineexam');
        
        $context = context_system::instance();
        if (has_capability('block/onlineexam:view_debugdetails', $context)) {
            if(!empty($msg_output)){
                $msg_output .= "<br><br>"."curl_errno $error_number: $error_msg_str";
            }
        }
        
        if (in_array($error_number, array(CURLE_OPERATION_TIMEDOUT, CURLE_OPERATION_TIMEOUTED))) {
            throw new Exception("$msg_output");
        }
        // END #9403
    }
    
    curl_close($ch);
    
    if (empty($xmlstr) or !$xmlstr or !trim($xmlstr)) {
        return $retval;
    }
    else{
        $retval = $xmlstr;
    }
    
    return $retval;
}
