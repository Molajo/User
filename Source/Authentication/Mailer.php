<?php
/**
 * Mailer for User Authentication
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
use CommonApi\User\UserDataInterface;
use stdClass;

/**
 * Encryption for User Authentication
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Mailer extends UpdateUser implements AuthenticationInterface
{
    /**
     * Mailer Instance
     *
     * @var    object  CommonApi\User\MailerInterface
     * @since  1.0
     */
    protected $mailer;

    /**
     * Construct
     *
     * @param  UserDataInterface     $userdata
     * @param  MailerInterface       $mailer
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
        EncryptInterface $encrypt,
        FieldhandlerInterface $fieldhandler,
        $configuration,
        $server,
        $post
    ) {
        $this->mailer  = $mailer;

        parent::__construct(
            $userdata,
            $encrypt,
            $fieldhandler,
            $configuration,
            $server,
            $post
        );
    }

    /**
     * Email Password Reset
     *
     * @return  $this
     * @since   1.0
     */
    protected function emailPasswordReset()
    {
        $options          = array();
        $options['type']  = 'password_reset_request';
        $options['link']  = $this->configuration->url_to_change_password
            . '?reset_password_code=' . $this->user->reset_password_code;
        $options['name']  = $this->user->full_name;
        $options['today'] = $this->today;
        $options['to']    = $this->user->email
            . ', ' . $$this->user->full_name;

        $this->mailer->render($options)->send();
    }
}
