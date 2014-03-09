<?php
/**
 * User Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Services\User;

use Molajo\IoC\AbstractServiceProvider;
use CommonApi\IoC\ServiceProviderInterface;
use CommonApi\Exception\RuntimeException;

/**
 * User Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class UserServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
{
    /**
     * Actions Array
     *
     * @var    array
     * @since  1.0
     */
    protected $actions
        = array(
            'register',
            'confirmRegistration',
            'login',
            'requestPasswordReset',
            'changePassword',
            'logout',
            'isGuest',
            'isLoggedOn'
        );

    /**
     * Request Variables
     *
     * @var    array
     * @since  1.0
     */
    protected $request_variables
        = array(
            'action',
            'username',
            'password',
            'remember',
            'return',
            'new_password',
            'reset_password_code',
            'reset_password_code',
            'registration_confirmation_code'
        );

    /**
     * Actions Array
     *
     * @var    array
     * @since  1.0
     */
    protected $registration_actions
        = array(
            'register',
            'confirmRegistration'
        );

    /**
     * Session Variables
     *
     * @var    array
     * @since  1.0
     */
    protected $session_variables
        = array('session_id');

    /**
     * Constructor
     *
     * @param  $options
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $options['service_name']      = basename(__DIR__);
        $options['service_namespace'] = 'Molajo\\User\\User';

        parent::__construct($options);
    }

    /**
     * Define Service Dependencies
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function setDependencies(array $reflection = null)
    {
        // Intentionally not instantiating the class in this service provider
        // Will be created in Instantiateuser
        parent::setDependencies(null);

        $this->dependencies                 = array();
        $options                            = array();
        $this->dependencies['Request']      = $options;
        $this->dependencies['Cookie']       = $options;
        $this->dependencies['Session']      = $options;
        $this->dependencies['Flashmessage'] = $options;
        $this->dependencies['Runtimedata']  = $options;
        $this->dependencies['Resource']     = $options;

        return $this->dependencies;
    }

    /**
     * Set Dependencies
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function onBeforeInstantiation(array $dependency_values = null)
    {
        foreach ($dependency_values as $service => $instance) {
            $this->dependencies[$service] = $instance;
        }

        $query_string = $this->dependencies['Request']->query;

        foreach ($this->request_variables as $variable) {
            if (isset($query_string[$variable])) {
                $this->options[$variable] = $query_string[$variable];
            } else {
                $this->options[$variable] = '';
            }
        }

        // TEST DATA BEGIN
        $this->dependencies['Flashmessage']->deleteFlashMessage();
        $this->dependencies['Session']->setSession(session_id(), 'admin');
        $this->dependencies['Session']->setSession('session_id', session_id());
        $this->dependencies['Session']->setSession('admin', '12345');

        // TEST DATA END
        $this->getSessionInput();

        // TEST DATA BEGIN

        $this->options['username']     = 'admin';
        $this->options['password']     = 'Gemma*2013';
        $this->options['new_password'] = '';
        $this->options['remember']     = '';
        $this->options['action']       = 'login';

        return $this;
    }

    /**
     * Service Provider Controller triggers the Service Provider to create the Class for the Service
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function instantiateService()
    {
        $this->service_instance = null;
    }

    /**
     * Get Session Data
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function getSessionInput()
    {
        $session_id                  = $this->dependencies['Session']->getSession('session_id');
        $this->options['session_id'] = $session_id;
        if ($this->options['action'] == 'login'
            || $this->options['action'] == 'changePassword'
            || $this->options['action'] == 'requestPasswordReset'
            || $this->options['action'] == 'logout'
            || $this->options['action'] == 'register'
            || $this->options['action'] == 'confirmRegistration'
        ) {
        } else {

            $this->options['password']                       = '';
            $this->options['remember']                       = '';
            $this->options['return']                         = '';
            $this->options['reset_password_code']            = '';
            $this->options['registration_confirmation_code'] = '';
            $this->options['username']                       = $this->dependencies['Session']->getSession($session_id);
            if ($this->options['username'] == false) {
                $this->options['action']   = 'isGuest';
                $this->options['username'] = '';
            } else {
                $this->options['action'] = 'isLoggedOn';
            }
        }
    }

    /**
     * Schedule the Next Service
     *
     * @return  $this
     * @since   1.0
     */
    public function scheduleServices()
    {
        $options = array();
        foreach ($this->options as $key => $value) {
            $options[$key] = $value;
        }
        $options['registration_actions']    = $this->registration_actions;
        $this->schedule_services['Userdata'] = $options;

        return $this->schedule_services;
    }
}
