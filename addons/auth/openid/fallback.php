<?php

/**
 * OpenID login fallback
 *
 * This file allows OpenID users to log in even if their provider is offline for
 * some reason.  It sends an email with a one-time link to the email address
 * associated with the requested OpenID url.
 *
 * @author Stuart Metcalfe <info@pdl.uk.com>
 * @copyright Copyright (c) 2007 Canonical
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package openid
 **/

require_once("../../config.php");
require_once $CFG->dirroot.'/auth/openid/lib.php';

// We don't want to allow use of this script if OpenID auth isn't enabled
if (!is_enabled_auth('openid') && !is_enabled_auth('openid_sso')) {
    print_error('auth_openid_not_enabled', 'auth_openid');
}

$action = optional_param('openid_action', '', PARAM_CLEAN);
$url = optional_param('openid_url', null);
$data = optional_param('data', '', PARAM_CLEAN);  // Formatted as:  secret/username
$p = optional_param('p', '', PARAM_ALPHANUM);     // Old parameter:  secret
$s = optional_param('s', '', PARAM_CLEAN);        // Old parameter:  username

// First, we set the action if we're handling a submitted data string
if (!empty($data) || (!empty($p) && !empty($s))) {
    $action = 'handle_data';
}

switch ($action) {

// Check the supplied data and log the user in if it matches their secret and
// they have previously been confirmed.
case 'handle_data':
    if (!empty($data)) {
        $dataelements = explode('|',$data);
        $usersecret = $dataelements[0];
        $username   = $dataelements[1];
    } else {
        $usersecret = $p;
        $username   = $s;
    }

    $user = get_complete_user_data('username', $username);

    if (!$user || !$user->confirmed) {
        print_error('user_not_found', 'auth_openid');
    }

    elseif ($user->secret == $usersecret) { // Check for valid secret
        // Delete secret from database
        $secret = random_string(15);
        set_field('user', 'secret', '', 'id', $user->id);
        $USER = get_complete_user_data('username', $username);
        redirect($CFG->wwwroot.'/user/view.php');
    }

    else {
        print_error('fail_match_secret', 'auth_openid');
    }

    break;

// If the user's account is confirmed, set the secret to a random value and send
// an email to the user - unless it's already set (in which case, send a
// duplicate message)
case 'send_message':
    if (!confirm_sesskey()) {
        print_error('auth_openid_bad_session_key', 'auth_openid');
    }
    
    if (!empty($url)) {
        $userid = get_field('openid_urls', 'userid', 'url', $url);
        $user = get_complete_user_data('id', $userid);
        
        if (!$user || !$user->confirmed) {
            print_error('user_not_found', 'auth_openid');
        }
        
        else {
            // Create a secret in the database
            if (empty($user->secret)) {
                $secret = random_string(15);
                set_field('user', 'secret', $secret, 'id', $user->id);
                $user->secret = $secret;
            }
            
            openid_send_fallback_email($user, $url);
            $redirmsg = get_string('fallback_message_sent', 'auth_openid');
            break;
        }
    }
    
// Any other case, just display the fallback form
default:
    $file = 'fallback_form.html';
}

// If a file has been specified, display it with the site header/footer.
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
                 '', '', true, '<div class="langmenu">'.$langmenu.'</div>');
    include $file;

    print_footer();
}

// Otherwise redirect to the home page
else {
    if (!isset($redirmsg)) {
        $redirmsg = '';
    }
    
    redirect($CFG->wwwroot, $redirmsg);
}

?>
