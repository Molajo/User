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
 * Error Message Class
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
     * Default Messages Exception
     *
     * @var    string
     * @since  1.0
     */
    protected $messages_exception = 'CommonApi\\Exception\\RuntimeException';

    /**
     * Construct
     *
     * @param  FlashMessageInterface $flashmessage
     * @param  array                 $messages
     * @param  null                  $messages_exception
     *
     * @since  1.0
     */
    public function __construct(
        FlashMessageInterface $flashmessage,
        array $messages = array(),
        $messages_exception = null)
    {
        $this->flashmessage = $flashmessage;

        if (count($messages) > 0) {
            foreach ($messages as $key => $message) {
                $this->messages[$key] = $message;
            }
        }

        if ($messages_exception === null) {
        } else {
            $this->messages_exception = $messages_exception;
        }
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
     * Get Message
     *
     * @param   int $message_id
     *
     * @since   1.0
     * @return  $this
     */
    public function getMessage($message_id = 0)
    {
        if ((int)$message_id == 0) {
            return $this->messages;
        }

        if (isset($this->messages[$message_id])) {
            return $this->messages[$message_id];
        }

        $this->throwException(5000, array('message' => $message_id), $this->messages_exception);

        return $this;
    }

    /**
     * Store Flash (User) Messages in Flashmessage for presentation after redirect
     *
     * @param   int    $message_id
     * @param   array  $values
     * @param   string $type (Success, Notice, Warning, Error)
     *
     * @return  null
     * @since   1.0
     */
    public function setFlashmessage($message_id, array $values = array(), $type = 'Error')
    {
        $message = $this->formatMessage($message_id, $values);

        $this->flashmessage->setFlashmessage($type, $message);

        return $this;
    }

    /**
     * Format Exception Message and throw the Exception
     *
     * @param   int    $message_id
     * @param   array  $values
     * @param   string $exception
     *
     * @return  $this
     * @since   1.0
     * @throws  $exception
     */
    public function throwException($message_id, array $values = array(), $exception = null)
    {
        $message = $this->formatMessage($message_id, $values);

        if ($exception == null) {
        } else {
            $this->messages_exception = $exception;
        }

        if (class_exists($exception)) {
            $class = $exception;
        } else {
            $class = 'CommonApi\\Exception\\RuntimeException';
        }

        throw new $class ($message);
    }

    /**
     * Replace placeholders {key} with values
     *
     * @param   int   $message_id
     * @param   array $values
     *
     * @return  string
     * @since   1.0
     */
    protected function formatMessage($message_id = 0, $values = array())
    {
        $replace = array();

        $message = $this->messages[$message_id];

        foreach ($values as $key => $value) {
            $replace['{' . $key . '}'] = $value;
        }

        return (strtr($message, $replace));
    }
}
