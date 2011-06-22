<?php

/**
 * OpenID language file for Moodle
 *
 * This file contains the strings used by the OpenID authentication plugin. 
 *
 * @author Stuart Metcalfe <info@pdl.uk.com>
 * @copyright Copyright (c) 2007 Canonical
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package openid
 */

// Plugin title & description strings (from: /lang/en_utf8/auth.php)
$string['auth_openidtitle'] = 'OpenID';
$string['auth_openiddescription'] = 'OpenID is an open, decentralized, free framework for user-centric digital identity. To find out more, visit <a href=\'http://openid.net/\'>OpenID.net</a>.';

// Module strings
$string['modulename'] = 'OpenID';
$string['whats_this'] = 'What\'s this?';
$string['provider_offline'] = 'Help, my provider is offline!';

// Block strings
$string['block_title'] = 'OpenID';
$string['append_text'] = 'You can add another OpenID to your account by entering another OpenID here';
$string['change_text'] = 'You can change your account to OpenID by entering your OpenID here';

// Google Apps login strings
$string['google_apps_button'] = 'Login with your GoogleApps account';
$string['gapps_append_text'] = 'You can add another OpenID to your account by authenticating with another GoogleApps account';
$string['gapps_change_text'] = 'You can change your account to OpenID by logging-in using your GoogleApps account';
$string['gapps_offline'] = 'Help, my GoogleApps domain is offline!';
$string['openid_gapps_enabled'] = 'We are OpenID enabled with GoogleApps';
$string['openid_gapps_text'] = 'You can login using your GoogleApps account:';

// Login strings
$string['openid_email_subject'] = 'Moodle: OpenID authentication';
$string['openid_email_text'] = '{$a->user_name},\n\nCongratulations, your Moodle account at {$a->moodle_site}\nis now OpenID.\n\nPlease save your unique OpenID URL: {$a->openid_url}\n\nYou may require it if your OpenID Provider is ever offline.\n\n--\n{$a->admin_name}';
$string['openid_enabled'] = 'We are OpenID Enabled';
$string['openid_enabled_google'] = 'Login with your Google OpenID account';
$string['openid_default_text'] = 'You can login or signup here with your Google Email or OpenID url.';
$string['openid_text'] = 'You can login or signup here with your Google Email or OpenID url.';
$string['openid_note'] = 'Already got an account here and want to sign in with your new OpenID?  Just enter your OpenID once you\'ve logged in as normal and we\'ll link your account to your OpenID';
$string['openid_note_user'] = 'To create a separate account with your OpenID, you must <a href=\'{$a->href}\'>{$a->logout}</a> first.';
$string['openid_redirecting'] = 'You are about to be redirected to your OpenID provider.  If you are not redirected automatically, please click the continue button below.';

// Fallback strings
$string['fallback_text'] = 'When you enter a registered OpenID here, we will send a one-time link to the email address associated with that OpenID to allow you to log in without having to authenticate with your OpenID provider.  This may be useful if your OpenID provider is offline for some reason, or if you unregistered with your provider and forgot to update your account.';
$string['fallback_message_sent'] = 'An email was sent to the address registered to that OpenID with a link to a one-time login page.';
$string['emailfallbacksubject'] = '$a: One-time login';
$string['emailfallback'] = 'Hi $a->firstname,

A one-time login has been requested at \'$a->sitename\'
for your OpenID ($a->openid_url).

To login without needing to access your OpenID provider,
please go to this web address:

$a->link

In most mail programs, this should appear as a blue link
which you can just click on.  If that doesn\'t work,
then cut and paste the address into the address
line at the top of your web browser window.

This link will only work once and is time-limited to 30
minutes from the time it was requested.

If you need help, please contact the site administrator,
$a->admin';

// Action strings
$string['confirm_sure'] = 'Are you sure you want to do this?';
$string['confirm_append'] = 'You are about to add the identity, $a to your account.  '.$string['confirm_sure'];
$string['confirm_change'] = 'You are about to change your account to OpenID using the identity $a.  This will change your login details and prevent you from logging in using your current method.  '.$string['confirm_sure'];
$string['confirm_delete'] = 'You are about to delete the following identities from your account:';
$string['action_cancelled'] = 'Action cancelled.  No changes have been made to your account.';
$string['cannot_delete_all'] = 'Sorry, but you cannot delete all of your OpenIDs.';

// Profile strings
$string['openid_manage'] = 'Manage your OpenIDs';
$string['add_openid'] = 'Add OpenID to your account';
$string['openid_main'] = '(Main OpenID)';
$string['delete_selected'] = 'Delete selected';

// Error strings
$string['auth_openid_already_loggedin'] = 'User already logged in!';
$string['auth_openid_bad_session_key'] = 'Bad Session Key!';
$string['auth_openid_cannot_change_accounts'] = 'Cannot change accounts!';
$string['auth_openid_cannot_change_user'] = 'Cannot change that user!';
$string['auth_openid_cannot_use_page'] = '"Sorry, you may not use this page.';
$string['auth_openid_database_error'] = 'Something serious is wrong with the database!';
$string['auth_openid_email_mismatch'] = 'User Email mismatch with OpenID Email: ';
$string['auth_openid_invalid_action'] = 'Unrecognized action!';
$string['auth_openid_invalid_data'] = 'Invalid confirmation data!';
$string['auth_openid_multiple_disabled'] = 'Sorry but you can no longer log in with multiple OpenIDs on this site.  Please contact the site owner.';
$string['auth_openid_no_site'] = 'No Site found!';
$string['auth_openid_not_enabled'] = 'OpenID not enabled!';
$string['auth_openid_not_logged_in'] = 'Not logged in!';
$string['auth_openid_server_blacklisted'] = 'Sorry, we do not accept registrations from your OpenID server, $a';
$string['auth_openid_url_exists'] = 'Sorry but the OpenID, $a, is already registered here';
$string['auth_openid_user_cancelled'] = 'Authentication cancelled by user';
$string['auth_openid_login_failed'] = 'Authentication failed. Server reported: $a';
$string['auth_openid_login_error'] = 'An error occurred while authenticating with your OpenID provider. Please check your OpenID URL and try again.';
$string['auth_openid_filestore_not_writeable'] = 'I couldn\'t write to the file store directory. Please ensure the directories in moodle/auth/openid/store/ are writable and try again';
$string['auth_openid_multiple_matches'] = 'Cannot Authenticate. OpenID response matches multiple existing users.';
$string['auth_openid_no_multiple'] = 'Cannot Authenticate. User already authenticating with another OpenID Provider.';
$string['auth_openid_require_account'] = 'Cannot Authenticate. This site is configured to disallow new users via OpenID.';
$string['auth_openid_store_no_write'] = 'OpenID store not writable! Please refer to documentation.';
$string['fail_match_secret'] = 'Failed to match secret!';
$string['invalid_url'] = 'The specified OpenID URL \'{$a}\' is invalid.';
$string['no_urls_selected'] = 'No OpenID URLs were selected for deletion!';
$string['user_not_found'] = 'Sorry, I couldn\'t find that user.';

// Tabs
$string['openid_tab_users'] = 'Users';
$string['openid_tab_sreg'] = 'Simple Registration Extension';
$string['openid_tab_servers'] = 'Servers';

// Config strings
$string['allow'] = 'Allowed';
$string['confirm'] = 'Confirmed';
$string['deny'] = 'Denied';
$string['auth_openid_confirm_switch'] = 'Require users to confirm when switching authentication to OpenID.';
$string['auth_openid_create_account'] = 'Allow new MOODLE accounts creation for new OpenID authenticating users.';
$string['auth_openid_custom_login'] = 'Custom OpenID login file or SSO URL:';
$string['auth_openid_custom_login_config'] = 'You may replace the default OpenID login fields with your own custom login(relative file path) or SSO URL. Leave blank for the default OpenID url form. To force default OpenID login use: <a href=\'$a\'>$a</a>';
$string['auth_openid_email_on_change'] = 'Send email notice to users when switching authentication to OpenID.';
$string['auth_openid_google_apps_config'] = 'Enter the domain for your Google Apps accounts (leave blank for none)<br /><b>Note</b>: this setting overrides other settings!';
$string['auth_openid_google_apps_domain'] = 'Google Apps domain:';
$string['auth_openid_limit_login'] = 'Limit login page to OpenID authentication only!<br/><small><b>Note</b>: To login with non-OpenID authentication use: <A HREF=\'$a\'>$a</A></small>';
$string['auth_openid_match_fields'] = 'Match OpenID attributes:';
$string['auth_openid_match_fields_config'] = 'Match existing Moodle User fields with OpenID attributes for automatic changing or appending of OpenID logins. Allowed comma separated values are: <i>email, fullname, username, username_email</i>. Matched in order specified.<br/>Leave blank for no automatic conversions to OpenID.';
$string['auth_openid_sso_settings'] = 'OpenID Single Sign-On (SSO) settings';
$string['auth_openid_sso_description'] = 'This authentication plugin, once configured, functions as the sole authentication system on your site.  This may be useful if you are planning on using OpenID as an internal identity provider.<br /><br /><strong>Important: Before entering a server URL, please ensure you have at least one user registered against it with administrative permissions (Users-&gt;Permissions-&gt;Assign global roles-&gt;Administrator). If you need to log back in with a normal username and password once this plugin is enabled, you can override it by adding the query parameter \'admin\' to your login URL (eg: http://yoursite/moodle/login/index.php?admin=true).</strong>';
$string['auth_openid_sso_op_url_key'] = 'Server URL';
$string['auth_openid_sso_op_url'] = 'This is the URL of the OpenID server you want to use as your SSO provider.';
$string['auth_openid_sreg_settings'] = 'Simple Registration Extension (SREG) settings';
$string['auth_openid_sreg_description'] = 'OpenID Simple Registation is an extension to the OpenID Authentication protocol that allows for very light-weight profile exchange. It is designed to pass eight commonly requested pieces of information when an End User goes to register a new account with a web service.<br /><br />Fields <a href=\'http://openid.net/specs/openid-simple-registration-extension-1_0.html\'>defined by the specification</a> are: nickname, email, fullname, dob, gender, postcode, country, language and timezone. This plugin currently processes: nickname, email, fullname and country';
$string['auth_openid_sreg_required_key'] = 'Required fields';
$string['auth_openid_sreg_required'] = 'Comma separated list of fields.  By adding fields to this list you are indicating that the user will not be able to complete registration without them and the OpenID provider may be able to speed the registration process by returning them.  <em>Required fields are not guaranteed to be returned by an OpenID provider.</em>';
$string['auth_openid_sreg_optional_key'] = 'Optional fields';
$string['auth_openid_sreg_optional'] = 'Comma separated list of fields.  By adding fields to this list you are indicating that the user will be able to register without them but they will be used if the OpenID provider sends them.';
$string['auth_openid_privacy_url_key'] = 'Privacy policy';
$string['auth_openid_privacy_url'] = 'If you publish a privacy policy online, enter the full URL here so OpenID users can read it.  <em>Only used if SREG fields are specified</em>';
$string['auth_openid_user_settings'] = 'OpenID User settings';
$string['auth_openid_user_description'] = 'Settings to allow or prevent users from carrying out certain actions';
$string['auth_openid_allow_account_change_key'] = 'Allow users to change their account type to OpenID by authenticating with an OpenID provider?';
$string['auth_openid_allow_muliple_key'] = 'Allow users to register more than one identity for each account?';
$string['auth_openid_servers_settings'] = 'OpenID Server settings';
$string['auth_openid_servers_description'] = 'Manage your list of OpenID servers which are automatically allowed or blocked. You can use wilcards such as *.myopenid.com.<br />';

$string['openid_non_whitelisted_status'] = 'Non-whitelisted servers shall be: ';
$string['openid_non_whitelisted_info'] = '<small><strong>Note:</strong> <em>Confirmed</em> registration is only used where an application would otherwise be completed automatically without human intervention (eg: where OpenID Registration Data covers the minimum registration requirements).</small>';
$string['openid_require_greylist_confirm_key'] = 'Require users of non-whitelisted servers to confirm their registration? <small>This is only used where an application would otherwise be completed automatically without human intervention (eg: where Simple Registration Data covers the minimum registration requirements)</small>';
?>
