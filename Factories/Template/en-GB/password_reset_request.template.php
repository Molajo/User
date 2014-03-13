<?php
/**
 * Password Reset Request Template
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
$template = new stdClass();

$template->name    = 'password_reset_request';
$template->subject = 'Password Reset Request';
$template->body    = 'On {today}, {name} requested a password reset. The link expires when the password is '
    . 'changed or the next time the account is logged in. Please click {link} to change the password now.';
