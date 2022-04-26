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
 * Plugin "Exams (evaexam)" - Local library
 *
 * @package    block_onlineexam
 * @copyright  2018 Soon Systems GmbH on behalf of evasys GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

define('BLOCK_ONLINEEXAM_COMM_SOAP', "SOAP");
define('BLOCK_ONLINEEXAM_DEFAULT_TIMEOUT', 15);

define('BLOCK_ONLINEEXAM_PRESENTATION_BRIEF', "brief");
define('BLOCK_ONLINEEXAM_PRESENTATION_DETAILED', "detailed");

/**
 * Request exams for the current user according to email or username and displays the result.
 * @param string $config block settings of "block_onlineexam"
 * @param string $moodleusername username for SOAP request
 * @param string $moodleemail email for SOAP request
 * @param int $modalzoom indicates if the modal list popup is open or not
 * @return string
 */
function block_onlineexam_get_soap_content($config = null, $moodleusername = '', $moodleemail = '', $modalzoom = 0) {
    global $SESSION;

    $examurl = 'indexstud.php?type=html&user_tan=';

    if (empty($config)) {
        $config = get_config("block_onlineexam");
    }

    $examurl = $config->exam_login.$examurl;
    $wsdl = $config->exam_server;
    $soapuser = $config->exam_user;
    $soappassword = $config->exam_pwd;
    $debugmode = $config->exam_debug;

    $hideempty = $config->exam_hide_empty;
    $offerzoom = $config->offer_zoom;

    $timeout = isset($config->exam_timeout) ? $config->exam_timeout : BLOCK_ONLINEEXAM_DEFAULT_TIMEOUT;

    // Parse wsdlnamespace from the wsdl url.
    preg_match('/\/([^\/]+\.wsdl)$/', $wsdl, $matches);

    $soapcontentstr = '';

    if (count($matches) == 2) {
        $wsdlnamespace = $matches[1];

        $soapconfigobj = new stdClass();
        $soapconfigobj->wsdl = $wsdl;
        $soapconfigobj->timeout = $timeout;
        $soapconfigobj->debugmode = $debugmode;
        $soapconfigobj->soapuser = $soapuser;
        $soapconfigobj->soappassword = $soappassword;
        $soapconfigobj->wsdlnamespace = $wsdlnamespace;
        $soapconfigobj->useridentifier = $config->useridentifier;
        $soapconfigobj->moodleemail = $moodleemail;
        $soapconfigobj->moodleusername = $moodleusername;
        $soapconfigobj->customfieldnumber = $config->customfieldnumber;
        $soapconfigobj->coursecode = '';

        $result = new stdClass();

        $soaprequesteachtime = $config->soap_request_eachtime;

        // Get exams if no exams in SESSION or debug mode for the block is enabled.
        if (!isset($SESSION->block_onlineexam_examkeys) || $debugmode || $soaprequesteachtime) {
            $result = block_onlineexam_get_exams($soapconfigobj);
            $SESSION->block_onlineexam_examkeys = $result->exams;

            $SESSION->block_onlineexam_error = $result->error;
        }

        if (isset($SESSION->block_onlineexam_error)) {
            $result->error = $SESSION->block_onlineexam_error;
        }

        if (is_object($SESSION->block_onlineexam_examkeys)) {
            if (!is_array($SESSION->block_onlineexam_examkeys->OnlineExamKeys)) {
                $SESSION->block_onlineexam_examkeys->OnlineExamKeys = array(
                                $SESSION->block_onlineexam_examkeys->OnlineExamKeys
                );
            }

            $count = count($SESSION->block_onlineexam_examkeys->OnlineExamKeys);

            $count2 = 0;

            $examsfound = false;
            foreach ($SESSION->block_onlineexam_examkeys->OnlineExamKeys as $examkey) {
                if (!empty($examkey->TransactionNumber) && ($examkey->TransactionNumber != null &&
                        $examkey->TransactionNumber !== 'null')) {
                    $examsfound = true;

                    $count2++;
                }
            }

            if ($hideempty && $count2 > 0) {
                $soapcontentstr .= block_onlineexam_viewscript();
            }

            if (!$offerzoom && $count2 > 0 && !$modalzoom) {
                $soapcontentstr .= block_onlineexam_exambuttonscript();
            }

            if ($count2 > 0 && !$modalzoom) {
                $soapcontentstr .= block_onlineexam_highlightscript($count2);
            } else if ($count2 == 0 && !$modalzoom) {
                $soapcontentstr .= block_onlineexam_donthighlightscript();
            }

            if ($config->presentation == BLOCK_ONLINEEXAM_PRESENTATION_BRIEF && !$modalzoom) {

                $soapcontentstr .= block_onlineexam_createsummary($count2);

                // Exams found.
                if ($count2 && $examsfound) {
                    if (!empty($config->exam_show_popupinfo)) {
                        $soapcontentstr .= '<script language="JavaScript">'.
                                'if (typeof window.parent.evaexamGeneratePopupinfo == "function") { '.
                                'window.parent.evaexamGeneratePopupinfo(); }</script>';
                    }
                }

            } else {

                // Exams found.
                if ($count && $examsfound) {
                    $soapcontentstr .= '<ul class="block_onlineexam_exam_list">';

                    $cnt = 0;
                    foreach ($SESSION->block_onlineexam_examkeys->OnlineExamKeys as $examkey) {
                        if ($examkey->TransactionNumber !== 'null') {
                            $cnt++;

                            $soapcontentstr .= '<li class="exam">';
                            $soapcontentstr .= "<a id=\"examlink_".$cnt."\" ".
                                    "href=\"$examurl" . "{$examkey->TransactionNumber}\" ".
                                    "target=\"_blank\">$examkey->CourseName</a>";
                            $soapcontentstr .= '</li>';

                        }
                    }
                    $soapcontentstr .= '</ul>';

                    if (!empty($config->exam_show_popupinfo)) {
                        $soapcontentstr .= '<script language="JavaScript">'.
                                'if (typeof window.parent.evaexamGeneratePopupinfo == "function") { '.
                                'window.parent.evaexamGeneratePopupinfo(); }</script>';
                    }
                } else {
                    $soapcontentstr = '<div class="block_onlineexam_info">'.
                            get_string('exams_exist_not', 'block_onlineexam').'</div>';
                }
            }
        } else if (empty($SESSION->block_onlineexam_examkeys)) {
            $soapcontentstr = '<div class="block_onlineexam_info">'.get_string('exams_exist_not', 'block_onlineexam').
                    '</div>';
        }

        if (isset($result->error) && !empty($result->error)) {
            $soapcontentstr = get_string('error_occured', 'block_onlineexam', $result->error);
        }

        // TODO: Check, was hier angezeigt werden soll.
        if ($debugmode && isset($result->warning) && !empty($result->warning)) {
            $soapcontentstr = get_string('error_warning_message', 'block_onlineexam', $result->warning) ."<br>" . $soapcontentstr;
        }
    } else {
        if ($debugmode) {
            $soapcontentstr = get_string('error_wsdl_namespace', 'block_onlineexam');
        }
    }

    echo $soapcontentstr;
}

/**
 * Returns a string with HTML code for the compact view.
 *
 * @param int $examcount number of exams
 * @return string
 */
function block_onlineexam_createsummary($examcount) {
    $offerzoom = get_config('block_onlineexam', 'offer_zoom');
    if ($examcount == 0 && $offerzoom == false) {
        $contentstr = "<div id=\"block_onlineexam_area\" class=\"block_onlineexam_area\">";

        $contentstr .= "<div class=\"block_onlineexam_circle\" >";
        $contentstr .= "<span class=\"block_onlineexam_number\">";
        $contentstr .= "<i class=\"fa fa-check\"></i>";
        $contentstr .= "</span>";
        $contentstr .= "</div>";

        $contentstr .= '<div class="block_onlineexam_text">' . get_string('exams_exist_not', 'block_onlineexam') . '</div>';

        $contentstr .= "</div>";
    } else if ($examcount == 0 && $offerzoom == true) {
        $contentstr = "<div id=\"block_onlineexam_area\" class=\"block_onlineexam_area block_onlineexam_offerzoom\" ".
            "onClick=\"parent.document.getElementById('block_onlineexam_exams_content').click(parent.document);\">";

        $contentstr .= "<div class=\"block_onlineexam_circle\" >";
        $contentstr .= "<span class=\"block_onlineexam_number\">";
        $contentstr .= "<i class=\"fa fa-check\"></i>";
        $contentstr .= "</span>";
        $contentstr .= "<div class=\"block_onlineexam_compact_magnifier\">";
        $contentstr .= "<i class=\"fa fa-search-plus\"></i>";
        $contentstr .= "</div>";
        $contentstr .= "</div>";

        $contentstr .= '<div class="block_onlineexam_text">' . get_string('exams_exist_not', 'block_onlineexam') . '</div>';

        $contentstr .= "</div>";
    } else {
        if ($examcount > 0 && $examcount <= 3) {
            $examcountclass = 'block_onlineexam_examcount_'.$examcount;
        }
        if ($examcount > 3) {
            $examcountclass = 'block_onlineexam_examcount_gt3';
        }

        $contentstr = "<div id=\"block_onlineexam_area\" ".
                "class=\"block_onlineexam_area block_onlineexam_examsexist ".$examcountclass."\" ".
                "onClick=\"parent.document.getElementById('block_onlineexam_exams_content').click(parent.document);\">";

        $contentstr .= "<div class=\"block_onlineexam_circle\" >";
        $contentstr .= "<span class=\"block_onlineexam_number\">";
        $contentstr .= $examcount;
        $contentstr .= "</span>";
        $contentstr .= "<div class=\"block_onlineexam_compact_magnifier\">";
        $contentstr .= "<i class=\"fa fa-search-plus\"></i>";
        $contentstr .= "</div>";
        $contentstr .= "</div>";

        $contentstr .= '<div class="block_onlineexam_text">' . get_string('exams_exist', 'block_onlineexam') . '</div>';

        $contentstr .= "</div>";
    }

    return $contentstr;
}

/**
 * Returns a string with a <script> tag which shows the previously hidden block.
 *
 * @return string
 */
function block_onlineexam_viewscript() {
    return '<script language="JavaScript">'."\n".
            '   var hiddenelements = parent.document.getElementsByClassName("block_onlineexam");'."\n".
            '   for (var i = 0; i < hiddenelements.length; i++) {'."\n".
            '       hiddenelements[i].style.display = "block";'."\n".
            '   }'."\n".
            '</script>';
}

/**
 * Returns a string with a <script> tag which shows the previously hidden 'zoom exam list' button.
 *
 * @return string
 */
function block_onlineexam_exambuttonscript() {
    return '<script language="JavaScript">'."\n".
            '   var hiddenelements = parent.document.getElementsByClassName("block_onlineexam_allexams");'."\n".
            '   for (var i = 0; i < hiddenelements.length; i++) {'."\n".
            '       hiddenelements[i].style.display = "block";'."\n".
            '   }'."\n".
            '</script>';
}

/**
 * Returns a string with a <script> tag which adds a class to indicate that exams exist.
 *
 * @param int $examcount The number of open exams.
 * @return string
 */
function block_onlineexam_highlightscript($examcount) {
    if ($examcount > 0 && $examcount <= 3) {
        $examcountclass = 'block_onlineexam_examcount_'.$examcount;
    }
    if ($examcount > 3) {
        $examcountclass = 'block_onlineexam_examcount_gt3';
    }

    return '<script language="JavaScript">'."\n".
            '   var parentelements = parent.document.getElementsByClassName("block_onlineexam");'."\n".
            '   for (var i = 0; i < parentelements.length; i++) {'."\n".
            '       parentelements[i].classList.add("block_onlineexam_examsexist");'."\n".
            '       parentelements[i].classList.add("'.$examcountclass.'");'."\n".
            '   }'."\n".
            '</script>';
}

/**
 * Returns a string with a <script> tag which removes a class to indicate that no exams exist.
 *
 * @return string
 */
function block_onlineexam_donthighlightscript() {
    return '<script language="JavaScript">'."\n".
            '   var parentelements = parent.document.getElementsByClassName("block_onlineexam");'."\n".
            '   for (var i = 0; i < parentelements.length; i++) {'."\n".
            '       parentelements[i].classList.remove("block_onlineexam_examsexist");'."\n".
            '   }'."\n".
            '</script>';
}

/**
 * Perform SOAP request for exams of a user according to user email or username.
 *
 * @param object $soapconfigobj Object containing data for SOAP request.
 * @return object Object containing exams if present and errors or warnings of the onlineexam_soap_client
 */
function block_onlineexam_get_exams($soapconfigobj) {
    $retval = new stdClass();
    $retval->error = null;
    $retval->warning = null;
    $retval->exams = false;
    try {
        require_once('onlineexam_soap_client.php');

        $client = new onlineexam_soap_client( $soapconfigobj->wsdl,
                array(
                        'trace' => 1,
                        'feature' => SOAP_SINGLE_ELEMENT_ARRAYS,
                        'connection_timeout' => $soapconfigobj->timeout),
                $soapconfigobj->timeout,
                $soapconfigobj->debugmode
        );

        $header = array(
                'Login' => $soapconfigobj->soapuser,
                'Password' => $soapconfigobj->soappassword
        );

        if (is_object($client)) {
            if ($client->haswarning) {
                $retval->warning = $client->warnmessage;
            }

            $soapheader = new SoapHeader($soapconfigobj->wsdlnamespace, 'Header', $header);
            $client->__setSoapHeaders($soapheader);
        } else {
            $retval->error = block_onlineexam_handle_error("SOAP client configuration error");
            return $result;
        }

        if (!empty($soapconfigobj->useridentifier)) {
            if ($soapconfigobj->useridentifier == 'email') {
                if ($soapconfigobj->moodleemail) {
                    $retval->exams = $client->GetPswdsByParticipant($soapconfigobj->moodleemail);
                }
            } else if ($soapconfigobj->useridentifier == 'username') {
                $retval->exams = $client->GetPswdsByParticipant($soapconfigobj->moodleusername,
                        $soapconfigobj->coursecode, $soapconfigobj->customfieldnumber);
            }
        }
    } catch (Exception $e) {
        $retval->error = block_onlineexam_handle_error($e);
        return $retval;
    }
    return $retval;
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
    if (get_class($e) == "SoapFault") {
        $msg = "{$e->faultstring}";

        $context = context_system::instance();
        if (has_capability('block/onlineexam:view_debugdetails', $context)) {
            $detail = '';
            if (isset($e->detail) && !empty($e->detail)) {
                $detail = $e->detail;
                if (is_object($detail) && isset($detail->tSoapfault)) {
                    $detail = $detail->tSoapfault;
                    if (isset($detail->sDetails)) {
                        $detail = $detail->sDetails;
                    }
                }

                $msg .= "<br>".$detail;
            }
        }
    } else {
        $msg = $e->getMessage();
    }

    return $msg;
}
