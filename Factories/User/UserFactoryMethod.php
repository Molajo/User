<?php
/**
 * User Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\User;

use CommonApi\IoC\FactoryBatchInterface;
use CommonApi\IoC\FactoryInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;

/**
 * User Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class UserFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
    /**
     * Actions Array
     *
     * @var    array
     * @since  1.0.0
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
     * @since  1.0.0
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
     * @since  1.0.0
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
     * @since  1.0.0
     */
    protected $session_variables
        = array('session_id');

    /**
     * Constructor
     *
     * @param  $options
     *
     * @since  1.0.0
     */
    public function __construct(array $options = array())
    {
        $options['product_name']      = basename(__DIR__);
        $options['product_namespace'] = null;

        parent::__construct($options);
    }

    /**
     * Define Service Dependencies
     *
     * @return  array
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        // Intentionally not instantiating the class in this factory
        // It will be created later in Instantiateuser
        parent::setDependencies(array());

        $this->dependencies                 = array();
        $options                            = array();
        $this->dependencies['Request']      = $options;
        $this->dependencies['Cookie']       = $options;
        $this->dependencies['Session']      = $options;
        $this->dependencies['Flashmessage'] = $options;
        $this->dependencies['Runtimedata']  = $options;
        $this->dependencies['Resource']     = $options;
        $this->dependencies['Messages']     = $options;
        $this->dependencies['Mailer']       = $options;

        return $this->dependencies;
    }

    /**
     * Set Dependencies
     *
     * @return  array
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onBeforeInstantiation(array $dependency_values = null)
    {
        foreach ($dependency_values as $request => $instance) {
            $this->dependencies[$request] = $instance;
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
        $this->dependencies['Flashmessage']->deleteFlashmessage();

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
     * Get Session Data
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getSessionInput()
    {
        $session_id = $this->dependencies['Session']->getSession('session_id');

        $this->options['session_id'] = $session_id;

        if ($this->options['action'] === 'login'
            || $this->options['action'] === 'changePassword'
            || $this->options['action'] === 'requestPasswordReset'
            || $this->options['action'] === 'logout'
            || $this->options['action'] === 'register'
            || $this->options['action'] === 'confirmRegistration'
        ) {

        } else {

            $this->options['password']                       = '';
            $this->options['remember']                       = '';
            $this->options['return']                         = '';
            $this->options['reset_password_code']            = '';
            $this->options['registration_confirmation_code'] = '';
            $this->options['username']
                                                             = $this->dependencies['Session']->getSession($session_id);
            if ($this->options['username'] === false) {
                $this->options['action']   = 'isGuest';
                $this->options['username'] = '';
            } else {
                $this->options['action'] = 'isLoggedOn';
            }
        }
    }

    /**
     * Request for array of Factory Methods to be Scheduled
     *
     * @return  $this
     * @since   1.0.0
     */
    public function scheduleFactories()
    {
        $x = $this->options;
        unset($x['ioc_id']);
        unset($x['factory_method_namespace']);
        unset($x['product_namespace']);

        $options = array();
        foreach ($x as $key => $value) {
            $options[$key] = $value;
        }

        foreach ($this->dependencies as $key => $value) {
            $options[$key] = $value;
        }

        $options['registration_actions'] = $this->registration_actions;

        $this->schedule_factory_methods['Userdata'] = $options;

        return $this->schedule_factory_methods;
    }
}
