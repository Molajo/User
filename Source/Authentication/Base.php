<?php
/**
 * Authentication Base
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use DateTime;
use Exception;
use CommonApi\Model\FieldhandlerInterface;
use CommonApi\User\CookieInterface;
use CommonApi\User\EncryptInterface;
use CommonApi\User\MailerInterface;
use CommonApi\User\MessagesInterface;
use CommonApi\User\SessionInterface;
use CommonApi\User\UserDataInterface;
use stdClass;

/**
 * Authentication Base
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Base
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
     * Session Instance
     *
     * @var    object  CommonApi\User\SessionInterface
     * @since  1.0
     */
    protected $session;

    /**
     * Cookie Instance
     *
     * @var    object  CommonApi\User\CookieInterface
     * @since  1.0
     */
    protected $cookie;

    /**
     * Mailer Instance
     *
     * @var    object  CommonApi\User\MailerInterface
     * @since  1.0
     */
    protected $mailer;

    /**
     * Messages Instance
     *
     * @var    object  CommonApi\User\MessagesInterface
     * @since  1.0
     */
    protected $messages;

    /**
     * Encrypt Instance
     *
     * @var    object  CommonApi\User\EncryptInterface
     * @since  1.0
     */
    protected $encrypt;

    /**
     * Fieldhandler Instance
     *
     * @var    object  CommonApi\Model\FieldhandlerInterface
     * @since  1.0
     */
    protected $fieldhandler;

    /**
     * Configuration Settings
     *
     * @var    object
     * @since  1.0
     */
    protected $configuration;

    /**
     * $_SERVER OBJECT
     *
     * @var    object
     * @since  1.0
     */
    protected $server;

    /**
     * $_POST OBJECT
     *
     * @var    object
     * @since  1.0
     */
    protected $post;

    /**
     * Session ID
     *
     * @var    string
     * @since  1.0
     */
    protected $external_session_id;

    /**
     * Default Exception
     *
     * @var    string
     * @since  1.0
     */
    protected $default_exception = 'CommonApi\\Exception\\RuntimeException';

    /**
     * Today
     *
     * @var    datetime
     * @since  1.0
     */
    protected $today;

    /**
     * Guest
     *
     * @var    boolean
     * @since  1.0
     */
    protected $guest;

    /**
     * Remember
     *
     * @var    boolean
     * @since  1.0
     */
    protected $remember;

    /**
     * Updates
     *
     * @var    array
     * @since  1.0
     */
    protected $updates = array();

    /**
     * Error
     *
     * @var    boolean
     * @since  1.0
     */
    protected $error = false;

    /**
     * Session ID
     *
     * @var    string
     * @since  1.0
     */
    protected $session_id;

    /**
     * Construct
     *
     * @param  UserDataInterface     $userdata
     * @param  SessionInterface      $session
     * @param  CookieInterface       $cookie
     * @param  MailerInterface       $mailer
     * @param  MessagesInterface     $messages
     * @param  EncryptInterface      $encrypt
     * @param  FieldhandlerInterface $fieldhandler
     * @param  stdClass              $configuration
     * @param  object                $server
     * @param  object                $post
     * @param  string                $external_session_id
     * @param  null|string           $default_exception
     *
     * @since  1.0
     */
    public function __construct(
        UserDataInterface $userdata,
        SessionInterface $session,
        CookieInterface $cookie,
        MailerInterface $mailer,
        MessagesInterface $messages,
        EncryptInterface $encrypt,
        FieldhandlerInterface $fieldhandler,
        $configuration,
        $server,
        $post,
        $external_session_id,
        $default_exception = null
    ) {
        $this->userdata            = $userdata;
        $this->user                = $this->userdata->getUserdata();
        $this->today               = $this->user->today;
        $this->session             = $session;
        $this->cookie              = $cookie;
        $this->mailer              = $mailer;
        $this->messages            = $messages;
        $this->encrypt             = $encrypt;
        $this->fieldhandler        = $fieldhandler;
        $this->configuration       = $configuration;
        $this->server              = $server;
        $this->post                = $post;
        $this->external_session_id = $external_session_id;

        if ($default_exception === null) {
        } else {
            $this->default_exception = $default_exception;
        }
    }
}
