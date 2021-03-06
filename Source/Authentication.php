<?php
/**
 * Authentication Class
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User;

use CommonApi\User\AuthenticationInterface;
use Molajo\User\Authentication\VerifyCredentials;
use stdClass;

/**
 * Authentication Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Authentication extends VerifyCredentials implements AuthenticationInterface
{
    /**
     * Guest - verify the Session
     *
     * @param   string $session_id
     *
     * @return  integer
     * @since   1.0.0
     */
    public function isGuest($session_id)
    {
        $this->verifySession($session_id, 'isGuest');

        if ($this->getSessionValue('last_activity_datetime') === false) {
            $this->setSessionFormToken();
        }

        $this->verifySessionFormToken();

        $this->setSessionValue('last_activity_datetime', $this->today);

        return 0;
    }

    /**
     * Login - verify username and password, handle remember request
     *
     * @param   string  $session_id
     * @param   string  $username
     * @param   string  $password
     * @param   boolean $remember
     *
     * @return  int
     * @since   1.0.0
     */
    public function login($session_id, $username, $password, $remember = false)
    {
        $this->error = false;

        $this->verifySession($session_id, 'login');
        $this->verifyUser('login');

        $this->verifySessionFormToken();
        $this->verifyUsernamePassword($username, $password);

        if ($this->error === true) {
            return $this->redirect401();
        }

        $this->setSessionLogin();
        $this->setSessionFormToken();

        if (isset($options['remember'])) {
            $this->remember = $options['remember'];
        }

        if ((int)$this->remember === 1) {
        }

        $this->updateUserClearLoginAttempts();
        $this->updateUserClearResetPasswordCode();
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
     * @since   1.0.0
     */
    public function isLoggedOn($session_id, $username)
    {
        $this->verifySession($session_id, 'isLoggedOn');
        $this->verifyUser('isLoggedOn');
        $this->verifySessionNotTimedOut();
        $this->verifySessionFormToken();

        if ($this->error === true) {
            return $this->redirect401();
        }

        $this->updateUser();

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
     * @since   1.0.0
     */
    public function changePassword(
        $session_id,
        $username,
        $password = '',
        $new_password = '',
        $reset_password_code = '',
        $remember = false
    ) {
        $this->verifySession($session_id, 'login');
        $this->verifyUser('login');
        $this->verifySessionFormToken();
        $this->verifyPasswordChange($new_password);
        $this->verifyUsernamePassword($username, $password, $reset_password_code);

        if ($this->error === true) {
            echo 'error';
            die;
            return $this->redirect401();
        }

        $this->updateUserPassword($new_password);
        $this->updateUserLastVisit();
        $this->updateUserLastActivityDate();
        $this->updateUserClearLoginAttempts();
        $this->updateUserClearResetPasswordCode();

        $this->updateUser();

        if ((int)$this->remember === true) {
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
     * @since   1.0.0
     */
    public function requestPasswordReset($session_id, $username)
    {
        $this->verifySession($session_id, 'requestPasswordReset');
        $this->verifyUser('requestPasswordReset');
        $this->verifySessionFormToken();

        if ($this->error === true) {
            return $this->redirect401();
        }

        $this->updateUserResetPasswordCode();
        $this->updateUser();
        $this->emailPasswordReset();

        return 0;
    }

    /**
     * Log out and Redirect
     *
     * @param   string $session_id
     * @param   string $username
     *
     * @return  stdClass
     * @since   1.0.0
     */
    public function logout($session_id, $username)
    {
        $this->verifySession($session_id, 'logout');
        $this->verifyUser('logout');
        $this->verifySessionNotTimedOut();
        $this->verifySessionFormToken();

        if ($this->error === true) {
            return $this->redirect401();
        }

        $this->updateUser();
        $this->destroySession();
        $this->forgetCookie();

        return $this->redirect401();
    }

    /**
     * Redirect 401
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function redirect401()
    {
        $redirect       = new stdClass();
        $redirect->code = 401;
        $redirect->url  = $this->configuration->url_to_login;

        return $redirect;
    }
}
