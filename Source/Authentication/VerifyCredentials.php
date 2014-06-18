<?php
/**
 * Authentication Verify Credentials
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use CommonApi\User\AuthenticationInterface;

/**
 * Authentication Verify Credentials
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class VerifyCredentials extends VerifyNewPassword implements AuthenticationInterface
{
    /**
     * Used during login and other times username and password must be verified
     *
     * @param   string $username
     * @param   string $password
     * @param   string $reset_password_code
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function verifyUsernamePassword(
        $username = '',
        $password = '',
        $reset_password_code = ''
    ) {
        if ($this->configuration->password_email_address_as_username === true) {
            $this->verifyUserProvidedKey('email', $username, 1300);
        } else {
            $this->verifyUserProvidedKey('username', $username, 1310);
        }

        $this->verifyUserPassword($password, $reset_password_code);

        return $this;
    }

    /**
     * Verify User for Username or Email
     *
     * @param   string  $key
     * @param   string  $value
     * @param   integer $message_id
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyUserProvidedKey($key, $value, $message_id)
    {
        if ($this->user->$key === $value) {
            return $this;
        }

        return $this->setUserPasswordError($message_id);
    }

    /**
     * Verify User Password
     *
     * @param   string $password
     * @param   string $reset_password_code
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyUserPassword($password, $reset_password_code)
    {
        if ($this->verifyUserPasswordNeither($password, $reset_password_code) === true) {
            return $this;
        }

        if ($password === '') {
            return $this->verifyUserPasswordReset($reset_password_code);
        }

        return $this->verifyUserPasswordHash($password);
    }

    /**
     * Verify User Password
     *
     * @param   string $password
     * @param   string $reset_password_code
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyUserPasswordNeither($password, $reset_password_code)
    {
        if ($password === '' && $reset_password_code === '') {
            return $this->setUserPasswordError(1400);
        }

        return $this;
    }

    /**
     * Verify User Password Reset
     *
     * @param   string $reset_password_code
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyUserPasswordReset($reset_password_code)
    {
        if ($reset_password_code === $this->user->reset_password_code) {
            return $this;
        }

        return $this->setUserPasswordError(1500);
    }

    /**
     * Verify User Password Hash
     *
     * @param   string $password
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyUserPasswordHash($password)
    {
        if ($this->verifyHashString($password, $this->user->password) === true) {
            return $this;
        }

        return $this->setUserPasswordError(1400);
    }

    /**
     * Set User Password Error
     *
     * @param   integer $message_id
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUserPasswordError($message_id)
    {
        $this->updateUserFailedLoginAttempt();

        $this->error = true;
        $this->setFlashmessage($message_id);

        return $this;
    }
}
