<?php
/**
 * Authentication Verify User
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use DateTime;
use CommonApi\User\AuthenticationInterface;

/**
 * Authentication Verify
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class VerifyUser extends Session implements AuthenticationInterface
{
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

        $this->verifyUserActivationDate();

        if ($action == 'login' || $action == 'changePassword' || 'requestPasswordReset') {
            $this->verifyLoginAttempts($today_datetime);
        }

        $this->verifyUserBlock();

        $this->verifyUserPasswordExpiration($today_datetime);

        return true;
    }

    /**
     * Verify User Activation Date
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyUserActivationDate()
    {
        if ($this->user->activation_datetime == '0000-00-00 00:00:00') {
            $this->error = true;
            $this->messages->setFlashmessage(600);
        }

        return $this;
    }

    /**
     * Verify User Activation Date
     *
     * @param   DateTime $today_datetime
     *
     * @return  mixed
     * @since   1.0
     */
    protected function verifyLoginAttempts($today_datetime)
    {
        if ($this->verifyLoginAttemptsCount() === false) {
            $this->updateUserBlock();
            return $this;
        }

        if ($this->verifyLoginRemoveBlock($today_datetime) === true) {
            $this->updateUserRemoveBlock();
            return $this;
        }

        $this->error = true;
        $this->messages->setFlashmessage(800);

        return $this;
    }

    /**
     * Verify User Login Attempts -- count of failures
     *
     * @return  boolean
     * @since   1.0
     */
    protected function verifyLoginAttemptsCount()
    {
        if ($this->user->login_attempts > $this->configuration->max_login_attempts) {
            return false;
        }

        return true;
    }

    /**
     * Verify Number of Days Block is in effect have passed
     *
     * @param   DateTime $today_datetime
     *
     * @return  boolean
     * @since   1.0
     */
    protected function verifyLoginRemoveBlock($today_datetime)
    {
        if ($this->configuration->password_lock_out_days === 0) {
            return true;
        }

        $last_activity_date = new DateTime($this->user->last_activity_datetime);
        $day_object         = $last_activity_date->diff($today_datetime);

        if ($day_object->days > $this->configuration->password_lock_out_days) {
            $this->updateUserRemoveBlock();
            return true;
        }

        $this->error = true;
        $this->messages->setFlashmessage(800);

        return false;
    }

    /**
     * Verify whether or not the user is blocked
     *
     * @return  boolean
     * @since   1.0
     */
    protected function verifyUserBlock()
    {
        if ($this->user->block == 1) {
            $this->error = true;
            $this->messages->setFlashmessage(1100);

            return false;
        }

        return true;
    }

    /**
     * Verify whether or not the User Password has expired and must be changed
     *
     * @param   DateTime $today_datetime
     *
     * @return  boolean
     * @since   1.0
     */
    protected function verifyUserPasswordExpiration($today_datetime)
    {
        $password_changed_datetime = new DateTime($this->user->password_changed_datetime);
        $day_object                = $password_changed_datetime->diff($today_datetime);

        if ($day_object->days > (int)$this->configuration->password_expiration_days
            && (int)$this->configuration->password_expiration_days > 0
        ) {
            $this->updateUserBlock();
            $this->error = true;
            $this->messages->setFlashmessage(1200);
        }

        return $this;
    }
}
