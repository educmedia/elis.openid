<?php

/**
 * OpenID Change password form for 'Manage your OpenIDs'
 *
 * @author Brent Boghosian <brent.boghosian@remote-learner.net>
 * @copyright Copyright (c) 2011 Remote-Learner
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package openid
 **/

require_once(dirname(__FILE__) ."/../../config.php");

global $USER;

$title = get_string('openid_manage', 'auth_openid');

// Build navigation
$navlinks = array();
$navlinks[] = array('name' => fullname($USER),
                    'link' => "{$CFG->wwwroot}/user/view.php",
                    'type' => 'misc');
$navlinks[] = array('name' => $title, 'link' => null, 'type' => 'misc');
$navigation = build_navigation($navlinks);
print_header($title, $title, $navigation, '', '', true, '');

// We don't want to allow use of this script if OpenID auth isn't enabled
if (!is_enabled_auth('openid')) {
    print_error('auth_openid_not_enabled', 'auth_openid');
}

if (!$site = get_site()) {
    print_error('auth_openid_no_site', 'auth_openid');
}
$config = get_config('auth/openid');
include 'user_profile.html';
print_footer();

?>
