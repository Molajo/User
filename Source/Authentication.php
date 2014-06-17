<?php
/**
 * Authentication Class
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User;

use CommonApi\User\AuthenticationInterface;
use Molajo\User\Authentication\Verify;
use stdClass;

/**
 * Authentication Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Authentication extends Verify implements AuthenticationInterface
{
    /**
     * Guest - verify the Session
     *
     * @param   string   $session_id
     *
     * @return  int
     * @since   1.0
     */
    public function isGuest($session_id)
    {
        $this->verifySession($session_id, 'isGuest');

        if ($this->session->getSession('last_activity_datetime') === false) {
            $this->setFormToken();
        }

        $this->verifyFormToken('isGuest');

        $this->session->setSession('last_activity_datetime', $this->today);

        return 0;
    }

    /**
     * Login - verify username and password, handle remember request
     *
     * @param   string   $session_id
     * @param   string   $username
     * @param   string   $password
     * @param   boolean  $remember
     *
     * @return  int
     * @since   1.0
     */
    public function login($session_id, $username, $password, $remember = false)
    {
        $this->error = false;

        $this->verifySession($session_id, 'login');
        $this->verifyUser('login');
        $this->verifyFormToken('login');
        $this->verifyCredentials($username, $password);

        if ($this->error === true) {
            $redirect       = new stdClass();
            $redirect->code = 401;
            $redirect->url  = $this->configuration->url_to_login;

            return $redirect;
        }

        $this->setSessionLogin();
        $this->setFormToken();

        if (isset($options['remember'])) {
            $this->remember = $options['remember'];
        }

        if ((int)$this->remember == 1) {
        }

        $this->clearLoginAttempts();
        $this->clearResetPasswordCode();
        $this->updates['#__users.last_visit_datetime']    = $this->today;
        $this->updates['#__users.last_activity_datetime'] = $this->today;

        $this->updateUser();

        return $this->user->id;
    }

    /**
     * Verify if the User is Logged On
     *
     * @param   string $session_id
     * @param   string $username
     *
     * @return  int
     * @since   1.0
     */
    public function isLoggedOn($session_id, $username)
    {
        $this->verifySession($session_id, 'isLoggedOn');
        $this->verifyUser('isLoggedOn');
        $this->verifySessionNotTimedOut();
        $this->verifyFormToken('isLoggedOn');

        if ($this->error === true) {
            $redirect       = new stdClass();
            $redirect->code = 401;
            $redirect->url  = $this->configuration->url_to_login;
            return $redirect;
        }

        $this->updates['#__users.last_activity_datetime'] = $this->today;
        $this->user                                       = $this->updateUser();

        return $this->user->id;
    }

    /**
     * Change the password for a user
     *
     * @param   string $session_id
     * @param   string $username
     * @param   string $password
     * @param   string $new_password
     * @param   string $reset_password_code
     * @param   bool   $remember
     *
     * @return  $this
     * @since   1.0
     */
    public function changePassword(
        $session_id = '',
        $username,
        $password = '',
        $new_password = '',
        $reset_password_code = '',
        $remember = false
    ) {
        $this->verifySession($session_id, 'login');
        $this->verifyUser('login');
        $this->verifyFormToken('login');
        $this->verifyPasswordChange($new_password);
        $this->verifyCredentials($username, $password, $reset_password_code);

        if ($this->error === true) {
            $redirect       = new stdClass();
            $redirect->code = 401;
            $redirect->url  = $this->configuration->url_to_login;
            return $redirect;
        }

        //$hash                                       = $this->encrypt->createHashString($new_password);
        $this->updates['#__users.password']                  = $new_password; //$hash;
        $this->updates['#__users.password_changed_datetime'] = $this->today;
        $this->updates['#__users.last_visit_datetime']       = $this->today;
        $this->updates['#__users.last_activity_datetime']    = $this->today;

        $this->clearLoginAttempts();
        $this->clearResetPasswordCode();

        $this->user = $this->updateUser();

        if ((int)$this->remember == true) {
            //$this->saveRememberMeCookie();
        }

        return $this->user;
    }

    /**
     * Generate a token and email a temporary link to change password and sends to user
     *
     * @param   string $session_id
     * @param   string $username
     *
     * @return  $this|void
     * @since   1.0
     */
    public function requestPasswordReset($session_id, $username)
    {
        $this->verifySession($session_id, 'requestPasswordReset');
        $this->verifyUser('requestPasswordReset');
        $this->verifyFormToken('requestPasswordReset');

        if ($this->error === true) {
            $redirect       = new stdClass();
            $redirect->code = 401;
            $redirect->url  = $this->configuration->url_to_login;
            return $redirect;
        }

        if ($this->user->reset_password_code == '') {
            $this->setResetPasswordCode();
        }
        $this->updates['#__users.last_activity_datetime'] = $this->today;
        $this->user                                       = $this->updateUser();

        $options          = array();
        $options['type']  = 'password_reset_request';
        $options['link']  = $this->configuration->url_to_change_password
            . '?reset_password_code=' . $this->user->reset_password_code;
        $options['name']  = $this->user->full_name;
        $options['today'] = $this->today;
        $options['to']    = $this->user->email
            . ', ' . $$this->user->full_name;

        $this->mailer->render($options)->send();

        return 0;
    }

    /**
     * Log out and Redirect
     *
     * @param   string $session_id
     * @param   string $username
     *
     * @return  null|void
     * @since   1.0
     */
    public function logout($session_id, $username)
    {
        $this->verifySession($session_id, 'logout');
        $this->verifyUser('logout');
        $this->verifySessionNotTimedOut();
        $this->verifyFormToken('logout');

        if ($this->error === true) {
            $redirect       = new stdClass();
            $redirect->code = 401;
            $redirect->url  = $this->configuration->url_to_login;
            return $redirect;
        }

        $this->updates['#__users.last_activity_datetime'] = $this->today;
        $this->user                                       = $this->updateUser();
        $this->session->destroySession();
        //$this->cookie->forget();

        $redirect       = new stdClass();
        $redirect->code = 401;
        $redirect->url  = $this->configuration->url_for_home;

        return $redirect;
    }
}
