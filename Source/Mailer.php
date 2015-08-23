<?php
/**
 * User Mailer Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\User;

use CommonApi\Email\EmailInterface;
use CommonApi\User\MailerInterface;
use CommonApi\User\TemplateInterface;

/**
 * User Mailer Class
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Mailer implements MailerInterface
{
    /**
     * Email Instance
     *
     * @var    object  CommonApi\Email\EmailInterface
     * @since  1.0.0
     */
    protected $email;

    /**
     * Template Instance
     *
     * @var    object  CommonApi\User\TemplateInterface
     * @since  1.0.0
     */
    protected $template;

    /**
     * List of Properties that will be sent via email
     *
     * @var    array
     * @since  1.0.0
     */
    protected $property_array
        = array(
            'to',
            'from',
            'reply_to',
            'cc',
            'bcc',
            'subject',
            'body',
            'mailer_html_or_text',
            'attachment'
        );

    /**
     * Construct
     *
     * @param  EmailInterface    $email
     * @param  TemplateInterface $template
     *
     * @since  1.0.0
     */
    public function __construct(
        EmailInterface $email,
        TemplateInterface $template = null
    ) {
        $this->email    = $email;
        $this->template = $template;
    }

    /**
     * Set the Option Values, Initiate Rendering, Send
     *
     * @param   string $template
     * @param   object $input_data
     *
     * @return  $this
     * @since   1.0.0
     */
    public function send($template, $input_data)
    {
        $data = $this->processTemplate($template, $input_data);

        return $this->processMail($data);
    }

    /**
     * Set the Option Values, Initiate Rendering, Send
     *
     * @param   string $template
     * @param   object $input_data
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function processTemplate($template, $input_data)
    {
        $this->template->set('type', $template);

        $results = $this->template->render($input_data);

        $input_data->subject = $results->subject;
        $input_data->body    = $results->body;

        return $input_data;
    }

    /**
     * Send Email
     *
     * @param   Mailer $data
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function processMail($data)
    {
        foreach ($this->property_array as $property) {
            if (isset($data->$property)) {
                $this->email->set($property, $data->$property);
            }
        }

        $this->email->send();

        return $this;
    }
}
