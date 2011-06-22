<?php

/**
 * OpenID account confirm
 *
 * This file handles account confirmation for the openid auth plugin and is
 * largely copied from moodle/login/confirm.php but using openid as the auth
 * plugin and the bar '|' character instead of fwdslash '/' to split the data.
 *
 * @author Stuart Metcalfe <info@pdl.uk.com>
 * @copyright Copyright (c) 2007 Canonical
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package openid
 **/

    require_once("../../config.php");

    $data = optional_param('data', '', PARAM_CLEAN);  // Formatted as:  secret/username

    $p = optional_param('p', '', PARAM_ALPHANUM);     // Old parameter:  secret
    $s = optional_param('s', '', PARAM_CLEAN);        // Old parameter:  username

    $authplugin = get_auth_plugin('openid');

    if (!$authplugin->can_confirm()) {
        print_error('auth_openid_cannot_use_page', 'auth_openid');
    }

    if (!empty($data) || (!empty($p) && !empty($s))) {

        if (!empty($data)) {
            $dataelements = explode('|',$data);
            $usersecret = $dataelements[0];
            $username   = $dataelements[1];
        } else {
            $usersecret = $p;
            $username   = $s;
        }

        $confirmed = $authplugin->user_confirm($username, $usersecret);

        if ($confirmed == AUTH_CONFIRM_ALREADY) {
            $user = get_complete_user_data('username', $username);
            print_header(get_string("alreadyconfirmed"), get_string("alreadyconfirmed"), "", "");
            print_box_start('generalbox centerpara boxwidthnormal boxaligncenter');
            echo "<h3>".get_string("thanks").", ". fullname($user) . "</h3>\n";
            echo "<p>".get_string("alreadyconfirmed")."</p>\n";
            print_single_button("$CFG->wwwroot/course/", null, get_string('courses'));
            print_box_end();
            print_footer();
            exit;

        } else if ($confirmed == AUTH_CONFIRM_OK) {
            // The user has confirmed successfully, let's log them in

            if (!$USER = get_complete_user_data('username', $username)) {
                print_error('auth_openid_database_error', 'auth_openid');
            }

            set_moodle_cookie($USER->username);

            if ( ! empty($SESSION->wantsurl) ) {   // Send them where they were going
                $goto = $SESSION->wantsurl;
                unset($SESSION->wantsurl);
                redirect($goto);
            }

            print_header(get_string("confirmed"), get_string("confirmed"), "", "");
            print_box_start('generalbox centerpara boxwidthnormal boxaligncenter');
            echo "<h3>".get_string("thanks").", ". fullname($USER) . "</h3>\n";
            echo "<p>".get_string("confirmed")."</p>\n";
            print_single_button("$CFG->wwwroot/course/", null, get_string('courses'));
            print_box_end();
            print_footer();
            exit;
        } else {
            print_error('auth_openid_invalid_data', 'auth_openid');
        }
    } else {
        print_error('errorwhenconfirming');
    }

    redirect("$CFG->wwwroot/");

?>
