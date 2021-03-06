<?php
/**
 * Authentication Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Authentication;

use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;
use stdClass;

/**
 * Authentication Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class AuthenticationFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
    /**
     * Constructor
     *
     * @param  array $options
     *
     * @since  1.0.0
     */
    public function __construct(array $options = array())
    {
        $options['product_name']             = basename(__DIR__);
        $options['store_instance_indicator'] = true;
        $options['product_namespace']        = 'Molajo\\User\\Authentication';

        parent::__construct($options);
    }

    /**
     * Retrieve a list of Interface dependencies and return the data ot the controller.
     *
     * @return  array
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        parent::setDependencies(array());

        $options                            = array();
        $this->dependencies['Runtimedata']  = $options;
        $this->dependencies['Mailer']       = $options;
        $this->dependencies['Encrypt']      = $options;
        $this->dependencies['Fieldhandler'] = $options;
        $this->dependencies['Flashmessage'] = $options;
        $this->dependencies['Userdata']     = $options;

        return $this->dependencies;
    }

    /**
     * Set Dependencies for Instantiation
     *
     * @return  array
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onBeforeInstantiation(array $dependency_values = null)
    {
        parent::onBeforeInstantiation($dependency_values);

        $this->dependencies['Configuration'] = $this->getConfiguration();

        return $this->dependencies;
    }

    /**
     * Factory Method Controller triggers the Factory Method to create the Class for the Service
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        $class = $this->product_namespace;

        $this->product_result = new $class(
            $this->dependencies['Userdata'],
            $this->options['Session'],
            $this->options['Cookie'],
            $this->dependencies['Mailer'],
            $this->options['Messages'],
            $this->dependencies['Encrypt'],
            $this->dependencies['Fieldhandler'],
            $this->dependencies['Configuration'],
            $_SERVER,
            $_POST,
            session_id()
        );

        return $this;
    }

    /**
     * Process Authenticate:
     *
     *  isGuest
     *  login
     *  isLoggedOn
     *  changePassword,
     *  requestPasswordReset
     *  logout
     *  register
     *  confirmRegistration
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onAfterInstantiation()
    {
        $results = $this->{$this->options['action']}();

        if (is_object($results)) {
            $this->redirect($results);

        } else {
            $this->options['id'] = (int)$results;
        }

        return $this;
    }

    /**
     * Request for array of Factory Methods to be Scheduled
     *
     * @return  $this
     * @since   1.0.0
     */
    public function scheduleFactories()
    {
        if (isset($this->schedule_factory_methods['redirect'])) {

        } else {
            $options                 = array();
            $options['id']           = $this->options['id'];
            $options['Userdata']     = $this->dependencies['Userdata'];
            $options['Session']      = $this->options['Session'];
            $options['Flashmessage'] = $this->dependencies['Flashmessage'];
            $options['Cookie']       = $this->options['Cookie'];
            $options['Runtimedata']  = $this->dependencies['Runtimedata'];

            $this->schedule_factory_methods['Instantiateuser'] = $options;
        }

        return $this->schedule_factory_methods;
    }

    /**
     * Get Configuration
     *
     * @return  object
     * @since   1.0.0
     */
    protected function getConfiguration()
    {
        $configuration                                          = new stdClass();
        $configuration->authentication_types                    = array('database');
        $configuration->from_email_address                      = true;
        $configuration->from_email_name                         = true;
        $configuration->max_login_attempts                      = 10;
        $configuration->password_alpha_character_required       = false;
        $configuration->password_expiration_days                = 0;
        $configuration->password_lock_out_days                  = 1;
        $configuration->password_minimum_password_length        = 5;
        $configuration->password_maximum_password_length        = 50;
        $configuration->password_mixed_case_required            = false;
        $configuration->password_must_not_match_last_password   = true;
        $configuration->password_must_not_match_username        = false;
        $configuration->password_numeric_character_required     = false;
        $configuration->password_send_email_for_password_blocks = false;
        $configuration->password_special_character_required     = false;
        $configuration->password_email_address_as_username      = false;
        $configuration->session_expires_minutes                 = 30;
        $configuration->site_is_offline                         = false;

        $application_base_url = $this->dependencies['Runtimedata']->application->base_url;

        $configuration->url_for_home           = $application_base_url;
        $configuration->url_to_change_password = $application_base_url . '/' . 'password';
        $configuration->url_to_login           = $application_base_url . '/' . 'login';
        $configuration->url_to_registration    = $application_base_url . '/' . 'registration';

        return $configuration;
    }

    /**
     * Login
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function login()
    {
        return $this->product_result->login(
            $this->options['session_id'],
            $this->options['username'],
            $this->options['password'],
            $this->options['remember']
        );
    }

    /**
     * Is Logged On
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function isLoggedOn()
    {
        return $this->product_result->isLoggedOn(
            $this->options['session_id'],
            $this->options['username']
        );
    }

    /**
     * Change Password
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function changePassword()
    {
        return $this->product_result->changePassword(
            $this->options['session_id'],
            $this->options['username'],
            $this->options['password'],
            $this->options['new_password'],
            $this->options['reset_password_code'],
            $this->options['remember']
        );
    }

    /**
     * Request Password Reset
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function requestPasswordReset()
    {
        return $this->product_result->requestPasswordReset(
            $this->options['session_id'],
            $this->options['username']
        );
    }

    /**
     * Logout
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function logout()
    {
        return $this->product_result->requestPasswordReset(
            $this->options['session_id'],
            $this->options['username']
        );
    }

    /**
     * Register
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function register()
    {
        return $this->product_result->register(
            $this->options['session_id']
        );
    }

    /**
     * Confirm Registration
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function confirmRegistration()
    {
        return $this->product_result->confirmRegistration(
            $this->options['session_id']
        );
    }

    /**
     * Request for array of Factory Methods to be Scheduled
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function redirect($redirect_object)
    {
        $this->schedule_factory_methods             = array();
        $options                                    = array();
        $options['url']                             = $redirect_object->url;
        $options['status']                          = $redirect_object->code;
        $this->schedule_factory_methods['Redirect'] = $options;

        return $this;
    }

}
