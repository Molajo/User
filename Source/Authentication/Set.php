<?php
/**
 * Authentication Set
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

/**
 * Authentication Set
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Set extends Base
{
    /**
     * Update the session for log in information
     *
     * @return  $this
     * @since   1.0
     */
    protected function setSessionLogin()
    {
        $this->session->destroySession();
        $this->session_id = $this->session->getSession('session_id');
        $this->session->setSession($this->external_session_id, $this->user->username);
        $this->updates['#__users.session_id'] = $this->external_session_id;
        $this->session->setSession($this->user->username, $this->user->session_id);
        $this->session->setSession('login_datetime', time());
        $this->session->setSession('last_activity_datetime', time());

        return $this;
    }

    /**
     * Set a failed login attempt
     *
     * @return  $this
     * @since   1.0
     */
    protected function setFailedLoginAttempt()
    {
        $this->updates['#__users.login_attempts'] = $this->user->login_attempts + 1;
        if ((int)$this->user->login_attempts
            > (int)$this->configuration->max_login_attempts
        ) {
            $this->updates['#__users.block'] = 1;
        }
        $this->updates['#__users.last_activity_datetime'] = $this->today;

        $this->user = $this->updateUser();

        return $this;
    }

    /**
     * Set the Form Token
     *
     * @return  $this
     * @since   1.0
     */
    protected function setFormToken()
    {
        if ($this->session->getSession('form_token') === false) {
            $this->session->setSession('form_token', $this->encrypt->generateString(64));
        }

        return $this;
    }

    /**
     * Set the Reset Password Code
     *
     * @return  $this
     * @since   1.0
     */
    protected function setResetPasswordCode()
    {
        $this->updates['#__users.reset_password_code'] = $this->encrypt->generateString(16);

        return $this;
    }

    /**
     * Clear the number of login attempts
     *
     * @return  $this
     * @since   1.0
     */
    protected function clearLoginAttempts()
    {
        if ($this->user->login_attempts === 0) {
            return $this;
        }

        $this->updates['#__users.login_attempts'] = 0;

        return $this;
    }

    /**
     * Clear the Reset Password Code
     *
     * @return  $this
     * @since   1.0
     */
    protected function clearResetPasswordCode()
    {
        if ($this->user->reset_password_code == '') {
            return $this;
        }

        $this->updates['#__users.reset_password_code'] = null;

        return $this;
    }

    /**
     * Update User
     *
     * @return  $this
     * @since   1.0
     */
    protected function updateUser()
    {
        $this->userdata->updateUserdata($this->updates);

        return $this;
    }

    /**
     * Save Remember Me Cookie
     *
     * @return  object
     * @since   1.0
     */
    protected function saveRememberMeCookie()
    {
        return;
        /**
         * if ($remember
         * {
         * $this->cookie->forever($toPersist);
         * }/
         * 'remember_me_time',
         * 'remember_me_cookie_name',
         * 'remember_me_cookie_domain',
         * 'remember_me_secure',
         * 'remember_me_path',
         * 'encryption_method',
         */
    }
}
