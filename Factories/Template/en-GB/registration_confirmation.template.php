<?php
/**
 * Registration Confirmation Template
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
$template = new stdClass();

$template->name    = 'registration_confirmation';
$template->subject = 'Registration Confirmation';
$template->body    = 'On {today}, {name} requested membership at this site. '
    . 'To confirm your membership, please use this {link} link.';
