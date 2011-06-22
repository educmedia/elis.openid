<?php

/**
 * OpenID login form
 *
 * This file is principally a copy of the relevant parts of the Moodle
 * /login/index.php file from the default installation.
 *
 * @author Stuart Metcalfe <info@pdl.uk.com>
 * @copyright Copyright (c) 2007 Canonical
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package openid
 **/

require_once("../../config.php");
require_once("{$CFG->dirroot}/auth/openid/locallib.php");

// BJB101123 - see: auth.php::loginpage_hook():line 291
global $frm, $user;

$config = get_config('auth/openid');

$login_opts = optional_param('login','');
$openid_login = optional_param('openid','');
$login_all = empty($config->auth_openid_limit_login) || !empty($login_opts);

    // We don't want to allow use of this script if OpenID auth isn't enabled
    if (!is_enabled_auth('openid')) {
        $errorkey = 'auth_openid_not_enabled';
    }

/// Define variables used in page
    if (!$site = get_site()) {
        $errorkey = 'auth_openid_no_site';
    }

    if (empty($CFG->langmenu)) {
        $langmenu = "";
    } else {
        $currlang = current_language();
        $langs    = get_list_of_languages();
        $langlabel = '<span class="accesshide">'.get_string('language').':</span>';
        $langmenu = popup_form ("$CFG->httpswwwroot/login/index.php?lang=", $langs, "chooselang", $currlang, "", "", "", true, 'self', $langlabel);
    }

    $loginsite = get_string("loginsite");

/// Generate the login page with forms

    $errormsg = empty($session_has_timed_out) ? ''
                : get_string('sessionerroruser', 'error');

    if (get_moodle_cookie() == '') {   
        set_moodle_cookie('nobody');   // To help search for cookies
    }

    // BJB101119: fix undefined variable $authsequence
    if (empty($frm->username) && (empty($authsequence) || !is_array($authsequence) || $authsequence[0] != 'shibboleth')) {  // See bug 5184
        $frm->username = get_moodle_cookie() === 'nobody' ? '' : get_moodle_cookie();
        $frm->password = "";
    }
    
    $focus = !empty($frm->username) ? "password" : "username";

    $show_instructions = $login_all && (!empty($CFG->registerauth) ||
                                        is_enabled_auth('none') ||
                                        !empty($CFG->auth_instructions));
    $columns = $show_instructions ? 'twocolumns' : 'onecolumn';

    /**
     * Following code block moved from: login_form.html
     * to allow SSO redirect before any OUTPUT occurs
     */
    $allow_change = ($config->auth_openid_allow_account_change=='true') && !isguestuser();
    $allow_append = ($config->auth_openid_allow_muliple=='true');
    $user_is_openid = (!empty($USER) && property_exists($USER,'auth') && $USER->auth == 'openid');
    $user_loggedin = !user_not_loggedin();

    $action = null;
    if ($user_loggedin) {
        if (($user_is_openid && $allow_append) || (!$user_is_openid && $allow_change)) {
            $endpoint = $CFG->wwwroot.'/auth/openid/actions.php';
            $action = ($user_is_openid && $allow_append) ? 'append' : 'change';
        } else {
            $errorkey = 'auth_openid_already_loggedin';
        }
    } else {
        $endpoint = $CFG->wwwroot.'/login/index.php';
    }

    if (empty($errorkey)) {
        // NEW OpenID SSO operation
        $oid_plugin = get_auth_plugin('openid');
        if (!$login_all && empty($openid_login) && $oid_plugin->is_sso()) {
            $msg = empty($config->auth_openid_sso_message) ? $errormsg
                   : $config->auth_openid_sso_message;
            redirect("{$endpoint}?openid_url={$config->auth_openid_custom_login}"
                     . "&req_info=1"
                     . ($action ? "&openid_action={$action}" : ''), $msg,
                     empty($msg) ? -1 : 10);
            // TBD: $config->auth_openid_sso_message and delay=>10
        }
    }

    $navlinks = array(array('name' => $loginsite, 'link' => null, 'type' => 'misc'));
    $navigation = build_navigation($navlinks);
    print_header("$site->fullname: $loginsite", $site->fullname, $navigation,
                 $focus, '', true, '<div class="langmenu">'.$langmenu.'</div>');

    if (!empty($errorkey)) {
        print_error($errorkey, 'auth_openid');
    }
    if (!empty($errormsg)) {
        echo '<div class="loginerrors">';
        formerr($errormsg);
        echo '</div>';
    }
    include 'login_form.html';
    print_footer();

?>
