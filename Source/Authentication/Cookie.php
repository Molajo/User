<?php
/**
 * User Cookie Authentication
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use CommonApi\Model\FieldhandlerInterface;
use CommonApi\User\AuthenticationInterface;
use CommonApi\User\CookieInterface;
use CommonApi\User\EncryptInterface;
use CommonApi\User\MailerInterface;
use CommonApi\User\MessagesInterface;
use CommonApi\User\UserDataInterface;
use stdClass;

/**
 * User Cookie Authentication
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Cookie extends Mailer implements AuthenticationInterface
{
    /**
     * Cookie Instance
     *
     * @var    object  CommonApi\User\CookieInterface
     * @since  1.0
     */
    protected $cookie;

    /**
     * Remember
     *
     * @var    boolean
     * @since  1.0
     */
    protected $remember;

    /**
     * Construct
     *
     * @param  UserDataInterface     $userdata
     * @param  CookieInterface       $cookie
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
        CookieInterface $cookie,
        MailerInterface $mailer,
        MessagesInterface $messages,
        EncryptInterface $encrypt,
        FieldhandlerInterface $fieldhandler,
        $configuration,
        $server,
        $post
    ) {
        $this->cookie = $cookie;

        parent::__construct(
            $userdata,
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

    /**
     * Forget Cookie
     *
     * @return  object
     * @since   1.0
     */
    protected function forgetCookie()
    {
        return;
    }
}
