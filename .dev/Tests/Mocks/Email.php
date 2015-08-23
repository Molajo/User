<?php
/**
 * Email
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Mocks;

use CommonApi\Email\EmailInterface;

/**
 * Adapter for Email
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class MockEmail implements EmailInterface
{
    /**
     * Email Adapter Adapter
     *
     * @var     object
     * @since   1.0.0
     */
    protected $adapter;

    /**
     * To
     *
     * @var     array
     * @since   1.0.0
     */
    protected $to = array();

    /**
     * From
     *
     * @var     array
     * @since   1.0.0
     */
    protected $from = array();

    /**
     * Reply To
     *
     * @var     array
     * @since   1.0.0
     */
    protected $reply_to = array();

    /**
     * Copy
     *
     * @var     array
     * @since   1.0.0
     */
    protected $cc = array();

    /**
     * Blind Copy
     *
     * @var     array
     * @since   1.0.0
     */
    protected $bcc = array();

    /**
     * Subject
     *
     * @var     string
     * @since   1.0.0
     */
    protected $subject = '';

    /**
     * Body
     *
     * @var     string
     * @since   1.0.0
     */
    protected $body = '';

    /**
     * HTML or Text
     *
     * @var     string
     * @since   1.0.0
     */
    protected $mailer_html_or_text = '';

    /**
     * Attachment
     *
     * @var     string
     * @since   1.0.0
     */
    protected $attachment = '';

    /**
     * Return parameter value or default
     *
     * @param   string $key
     * @param   string $default
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function get($key, $default = null)
    {
        return $this->$key;
    }

    /**
     * Set parameter value
     *
     * @param   string $key
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0.0
     */
    public function set($key, $value = null)
    {
        $this->$key = $value;

        return $this;
    }

    /**
     * Send Email
     *
     * @return  $tgus
     * @since   1.0.0
     */
    public function send()
    {
        return $this;
    }
}
