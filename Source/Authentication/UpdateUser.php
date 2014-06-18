<?php
/**
 * Authentication Update User
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use CommonApi\Model\FieldhandlerInterface;
use CommonApi\User\AuthenticationInterface;
use CommonApi\User\EncryptInterface;
use CommonApi\User\MailerInterface;
use CommonApi\User\MessagesInterface;
use CommonApi\User\UserDataInterface;
use DateTime;
use stdClass;

/**
 * Update User for Authentication
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class UpdateUser extends Encrypt implements AuthenticationInterface
{
    /**
     * User Data Instance
     *
     * @var    object  CommonApi\User\UserDataInterface
     * @since  1.0
     */
    protected $userdata;

    /**
     * User Data
     *
     * @var    object
     * @since  1.0
     */
    protected $user;

    /**
     * Today
     *
     * @var    DateTime
     * @since  1.0
     */
    protected $today;

    /**
     * Updates
     *
     * @var    array
     * @since  1.0
     */
    protected $updates = array();

    /**
     * Construct
     *
     * @param  UserDataInterface     $userdata
     * @param  MailerInterface       $mailer
     * @param  MessagesInterface     $messages
     * @param  EncryptInterface      $encrypt
     * @param  FieldhandlerInterface $fieldhandler
     * @param  stdClass              $configuration
     * @param  object                $server
     * @param  object                $post
     *
     * @since  1.0
     */
    public function __construct(
        UserDataInterface $userdata,
        MailerInterface $mailer,
        MessagesInterface $messages,
        EncryptInterface $encrypt,
        FieldhandlerInterface $fieldhandler,
        $configuration,
        $server,
        $post
    ) {
        $this->userdata = $userdata;
        $this->user     = $this->userdata->getUserdata();
        $this->today    = $this->user->today;

        parent::__construct(
            $mailer,
            $messages,
            $encrypt,
            $fieldhandler,
            $configuration,
            $server,
            $post
        );
    }

    /**
     * Clear the number of login attempts after successful login
     *
     * @return  $this
     * @since   1.0
     */
    protected function updateUserClearLoginAttempts()
    {
        if ($this->user->login_attempts === 0) {
            return $this;
        }

        $this->updates['#__users.login_attempts'] = 0;

        $this->updateUserClearResetPasswordCode();

        $this->updateUserRemoveBlock();

        return $this;
    }

    /**
     * Clear the Reset Password Code
     *
     * @return  $this
     * @since   1.0
     */
    protected function updateUserClearResetPasswordCode()
    {
        if ($this->user->reset_password_code === '') {
            return $this;
        }

        $this->updates['#__users.reset_password_code'] = null;

        return $this;
    }

    /**
     * Update User Remove Block
     *
     * @return  $this
     * @since   1.0
     */
    protected function updateUserRemoveBlock()
    {
        $this->updates['#__users.block'] = 0;

        return $this->updateUser();
    }

    /**
     * Update User Password Expired
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function updateUserBlock()
    {
        $this->updates['#__users.block'] = 1;

        return $this->updateUser();
    }

    /**
     * Set a failed login attempt
     *
     * @return  $this
     * @since   1.0
     */
    protected function updateUserFailedLoginAttempt()
    {
        $this->updates['#__users.login_attempts'] = $this->user->login_attempts + 1;

        if ((int)$this->user->login_attempts > (int)$this->configuration->max_login_attempts) {
            $this->updates['#__users.block'] = 1;
        }

        $this->updateUser();

        return $this;
    }

    /**
     * Update the User Password
     *
     * $param   string  $new_password
     *
     * @return  $this
     * @since   1.0
     */
    protected function updateUserPassword($new_password)
    {
        $hash = $this->createHashString($new_password);

        $this->updates['#__users.password']                  = $hash;
        $this->updates['#__users.password_changed_datetime'] = $this->today;

        return $this;
    }

    /**
     * Update User Session Id
     *
     * $param   string  $session_id
     *
     * @return  $this
     * @since   1.0
     */
    protected function updateUserSessionId($session_id)
    {
        $this->updates['#__users.session_id'] = $session_id;

        return $this;
    }


    /**
     * Set the Reset Password Code
     *
     * @return  $this
     * @since   1.0
     */
    protected function updateUserResetPasswordCode()
    {
        $this->updates['#__users.reset_password_code'] = $this->generateString();

        return $this;
    }

    /**
     * Set the Login Date Time
     *
     * @return  $this
     * @since   1.0
     */
    protected function updateUserLoginDateTime()
    {
        $this->updates['#__users.login_datetime'] = $this->today;

        return $this;
    }

    /**
     * Set the Login Date Time
     *
     * @return  $this
     * @since   1.0
     */
    protected function updateUserLastVisit()
    {
        $this->updates['#__users.last_visit_datetime'] = $this->today;

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
        $this->updateUserLastActivityDate();

        $this->user = $this->userdata->updateUserdata($this->updates);

        return $this;
    }

    /**
     * Set the Login Date Time
     *
     * @return  $this
     * @since   1.0
     */
    protected function updateUserLastActivityDate()
    {
        $this->updates['#__users.last_activity_datetime'] = $this->today;

        return $this;
    }
}
