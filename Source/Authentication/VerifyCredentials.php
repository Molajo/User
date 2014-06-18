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
abstract class VerifyCredentials extends VerifyUser implements AuthenticationInterface
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
        $this->verifyPasswordChangeValue($new_password);
        $this->verifyPasswordChangeLength($new_password);
        $this->verifyPasswordChangeNotMatchUsername($new_password);
        $this->verifyPasswordChangeNotMatchLastPassword($new_password);
        $this->verifyPasswordChangeAlphaCharacterRequired($new_password);
        $this->verifyPasswordChangeNumericCharacterRequired($new_password);
        $this->verifyPasswordChangeSpecialCharacterRequired($new_password);
        $this->verifyPasswordChangeMixedCaseRequired($new_password);

        return $this;
    }

    /**
     * Verify Password Change Length
     *
     * @param   string $new_password
     *
     * @return  VerifyCredentials
     * @since   1.0
     */
    protected function verifyPasswordChangeLength($new_password)
    {
        $this->verifyPasswordChangeMinimum();
        $this->verifyPasswordChangeMaximum();

        $options = array();
        $options['from'] = $this->configuration->password_minimum_password_length;
        $options['to']   = $this->configuration->password_maximum_password_length;

        return $this->verifyPasswordChangeTest($new_password, 2100, 'Stringlength', $options);
    }

    /**
     * Verify Password Change Length Maximum
     *
     * @param   string $new_password
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChangeValue($new_password)
    {
        if ($new_password === '' || $new_password === null) {
            $this->error = true;
            $this->setFlashmessage(2130);
        }

        return $this;
    }

    /**
     * Verify Password Change Length Minimum
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChangeMinimum()
    {
        if ($this->configuration->password_minimum_password_length === 0) {
            $this->configuration->password_minimum_password_length = 5;
        }

        return $this;
    }

    /**
     * Verify Password Change Length Maximum
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChangeMaximum()
    {
        if ($this->configuration->password_maximum_password_length
            < $this->configuration->password_minimum_password_length
        ) {
            $this->configuration->password_maximum_password_length = 10;
        }

        return $this;
    }

    /**
     * Verify Password Change -- Must not match Username
     *
     * @param   string $new_password
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChangeNotMatchUsername($new_password)
    {
        if ($this->configuration->password_must_not_match_username === false) {
            return $this;
        }

        $options              = array();
        $options['not_equal'] = $this->user->username;

        return $this->verifyPasswordChangeTest($new_password, 2200, 'Notequal', $options);
    }

    /**
     * Verify Password Change -- Must not match last password
     *
     * @param   string $new_password
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChangeNotMatchLastPassword($new_password)
    {
        if ($this->configuration->password_must_not_match_last_password === false) {
            return $this;
        }

        $test = $this->verifyHashString($new_password, $this->user->password);

        if ($test === 1) {
            $this->error = true;
            $this->setFlashmessage(2300);
        }

        return $this;
    }

    /**
     * Verify Password Change -- Alpha Character Required
     *
     * @param   string $new_password
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChangeAlphaCharacterRequired($new_password)
    {
        if ($this->configuration->password_alpha_character_required === false) {
            return $this;
        }

        $this->verifyPasswordChangeRegex($new_password, '/[A-Za-z]/', 2400);

        return $this;
    }

    /**
     * Verify Password Change -- Numeric Character Required
     *
     * @param   string $new_password
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChangeNumericCharacterRequired($new_password)
    {
        if ($this->configuration->password_numeric_character_required === false) {
            return $this;
        }

        $this->verifyPasswordChangeRegex($new_password, '/[0-9]/', 2500);

        return $this;
    }

    /**
     * Verify Password Change -- Special character required
     *
     * @param   string $new_password
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChangeSpecialCharacterRequired($new_password)
    {
        if ($this->configuration->password_special_character_required === false) {
            return $this;
        }

        $this->verifyPasswordChangeRegex($new_password, '/[!*@#$%]/', 2600);

        return $this;
    }

    /**
     * Verify Password Change -- Mixed case character required
     *
     * @param   string $new_password
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChangeMixedCaseRequired($new_password)
    {
        if ($this->configuration->password_mixed_case_required === false) {
            return true;
        }

        $this->verifyPasswordChangeRegex($new_password, '`[A-Z]`', 2700);
        $this->verifyPasswordChangeRegex($new_password, '`[a-z]`', 2800);

        return $this;
    }

    /**
     * Verify Password Change -- Mixed case character required
     *
     * @param   string  $new_password
     * @param   string  $regex
     * @param   integer $message_id
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChangeRegex($new_password, $regex, $message_id)
    {
        $options          = array();
        $options['regex'] = $regex;

        return $this->verifyPasswordChangeTest($new_password, $message_id, 'Regex', $options);
    }

    /**
     * Verify Password Change -- Mixed case character required
     *
     * @param   string  $new_password
     * @param   integer $message_id
     * @param   string  $test
     * @param   array   $options
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyPasswordChangeTest($new_password, $message_id, $test, $options)
    {
        if ($this->fieldhandler->validate('Password', $new_password, $test, $options) === false) {
            $this->error = true;
            $this->setFlashmessage($message_id);
        }

        return $this;
    }
}
