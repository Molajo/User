<?php
/**
 * Authentication Verify
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use DateTime;
use Exception;
use CommonApi\User\AuthenticationInterface;

/**
 * Authentication Verify
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Verify extends Set implements AuthenticationInterface
{
    /**
     * Verifies the session given the action
     *
     * @param   string $session_id
     * @param   string $action
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifySession($session_id, $action)
    {
        if ($session_id == '') {
            $this->messages->throwException(300);
        }

        if ($action == 'isGuest') {

            if ($this->external_session_id == $session_id
                && $this->user->username == ''
            ) {
                $this->session_id = $session_id;
                return $this;
            }

            $this->messages->throwException(1800, array(), $this->default_exception);

        } elseif ($action == 'login' || $action == 'changePassword' || $action == 'requestPasswordReset') {

            if ($this->external_session_id == $session_id) {
                $this->session_id = $session_id;
                return $this;
            }

            $values           = array();
            $values['action'] = $action;
            $this->messages->throwException(1805, $values, $this->default_exception);

        } else {

            if ($this->external_session_id
                == $session_id
                && $this->session->getSession($session_id)
                == $this->user->username
                && $this->session->getSession($this->user->username)
                == $this->user->session_id
            ) {
                $this->session_id = $session_id;
                return $this;
            };
        }

        $this->messages->throwException(1900, array(), $this->default_exception);

        return $this;
    }

    /**
     * Is the user permitted to logon?
     *
     * @param   string $action
     *
     * @return  boolean
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function verifyUser($action)
    {
        $today_datetime = new DateTime();

        if ($this->user->activation_datetime == '0000-00-00 00:00:00') {
            $this->error = true;
            $this->messages->setFlashmessage(600);
        }

        if ($action == 'login' || $action == 'changePassword' || 'requestPasswordReset') {

            if ($this->user->login_attempts > $this->configuration->max_login_attempts) {

                $last_activity_date = new DateTime($this->user->last_activity_datetime);
                $day_object         = $last_activity_date->diff($today_datetime);

                if ($day_object->days > $this->configuration->password_lock_out_days) {

                    $this->updates['#__users.login_attempts']         = 0;
                    $this->updates['#__users.block']                  = 0;
                    $this->updates['#__users.last_activity_datetime'] = $this->today;

                    $this->user = $this->updateUser();

                } else {
                    $this->error = true;
                    $this->messages->setFlashmessage(800);
                }
            }
        }

        if ($this->user->block == 1) {
            $this->error = true;
            $this->messages->setFlashmessage(1100);
        }

        $password_changed_datetime = new DateTime($this->user->password_changed_datetime);
        $day_object                = $password_changed_datetime->diff($today_datetime);

        if ($day_object->days > (int)$this->configuration->password_expiration_days
            && (int)$this->configuration->password_expiration_days > 0
        ) {

            $this->updates['#__users.block']                  = 1;
            $this->updates['#__users.last_activity_datetime'] = $this->today;

            $this->user = $this->updateUser();

            $this->error = true;
            $this->messages->setFlashmessage(1200);
        }

//todo: move this to route
        if ($this->configuration->site_is_offline == 1) {
            $this->error = true;
            $this->messages->setFlashmessage(450);
        }

        return true;
    }

    /**
     * Verifies the token for the user (guest or logged on)
     *
     * @param   string $action
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function verifyFormToken($action)
    {
        if ($action == 'isLoggedon' || $action == 'isGuest') {
        } else {
            /**
             * if (in_array($this->server['REQUEST_METHOD'], array('POST', 'PUT', 'DELETE'))) {
             * } else {
             * $values           = array();
             * $values['action'] = $action;
             * $this->messages->throwException(205, $values);
             * }
             */
        }

        if (in_array($this->server['REQUEST_METHOD'], array('POST', 'PUT', 'DELETE'))) {

            if (isset($this->post[$this->session->getSession('form_token')])) {
            } else {
                $this->session->destroySession();
                //$this->cookie->forget();
                $this->messages->throwException(2000);
            }
        }

        return $this;
    }

    /**
     * Used during login and other times username and password must be verified
     *
     * @param  string $username
     * @param  string $password
     * @param  string $reset_password_code
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function verifyCredentials(
        $username = '',
        $password = '',
        $reset_password_code = ''
    ) {
        if ($this->configuration->password_email_address_as_username == true) {
            if ($username == $this->user->email) {
            } else {
                $this->error = true;
                $this->messages->setFlashmessage(1310);
            }
        } else {
            if ($username == $this->user->username) {
            } else {
                $this->error = true;
                $this->messages->setFlashmessage(1300);
            }
        }

        if ($password == '' && $reset_password_code == '') {
            $this->error = true;
            $this->messages->setFlashmessage(1400);
        }

        if ($password == '') {
            if ($reset_password_code == $this->user->reset_password_code) {
            } else {
                $this->setFailedLoginAttempt();
                $this->error = true;
                $this->messages->setFlashmessage(1500);
            }
        } else {

            //$test = $this->encrypt->verifyHashString(
            //    $password,
            //    $this->user->password
            //);
            $test = true;
            if ($test === true) {
            } else {
                $this->setFailedLoginAttempt();

                $this->error = true;
                $this->messages->setFlashmessage(1600);
            }
        }

        return $this;
    }

    /**
     * Check to see if the Session has timed out
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifySessionNotTimedOut()
    {
        if ($this->external_session_id == $this->session_id
            && $this->session->getSession('last_activity_datetime')
            + ($this->configuration->session_expires_minutes * 60)
            < time()
        ) {
            $this->error = true;
            session_regenerate_id(true);
//todo $this->session->setSession('request', $this->request);
            $this->session->setSession('last_activity_datetime', time());
        } else {
            $this->session->setSession('last_activity_datetime', time());
        }

        return $this;
    }

    /**
     * Password requirements
     *
     * @param   string $new_password
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChange($new_password)
    {
        if ($new_password == '' || $new_password === null) {
            $this->error = true;
            $this->messages->setFlashmessage(2130);
        }

        if ($this->configuration->password_minimum_password_length == 0) {
            $this->configuration->password_minimum_password_length = 5;
        }
        if ($this->configuration->password_maximum_password_length
            < $this->configuration->password_minimum_password_length
        ) {
            $this->configuration->password_maximum_password_length = 10;
        }

        $options = array();

        try {
            $options['from'] = $this->configuration->password_minimum_password_length;
            $options['to']   = $this->configuration->password_maximum_password_length;

            $this->fieldhandler->validate('Password', $new_password, 'Stringlength', $options);
        } catch (Exception $e) {

            $values         = array();
            $values['from'] = $this->configuration->password_minimum_password_length;
            $values['to']   = $this->configuration->password_maximum_password_length;

            $this->error = true;
            $this->messages->setFlashmessage(2100, $values);
        }

        if ($this->configuration->password_must_not_match_username === true) {

            try {
                $options              = array();
                $options['not_equal'] = $this->user->username;

                $this->fieldhandler->validate('Password', $new_password, 'Notequal', $options);
            } catch (Exception $e) {

                $this->error = true;
                $this->messages->setFlashmessage(2200);
            }
        }

        if ($this->configuration->password_must_not_match_last_password === true) {

            $test = $this->encrypt->verifyHashString(
                $new_password,
                $this->user->password
            );

            if ($test == 1) {
                $this->error = true;
                $this->messages->setFlashmessage(2300);
            }
        }

        if ($this->configuration->password_alpha_character_required === true) {

            try {
                $options          = array();
                $options['regex'] = '/[A-Za-z]/';
                $this->fieldhandler->validate('Password', $new_password, 'Regex', $options);
            } catch (Exception $e) {

                $this->error = true;
                $this->messages->setFlashmessage(2400);
            }
        }

        if ($this->configuration->password_numeric_character_required === true) {

            try {
                $options          = array();
                $options['regex'] = '/[0-9]/';
                $this->fieldhandler->validate('Password', $new_password, 'Regex', $options);
            } catch (Exception $e) {

                $this->error = true;
                $this->messages->setFlashmessage(2500);
            }
        }

        if ($this->configuration->password_special_character_required === true) {

            try {
                $options          = array();
                $options['regex'] = '/[!*@#$%]/';
                $this->fieldhandler->validate('Password', $new_password, 'Regex', $options);
            } catch (Exception $e) {

                $this->error = true;
                $this->messages->setFlashmessage(2600);
            }
        }

        if ($this->configuration->password_mixed_case_required === true) {

            try {
                $options          = array();
                $options['regex'] = '`[A-Z]`';
                $this->fieldhandler->validate('Password', $new_password, 'Regex', $options);
            } catch (Exception $e) {

                $this->error = true;
                $this->messages->setFlashmessage(2700);
            }

            try {
                $options          = array();
                $options['regex'] = '`[a-z]`';
                $this->fieldhandler->validate('Password', $new_password, 'Regex', $options);
            } catch (Exception $e) {

                $this->error = true;
                $this->messages->setFlashmessage(2800);
            }
        }

        return $this;
    }
}
