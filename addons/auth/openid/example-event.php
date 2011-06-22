<?php

/**
 * Example event script for Moodle OpenID auth plugin
 *
 * As part of this implementation, there is a simple system which can respond to
 * events.  The only events we are currently using are:
 *
 * - on_openid_login
 * - on_openid_create_account
 *
 * In order to receive notification of these events, you should rename this file
 * (or create a new one) to event.php.
 *
 * @author Stuart Metcalfe <info@pdl.uk.com>
 * @copyright Copyright (c) 2007 Canonical
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package openid
 */

/**
 * Login event handler
 *
 * Called whenever a successful openid login occurs. You should not redirect the
 * user or send output to the browser in this function as the user's session has
 * not yet been updated and output has not started.  This function is intended
 * for additional administration processes for openid such as updating a user's
 * email address.
 *
 * @param object &$resp The response Object as defined by the OpenID library
 * @param object &$user The user who has just logged in
 * @param boolean $mainid Is this the user's main id? Default true
 */
function on_openid_login(&$resp, &$user, $mainid=true) {}

/**
 * Create account handler
 *
 * Called whenever a successful openid request is received but the user isn't
 * yet registered on the site.  By the time this handler is called, any simple
 * registration (sreg) extension data will have been processed.  The user will
 * be saved to the database when this function returns.
 *
 * This function is intended for additional administration processes for openid
 * users and might be useful if, for example, you are using OpenID as an
 * internal identity provider and want to exchange information which is outside
 * the scope of the sreg specification (eg: avatar images, etc).
 *
 * @param object &$resp The response Object as defined by the OpenID library
 * @param object &$user The user who was just created
 */
function on_openid_create_account(&$resp, &$user) {}

/**
 * Do request handler
 *
 * Called before the user is redirected to their OpenID provider.
 *
 * This function is intended for additional manipulation of the authorisation
 * request.  For example: to add additional openid extensions.  For a proper
 * OpenID 2.0 implementation, a new OpenID extension with a different namespace
 * should be created by extending the Auth_OpenID_Extension class.
 *
 * @param object $authreq The request object as defined by the OpenID library
 */

function on_openid_do_request(&$authreq) {}

?>
