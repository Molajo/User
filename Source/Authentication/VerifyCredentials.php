<?php
/**
 * Authentication Verify Credentials
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use Exception;
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
    protected function verifyCredentials(
        $username = '',
        $password = '',
        $reset_password_code = ''
    ) {
        if ($this->configuration->password_email_address_as_username === true) {
            $this->verifyUserProvidedKey('email', $username);
        } else {
            $this->verifyUserProvidedKey('username', $username);
        }

        $this->verifyUserPassword($password, $reset_password_code);

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
        if ($new_password === '' || $new_password === null) {
            $this->error = true;
            $this->messages->setFlashmessage(2130);
        }

        if ($this->configuration->password_minimum_password_length === 0) {
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

            if ($test === 1) {
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
        if ($password === '' && $reset_password_code === '') {
            $this->error = true;
            $this->messages->setFlashmessage(1400);
        }

        if ($password === '') {
            $this->verifyUserPasswordReset($reset_password_code);
        } else {
            $this->verifyUserPasswordHash($password);
        }

        return $this;
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
            $this->error = true;
            $this->messages->setFlashmessage(1400);
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
        } else {
            $this->updateUserFailedLoginAttempt();
            $this->error = true;
            $this->messages->setFlashmessage(1500);
        }

        return $this;
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
        $test = $this->encrypt->verifyHashString($password, $this->user->password);

        if ($test === true) {
            return $this;
        }

        $this->updateUserFailedLoginAttempt();

        $this->error = true;
        $this->messages->setFlashmessage(1600);

        return $this;
    }
}
