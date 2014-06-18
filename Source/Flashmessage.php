<?php
/**
 * Flash Message Class
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User;

use CommonApi\User\FlashMessageInterface;
use CommonApi\User\SessionInterface;

/**
 * Flash Message Interface
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Flashmessage implements FlashMessageInterface
{
    /**
     * Session Instance
     *
     * @var    object  CommonApi\User\SessionInterface
     * @since  1.0
     */
    protected $session;

    /**
     * Default Messages Exception
     *
     * @var    string
     * @since  1.0
     */
    protected $flash_message_exception = 'CommonApi\\Exception\\RuntimeException';

    /**
     * Valid Flash Types
     *
     * @var    string
     * @since  1.0
     */
    protected $flash_types = array('Success', 'Notice', 'Warning', 'Error');

    /**
     * Constructor
     *
     * @param SessionInterface $session
     * @param array            $flash_types
     * @param null|string      $flash_message_exception
     *
     * @since  1.0
     */
    public function __construct(
        SessionInterface $session,
        $flash_types = array(),
        $flash_message_exception = null
    ) {
        $this->session = $session;

        if (is_array($flash_types) && count($flash_types) > 0) {
            $this->flash_types = $flash_types;
        }

        if ($flash_message_exception === null) {
        } else {
            $this->flash_message_exception = $flash_message_exception;
        }
    }

    /**
     * Get Flash Messages for User, all or by Type
     *
     * @param   string $type (Success, Notice, Warning, Error)
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getFlashmessage($type = null)
    {
        $list = array();

        if ($type === null) {
            $list = $this->flash_types;
        } else {
            $list[] = $type;
        }

        $allMessages = array();
        foreach ($list as $item) {

            $type_messages = $this->session->getSession($item);

            if (is_array($type_messages) && count($type_messages) > 0) {
                $allMessages[$item] = $type_messages;
            }
        }
        return $allMessages;
    }

    /**
     * Save a Flash Message (User Message)
     *
     * @param   string $type (Success, Notice, Warning, Error)
     * @param   string $message
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setFlashmessage($type, $message)
    {
        if (in_array($type, $this->flash_types)) {
        } else {
            // Cannot use messages instance due to messages instance requiring session
            throw new $this->flash_message_exception
            (
                'Invalid Type: ' . $type . ' specified for setFlashmessage.'
            );
        }

        $type_messages = $this->session->getSession($type);

        if ($type_messages === false) {
            $type_messages = array();
        } elseif (is_array($type_messages)) {
        } else {
            $type_messages = array();
        }

        $type_messages[] = $message;

        $this->session->setSession($type, $type_messages);

        return $this;
    }

    /**
     * Delete Flash Messages, all or by type
     *
     * @param   null|string $type
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function deleteFlashmessage($type = null)
    {
        $list = array();

        if ($type === null) {
            $list = $this->flash_types;
        } else {
            $list[] = $type;
        }

        foreach ($list as $item) {
            $this->session->deleteSession($item);
        }

        return $this;
    }
}
