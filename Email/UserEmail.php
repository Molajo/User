<?php
/**
 * User Email
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Email;

defined('MOLAJO') or die;

/**
 * User Email
 *
 * @package     Molajo
 * @subpackage  Service
 * @since       1.0
 */
class UserEmail implements UserEmailInterface
{
    /**
     * Email Instance
     *
     * @var    object  EmailInterface
     * @since  1.0
     */
    protected $email_instance;

    /**
     * List of Properties
     *
     * @var    object
     * @since  1.0
     */
    protected $property_array = array(
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
     * Constructor
     *
     * @param   UserEmailInterface  $email
     * @param   array               $parameters
     *
     * @since   1.0
     */
    public function __construct(UserEmailInterface $email, array $parameters)
    {
        $this->email_instance = $email;

        if (count($parameters) > 0) {
            foreach ($parameters as $key => $value) {
                if (in_array($this->property_array, $email)) {
                    $this->email->set($key, $value);
                }
            }
        }

        return;
    }

    /**
     * Set parameter Value
     *
     * @param   string  $key
     * @param   null    $value
     *
     * @return  mixed
     * @throws  UserMailException
     * @since   1.0
     */
    public function set($key, $value = null)
    {
        try {
            $this->email_instance->set($key, $value);

        } catch (\Exception $e) {

            throw new UserMailException
            ('User Mail Set Exception: ' . $e->getMessage());
        }
    }

    /**
     * Get parameters value
     *
     * @param   string  $key
     * @param   null    $value
     *
     * @return  mixed
     * @throws  UserMailException
     * @since   1.0
     */
    public function get($key, $default = null)
    {
        try {
            $this->email_instance->get($key, $default);

        } catch (\Exception $e) {

            throw new UserMailException
            ('User Mail Get Exception: ' . $e->getMessage());
        }

        return;
    }

    /**
     * Send email
     *
     * @return  mixed
     * @throws  UserMailException
     * @since   1.0
     */
    public function send()
    {
        try {
            $this->email_instance->send();

        } catch (\Exception $e) {

            throw new UserMailException
            ('User Mail Send Exception: ' . $e->getMessage());
        }

        return;
    }
}
