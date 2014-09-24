<?php
/**
 * Authentication Verify New Password
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use CommonApi\User\AuthenticationInterface;

/**
 * Authentication Verify New Password
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class VerifyNewPassword extends VerifyUser implements AuthenticationInterface
{
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

        $options         = array();
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
