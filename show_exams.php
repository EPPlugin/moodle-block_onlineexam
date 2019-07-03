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

// #8984
define('BLOCK_ONLINEEXAM_PRESENTATION_BRIEF', "brief");
define('BLOCK_ONLINEEXAM_PRESENTATION_DETAILED', "detailed");

require_once('../../config.php');

require_once('lib.php');

// Block settings.
$config = get_config("block_onlineexam");
$error = '';
$debugmode = false;

// #8984
$css = array();

if (isset($config)) {
    
    $connectiontype = 'LTI';
    $debugmode = $config->exam_debug;
    
    // Session information
    global $USER;
    if ($moodleuserid = $USER->id) {
        $moodleusername = $USER->username;
        $moodleemail = $USER->email;
        $context = null;
        $course = null;
        
        $contextid = optional_param('ctxid', 2, PARAM_INT);
        if(!empty($contextid)){
            $context = context::instance_by_id($contextid);
        }
        
        // lti_regard_coursecontext is not yet supported by EvaExam LTI provider
        if(isset($config->lti_regard_coursecontext) && !empty($config->lti_regard_coursecontext)){
            $courseid = optional_param('cid', 1, PARAM_INT);
            if(!empty($courseid)){
                $course = get_course($courseid);
            }
        }
        
        if(!empty($course)){
            $course = get_course(1);
        }
        
        // #8984
        $modalZoom = optional_param('modalZoom', 0, PARAM_INT);
        
        if ($config->presentation == BLOCK_ONLINEEXAM_PRESENTATION_BRIEF && !$modalZoom) {
            $css[] = $CFG->wwwroot.'/blocks/onlineexam/style/blocks_onlineexam_iframe_compact.css';
        }
        
        if($connectiontype == 'LTI'){
            // nothing to prepare
        }
    } else {
        $error = get_string('userid_not_found', 'block_onlineexam').'<br>';
    }
} else {
    $error = get_string('config_not_accessible', 'block_onlineexam');
}

// #8984
$title = get_string('pluginname', 'block_onlineexam');
if (isset($config) && !empty($config)) {
    
    // Get block title from block setting
    if(!empty($config->blocktitle)){
        // #9381
        $context = context_system::instance();
        $PAGE->set_context($context);
        // END #9381
        $title = format_string($config->blocktitle);
    }
}

echo '<html>'."\n".
        '<head>'."\n".
        '<title>'.$title.'</title>';
foreach ($css as $file) {
    echo '<link rel="stylesheet" href="' . $file . '">'."\n";
}
if (!empty($config->additionalcss)) {
    echo "\n"."<style>".$config->additionalcss."</style>";
}

echo '</head>'."\n".
        '<body>';
// END #8984

if(!empty($error)){
    $context = context_system::instance();
    if (has_capability('moodle/site:config', $context)) {
        if ($error) {
            echo  get_string('error_occured', 'block_onlineexam', $error);
        }
    } else if ($debugmode) {
        echo  get_string('error_occured', 'block_onlineexam', $error);
    }
}
// #8984
else {
    if($connectiontype == 'LTI'){
        block_onlineexam_get_lti_content($config, $context, $course, $modalZoom);
    }
}
echo '</body>';
echo '</html>';
// END #8984
