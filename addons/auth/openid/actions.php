<?php

/**
 * OpenID actions
 *
 * This file contains any non-authentication actions such as adding OpenIDs to
 * an account and changing an account to OpenID
 *
 * @author Stuart Metcalfe <info@pdl.uk.com>
 * @copyright Copyright (c) 2007 Canonical
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package openid
 **/

require_once("../../config.php");
require_once("{$CFG->dirroot}/auth/openid/locallib.php");

global $CFG, $USER, $openid_tmp_login;

// We don't want to allow use of this script if OpenID auth isn't enabled
if (!is_enabled_auth('openid')&&!is_enabled_auth('openid_sso')) {
    print_error('auth_openid_not_enabled', 'auth_openid');
}

require_login();

$focus = ''; // BJB101206 - fix undefined variable error
$params = array();
$openid_tmp_login = (isset($_SERVER['HTTP_REFERER']) &&
                     strstr($_SERVER['HTTP_REFERER'],'openid_tmp_login=1'))
                    || optional_param('openid_tmp_login', false, PARAM_BOOL);
if ($openid_tmp_login) {
    $params['openid_tmp_login'] = true;
}
$action = optional_param('openid_action', '');
$url = optional_param('openid_url', null);
$delete_urls = optional_param('delete_urls', array());
$mode = optional_param('openid_mode', null);
$confirm = optional_param('confirm_action', false, PARAM_BOOL);
$cancel = optional_param('cancel_action', false, PARAM_BOOL);
$reqinfo = optional_param('req_info', false, PARAM_BOOL);

$authplugin = get_auth_plugin('openid');
$config = get_config('auth/openid');
if (is_enabled_auth('openid_sso')) {
    if ($url === $config->openid_sso_url) {
        $authplugin = get_auth_plugin('openid_sso');
    }
}

if (!$openid_tmp_login && !empty($USER->id) && $USER->auth == 'openid'
    && $action == 'change') {
    if (empty($config->auth_openid_allow_muliple)) {
        print_error('auth_openid_no_multiple', 'auth_openid');
        exit;
    } else {
        $action = 'append';
    }
}

if (empty($mode) && ($action == 'change' || $action == 'append')) {
    if (empty($url)) {
        if ($authplugin->is_sso()) {
            $url = $config->auth_openid_custom_login;
        } else {
            logout_tmpuser_error(get_string('invalid_url', 'auth_openid', $url));
        }
    }
    $server = $url;
    if (($spos = strpos($url, '//')) !== false &&
        ($epos = strpos(substr($url, $spos + 3), '/')) !== false) {
        $server = substr($url, $spos + 2, $epos + 1);
    }
    if (!openid_server_allowed($server, $config)) {
        logout_tmpuser_error(get_string('auth_openid_server_blacklisted',
                                        'auth_openid', $server));
    }
}

//error_log("auth/openid/action.php:: cancel = {$cancel} (".isset($cancel).",".is_numeric($cancel).") , confirm = {$confirm} (".isset($confirm).",".is_numeric($confirm).")");
// Fix bug: $cancel = 0 when set!
$cancel = !is_numeric($confirm) && is_numeric($cancel);

switch ($action) {

// Change an account type to OpenID
case 'change':
    if ($mode != null) {
        // We need to print a confirmation message before proceeding
        $resp = $authplugin->process_response($_GET, true);

        if ($resp !== false) {
            $tmpemail = '';
            if (method_exists($authplugin,'compare_useremail_response') &&
                !$authplugin->compare_useremail_response($USER, $resp, $tmpemail))
            {
                logout_tmpuser_error(get_string('auth_openid_email_mismatch', 'auth_openid')
                      . $USER->email .' != '. $tmpemail);
            } else {
                $url = $resp->identity_url;
                if (empty($config->auth_openid_confirm_switch) && $openid_tmp_login) {
                    openid_if_unique_change_account($USER, $url);
                } else {
                    $file = 'confirm_change.html';
                }
            }
        } else {
            logout_tmpuser_error(get_string('auth_openid_login_error', 'auth_openid'));
        }
    } elseif ($confirm) {
        if (!confirm_sesskey()) {
            logout_tmpuser_error(get_string('auth_openid_bad_session_key', 'auth_openid'), true);
        } else {
            openid_if_unique_change_account($USER, $url);
        }
    } elseif ($cancel) {
        logout_tmpuser_error(get_string('action_cancelled', 'auth_openid'));
    } elseif ($url != null) {
        if (openid_already_exists($url)) {
            logout_tmpuser_error(get_string('auth_openid_url_exists', 'auth_openid', $url));
        } else {
            //error_log("/auth/openid/actions.php:: url={$url} openid_tmp_login={$openid_tmp_login} referer=". $_SERVER['HTTP_REFERER']);
            $params['openid_action'] = 'change';
            $authplugin->do_request($reqinfo, $CFG->wwwroot.'/auth/openid/actions.php', $params);
        }
    }
    break;

// Append an OpenID url to an account
case 'append':
    if ($mode != null) {
        // We need to print a confirmation message before proceeding
        $resp = $authplugin->process_response($_GET, true);
        
        if ($resp !== false) {
            $url = $resp->identity_url;
            $file = 'confirm_append.html';
        }
    } elseif ($confirm) {
        if (!confirm_sesskey()) {
            logout_tmpuser_error(get_string('auth_openid_bad_session_key', 'auth_openid'), true);
        } else {
            openid_append_url($USER, $url);
        }
    } elseif ($cancel) {
        logout_tmpuser_error(get_string('action_cancelled', 'auth_openid'));
    } elseif ($url != null) {
        if (openid_already_exists($url)) {
            logout_tmpuser_error(get_string('auth_openid_url_exists', 'auth_openid', $url));
        } else {
            $params['openid_action'] = 'append';
            $authplugin->do_request($reqinfo, $CFG->wwwroot.'/auth/openid/actions.php', $params);
        }
    }
    break;

// Delete OpenIDs from an account
case 'delete':
    // Check if any urls selected for delete
    if (sizeof($delete_urls) < 1) {
        print_error('no_urls_selected', 'auth_openid');
    }
    // Prevent users from deleting all their OpenIDs!
    if (sizeof($delete_urls) >= count_records('openid_urls', 'userid', $USER->id)) {
        print_error('cannot_delete_all', 'auth_openid');
    }

    if ($confirm && is_array($delete_urls)) {
        foreach ($delete_urls as $url_id) {
            $url_id = intval($url_id);
            delete_records('openid_urls', 'id', $url_id, 'userid', $USER->id);
        }
    } elseif ($cancel) {
        print_error('action_cancelled', 'auth_openid');
    } elseif (is_array($delete_urls)) {
        $file = 'confirm_delete.html';
    }
    
    break;

// Reject any other action
default:
    print_error('auth_openid_invalid_action', 'auth_openid');
}

if (isset($file)) {
    // Define variables used in page
    if (!$site = get_site()) {
        print_error('auth_openid_no_site', 'auth_openid');
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
    $navlinks = array(array('name' => $loginsite, 'link' => null, 'type' => 'misc'));
    $navigation = build_navigation($navlinks);
    print_header("$site->fullname: $loginsite", $site->fullname, $navigation,
                 $focus, '', true, '<div class="langmenu">'.$langmenu.'</div>');
    include $file;

    print_footer();
} else {
    $urltogo = $CFG->wwwroot.'/user/view.php';
    redirect($urltogo);
}

?>
