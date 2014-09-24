<?php
/**
 * User Messages for Authentication
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
 * User Messages for Authentication
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Message extends Mailer implements AuthenticationInterface
{
    /**
     * Messages Instance
     *
     * @var    object  CommonApi\User\MessagesInterface
     * @since  1.0
     */
    protected $messages;

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
        $this->messages = $messages;

        parent::__construct(
            $userdata,
            $mailer,
            $encrypt,
            $fieldhandler,
            $configuration,
            $server,
            $post
        );
    }

    /**
     * Throw Exception and Format Message
     *
     * @param   integer $message_id
     *
     * @return  object
     * @since   1.0
     */
    protected function setFlashMessage(
        $message_id
    ) {
        return $this->messages->setFlashmessage($message_id);
    }

    /**
     * Throw Exception and Format Message
     *
     * @param   integer $message_id
     * @param   array   $thing
     * @param   string  $exception
     *
     * @return  object
     * @since   1.0
     */
    protected function throwExceptionMessage(
        $message_id,
        array $thing = array(),
        $exception = 'CommonApi\\Exception\\RuntimeException'
    ) {
        return $this->messages->throwException($message_id, $thing, $exception);
    }
}
