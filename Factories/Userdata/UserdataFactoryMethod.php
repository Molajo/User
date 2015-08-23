<?php
/**
 * User Data Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Userdata;

use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryBatchInterface;
use CommonApi\IoC\FactoryInterface;
use Exception;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;

/**
 * User Data Services
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class UserdataFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
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
        $options['product_namespace']        = 'Molajo\\User\\Userdata';

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
        parent::setDependencies($reflection);

        $this->dependencies['Resource']     = array();
        $this->dependencies['Runtimedata']  = array();
        $this->dependencies['Fieldhandler'] = array();

        return $this->dependencies;
    }

    /**
     * Instantiate Class
     *
     * @return  object
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        try {
            $this->product_result = new $this->product_namespace(
                $this->dependencies['Resource'],
                $this->dependencies['Fieldhandler'],
                $this->dependencies['Runtimedata']
            );

        } catch (Exception $e) {

            throw new RuntimeException (
                'IoC Factory Method Adapter Instance Failed for ' . $this->product_namespace
                . ' failed.' . $e->getMessage()
            );
        }

        return $this;
    }

    /**
     * Process Authenticate: isGuest, login, isLoggedOn, changePassword,
     *   requestPasswordReset, logout, register, confirmRegistration
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onAfterInstantiation()
    {
        $key   = null;
        $value = null;

        if (isset($this->options['id'])) {
            $key   = 'id';
            $value = $this->options['id'];

        } elseif (isset($this->options['email'])) {
            $key   = 'email';
            $value = $this->options['email'];

        } elseif (isset($this->options['username'])) {
            $key   = 'username';
            $value = $this->options['username'];
        }

        $this->product_result->load($key, $value);

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
        $x = $this->options;

        unset($x['ioc_id']);
        unset($x['factory_method_namespace']);
        unset($x['product_namespace']);

        $options = array();
        foreach ($x as $key => $value) {
            $options[$key] = $value;
        }

        if (in_array($this->options['action'], $this->options['registration_actions'])) {
            $this->schedule_factory_methods['Registration'] = $options;
        } else {
            $this->schedule_factory_methods['Authentication'] = $options;
        }

        return $this->schedule_factory_methods;
    }
}
