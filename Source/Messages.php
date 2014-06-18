<?php
/**
 * Messages Class
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User;

use CommonApi\User\MessagesInterface;
use CommonApi\User\FlashMessageInterface;

/**
 * Message Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Messages implements MessagesInterface
{
    /**
     * Flashmessage Instance
     *
     * @var    object  CommonApi\User\FlashMessageInterface
     * @since  1.0
     */
    protected $flashmessage;

    /**
     * Error Messages
     *  Load with language specific messages via Constructor using IoCC
     *
     * @var    array
     * @since  1.0
     */
    protected $messages = array();

    /**
     * Construct
     *
     * @param  FlashMessageInterface $flashmessage
     * @param  array                 $messages
     *
     * @since  1.0
     */
    public function __construct(
        FlashMessageInterface $flashmessage,
        array $messages = array()
    ) {
        $this->flashmessage = $flashmessage;

        $this->initializeMessages($messages);
    }

    /**
     * Set Message
     *
     * @param   int    $message_id
     * @param   string $message
     *
     * @since   1.0
     * @return  $this
     */
    public function setMessage($message_id, $message)
    {
        $this->messages[$message_id] = $message;

        return $this;
    }

    /**
     * Store Flash (User) Messages in Flashmessage for presentation after redirect
     *
     * @param   int    $message_id
     * @param   array  $values
     * @param   string $type (Success, Notice, Warning, Error)
     *
     * @return  $this
     * @since   1.0
     */
    public function setFlashmessage($message_id, array $values = array(), $type = 'Error')
    {
        $message = $this->getMessage($message_id, $values);

        $this->flashmessage->setFlashmessage($type, $message);

        return $this;
    }

    /**
     * Get Message
     *
     * @param   int   $message_id
     * @param   array $values
     *
     * @since   1.0
     * @return  string
     */
    public function getMessage($message_id = 0, array $values = array())
    {
        if ((int)$message_id === 0) {
            return $this->messages;
        }

        if (isset($this->messages[$message_id])) {
            return $this->formatMessage($this->messages[$message_id], $values);
        }

        $this->throwException(5000, array('message' => $message_id), 'CommonApi\\Exception\\RuntimeException');
    }

    /**
     * Replace placeholders {key} with values
     *
     * @param   string $message
     * @param   array  $values
     *
     * @return  string
     * @since   1.0
     */
    protected function formatMessage($message, array $values = array())
    {
        $replace = array();

        foreach ($values as $key => $value) {
            $replace['{' . $key . '}'] = $value;
        }

        return (strtr($message, $replace));
    }

    /**
     * Format Exception Message and throw the Exception
     *
     * @param   int         $message_id
     * @param   array       $values
     * @param   null|string $exception
     *
     * @return  $this
     * @since   1.0
     * @throws  $exception
     */
    public function throwException($message_id, array $values = array(), $exception = null)
    {
        $message = $this->formatMessage($message_id, $values);

        if (class_exists($exception)) {
            $class = $exception;
        } else {
            $class = 'CommonApi\\Exception\\RuntimeException';
        }

        throw new $class ($message);
    }

    /**
     * Initialize Messages
     *
     * @param   array $messages
     *
     * @return  $this
     * @since   1.0
     */
    protected function initializeMessages(array $messages)
    {
        if (count($messages) > 0) {
            foreach ($messages as $key => $message) {
                $this->messages[$key] = $message;
            }
        }

        return $this;
    }
}
