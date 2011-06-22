<?php

/**
 * OpenID module/auth library functions
 *
 * @author Stuart Metcalfe <info@pdl.uk.com>
 * @copyright Copyright (c) 2007 Canonical
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package openid
 */

define('OPENID_GREYLIST', 0);
define('OPENID_BLACKLIST', 1);
define('OPENID_WHITELIST', 2);

// Settings for config->openid_non_whitelisted_status
define('OPENID_NONWHITELISTED_CONFIRM', 0);
define('OPENID_NONWHITELISTED_DENY',    1);
define('OPENID_NONWHITELISTED_ALLOW',   2);

// Create the store directories if they don't exist
$store_dirs = array('openid/associations', 'openid/nonces', 'openid/temp');

foreach ($store_dirs as $store_dir) {
    if (!file_exists($CFG->dataroot.'/'.$store_dir) && !make_upload_directory($store_dir)) {
        // TBD: won't get here if make_upload_directory() fails throws exception
        //      unless argument#2 set to false.
        print_error('auth_openid_store_no_write', 'auth_openid');
    }
}

/**
 * fnmatch function is not available on non-posix system.  This should be a
 * suitable replacement for our purposes (ie: wildcard pattern matching for
 * server addresses like '*.php.net')
 */
if (!function_exists('fnmatch')) {
    function fnmatch($pattern, $string) {
        return @preg_match(
            '/^' . strtr(addcslashes($pattern, '/\\.+^$(){}=!<>|'),
            array('*' => '.*', '?' => '.?')) . '$/i', $string
        );
    }
}

/**
 * Check if an OpenID Server is listed as specified type
 *
 * @param string $server - server to match
 * @param int $listtype - the list type id
 * @return boolean
 */
function openid_server_is_listed($server, $listtype) {
    $servers = get_records('openid_servers', 'listtype', $listtype);
    if ($servers) {
        foreach ($servers as $op) {
            if (true === fnmatch($op->server, $server)) {
                return true;
            }
        }
    }
    return false;
}

/**
 * Check if an OpenID server is whitelisted
 *
 * @param string $server
 * @return boolean
 */
function openid_server_is_whitelisted($server) {
    return openid_server_is_listed($server, OPENID_WHITELIST);
}

/**
 * Check if an OpenID server is blacklisted
 *
 * @param string $server
 * @return boolean
 */
function openid_server_is_blacklisted($server) {
    return openid_server_is_listed($server, OPENID_BLACKLIST);
}

/**
 * Check if an OpenID server is greylisted
 *
 * @param string $server
 * @return boolean
 */
function openid_server_is_greylisted($server) {
    return openid_server_is_listed($server, OPENID_GREYLIST);
}

/**
 * Check if an OpenID server is allowed
 *
 * @param string $server
 * @param optional object $config - the OpenID auth plugin config settings
 * @return boolean
 */
function openid_server_allowed($server, $config = null) {
    if ($config == null) {
        $config = get_config('auth/openid');
    }
    switch ($config->openid_non_whitelisted_status) {
        case OPENID_NONWHITELISTED_ALLOW:
        case OPENID_NONWHITELISTED_CONFIRM:
            return(!openid_server_is_blacklisted($server) || openid_server_is_whitelisted($server) || openid_server_is_greylisted($server));
        case OPENID_NONWHITELISTED_DENY:
            return(openid_server_is_whitelisted($server) || openid_server_is_greylisted($server));
        default:
            error_log("/auth/openid/lib.php::openid_server_allowed() - illegal setting for config->openid_non_whitelisted_status ({$config->openid_non_whitelisted_status})");
    }
    return false;
}

/**
 * Check if user confirmation is required for the OpenID server
 *
 * @param string $server
 * @param optional object $config - the OpenID auth plugin config settings
 * @return boolean
 */
function openid_server_requires_confirm($server, $config = null)
{
    if ($config == null) {
        $config = get_config('auth/openid');
    }
    switch ($config->openid_non_whitelisted_status) {
        case OPENID_NONWHITELISTED_ALLOW:
        case OPENID_NONWHITELISTED_DENY:
            return openid_server_is_greylisted($server);
        case OPENID_NONWHITELISTED_CONFIRM:
            return !openid_server_is_whitelisted($server);
        default:
            error_log("/auth/openid/lib.php::openid_server_requires_confirm() - invalid setting for config->openid_non_whitelisted_status ({$config->openid_non_whitelisted_status})");
    }
    return true;
}

/**
 * Attempt to parse first and last name components from a full name
 *
 * OpenID provides a fullname as part of the simple registration extension;
 * Moodle requires a separate first and last name.  This is an attempt at
 * parsing the second items from the first.  We're not guaranteeing success
 * here but merely splitting the fullname at the first space to try and make
 * registration a little easier.
 *
 * The returned associative array contains the following keys:
 * - first
 * - last
 *
 * @param string $fullname The full name as returned in the OpenID response
 * @return array An associative array of the name components
 */
function openid_parse_full_name($fullname) {
    $name = array('first'=>'','last'=>'');
    
    if (empty($fullname)) {
        return $name;
    }
    
    // If fullname doesn't contain at least 1 space, let's take a lucky
    // guess that it's a firstname.
    if (strpos($fullname, ' ') === false) {
        $name['first'] = $fullname;
    } else {
        $parts = explode(' ', $fullname, 2);
        $name['first'] = $parts[0];
        $name['last'] = $parts[1];
    }
    
    return $name;
}

/**
 * Get a friendlier version of a message if available
 *
 * This is used to replace a hard-coded Janrain messages with our own, if
 * it's been defined in a language file.  To replace a particular message,
 * the message should be converted to lower case; have spaces replaced with
 * underscores and remove anything except alphanumeric chars and
 * underscores.  Finally, 'auth_openid_' should be prepended.  This is then
 * the name of the languages string.
 *
 * For example:
 * Nonce missing from store
 *
 * becomes:
 * $string['auth_openid_nonce_missing_from_store']='My message';
 *
 * To ensure your changes aren't overwritten in a future update, you should
 * define all custom error strings in a local language file as described in
 * the Moodle documentation
 *
 * If the string isn't defined, the original message is returned intact.
 *
 * @param string $message The original message
 * @return string The resulting message
 */
function openid_get_friendly_message($message) {
    $msgdef = strtolower($message);
    $msgdef = ereg_replace(' ', '_', $msgdef);
    $msgdef = ereg_replace('[^0-9a-z_]', '', $msgdef);
    $msgdef = 'auth_openid_'.$msgdef;
    $msg = get_string($msgdef, 'auth_openid');
    
    if ($msg != '[['.$msgdef.']]') {
        return $msg;
    } else {
        return $message;
    }
}

/**
 * Send email to specified user with confirmation text and activation link.
 *
 * This function is largely a copy of the Moodle send_confirmation_email()
 * function with changes to suit the openid auth plugin.
 *
 * @uses $CFG
 * @param user $user A {@link $USER} object
 * @return bool|string Returns "true" if mail was sent OK, "emailstop" if email
 * was blocked by user and "false" if there was another sort of error.
 */
function openid_send_confirmation_email($user) {
    global $CFG;

    $site = get_site();
    $from = get_admin();

    $data = new object();
    $data->firstname = fullname($user);
    $data->sitename = format_string($site->fullname);
    $data->admin = fullname($from) .' ('. $from->email .')';

    $subject = get_string('emailconfirmationsubject', '', format_string($site->fullname));

    $data->link = $CFG->wwwroot .'/auth/openid/confirm.php?data='. urlencode($user->secret .'|'. $user->username);
    $message     = get_string('emailconfirmation', '', $data);
    $messagehtml = text_to_html(get_string('emailconfirmation', '', $data), false, false, true);

    $user->mailformat = 1;  // Always send HTML version as well
    error_log("/auth/openid/lib.php::openid_send_confirmation_email() to user: {$data->firstname}");

    return email_to_user($user, $from, $subject, $message, $messagehtml);
}

/**
 * Send email to specified user with fallback text and link.
 *
 * This function is largely a copy of the Moodle send_confirmation_email()
 * function with changes to suit the openid auth plugin.
 *
 * @uses $CFG
 * @param user $user A {@link $USER} object
 * @return bool|string Returns "true" if mail was sent OK, "emailstop" if email
 * was blocked by user and "false" if there was another sort of error.
 */
function openid_send_fallback_email($user, $openid_url) {
    global $CFG;

    $site = get_site();
    $from = get_admin();

    $data = new object();
    $data->firstname = fullname($user);
    $data->sitename = format_string($site->fullname);
    $data->admin = fullname($from) .' ('. $from->email .')';
    $data->openid_url = $openid_url;

    $subject = get_string('emailfallbacksubject', 'auth_openid',
                          format_string($site->fullname));

    $data->link = $CFG->wwwroot .'/auth/openid/fallback.php?data='. urlencode($user->secret .'|'. $user->username);
    $message     = get_string('emailfallback', 'auth_openid', $data);
    $messagehtml = text_to_html(get_string('emailfallback', 'auth_openid',
                                $data), false, false, true);

    $user->mailformat = 1;  // Always send HTML version as well

    return email_to_user($user, $from, $subject, $message, $messagehtml);
}

/**
 * Checks if an OpenID URL is in the database as either a primary username in
 * the user table or as a url in the openid_urls table
 *
 * @param string $openid_url
 * @return boolean
 */
function openid_already_exists($openid_url) {
    return record_exists('openid_urls', 'url', $openid_url);
}

/**
 * Changes a non-OpenID user's account to OpenID
 *
 * @param object $user
 * @param string $openid_url
 * @uses $CFG
 * @uses $USER
 * @return boolean
 */
function openid_change_user_account(&$user, $openid_url, $logout = false) {
    global $CFG, $USER;
    // We don't want to allow admin or guest users to be changed
    if (isguestuser($user) || is_siteadmin($user->id)) {
        logout_tmpuser_error(get_string('auth_openid_cannot_change_user', 'auth_openid'), $logout);
    }

    $config = get_config('auth/openid');
    $allow_change = ($config->auth_openid_allow_account_change=='true');
    $user = get_complete_user_data('id', $user->id);
    
    if (empty($user)) {
        logout_tmpuser_error(get_string('auth_openid_not_logged_in', 'auth_openid'), $logout);
        return false;
    }
    
    if (!$allow_change) {
        logout_tmpuser_error(get_string('auth_openid_cannot_change_accounts', 'auth_openid'), $logout);
        return false;
    }
    
    if (openid_already_exists($openid_url)) {
        logout_tmpuser_error(get_string('auth_openid_url_exists', 'auth_openid', $openid_url), $logout);
        return false;
    }
    
    if ($user->auth != 'openid') {
        $user->auth = 'openid';

        // avoid nasty bug from apostrophy in user's first/last/user-name fields
        $user->firstname = addslashes(stripslashes($user->firstname));
        $user->lastname = addslashes(stripslashes($user->lastname));
        $user->username = addslashes(stripslashes($user->username));
        if (update_record('user', $user) !== false) {
            openid_append_url($user, $openid_url);
            $USER = get_complete_user_data('id', $user->id);
            if ($config->auth_openid_email_on_change == 'true') {
                // send user email with OpenID URL
                $adminuser            = get_admin();
                $strdata              = new stdClass;
                $strdata->user_name   = fullname($USER);
                $strdata->moodle_site = $CFG->wwwroot;
                $strdata->openid_url  = $openid_url;
                $strdata->admin_name  = fullname($adminuser);
                $message              = get_string('openid_email_text',
                                                   'auth_openid',
                                                   $strdata);
                $messagehtml          = text_to_html($message, false, false);
                email_to_user($USER, $adminuser,
                              get_string('openid_email_subject','auth_openid'),
                              $message, $messagehtml);
            }
            return true;
        }
    }

    return false;
}

/**
 * Appends an OpenID url to a user's account
 *
 * @param object $user
 * @param string $openid_url
 * @return boolean
 */
function openid_append_url($user, $openid_url) {
    $config = get_config('auth/openid');
    $allow_append = ($config->auth_openid_allow_muliple=='true');
    $user = get_complete_user_data('id', $user->id);
    
    if (empty($user)) {
        logout_tmpuser_error(get_string('auth_openid_not_logged_in', 'auth_openid'));
        return false;
    }
    
    if (count_records('openid_urls', 'userid', $user->id)>0 && !$allow_append) {
        logout_tmpuser_error(get_string('auth_openid_no_multiple', 'auth_openid'));
        return false;
    }
    
    if (openid_already_exists($openid_url)) {
        logout_tmpuser_error(get_string('auth_openid_url_exists', 'auth_openid', $openid_url));
        return false;
    }
    
    if ($user->auth == 'openid') {
        $record = new object();
        $record->userid = $user->id;
        $record->url = $openid_url;
        
        if (insert_record('openid_urls', $record) !== false) {
            return true;
        }
    }
    
    return false;
}

?>
