<?php
/**
 * User Data Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Userdata;

use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryBatchInterface;
use CommonApi\IoC\FactoryInterface;
use Exception;
use Molajo\IoC\FactoryMethodBase;

/**
 * User Data Services
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class UserdataFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
    /**
     * Constructor
     *
     * @param  array $options
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $options['product_name']             = basename(__DIR__);
        $options['store_instance_indicator'] = true;
        $options['product_namespace']        = 'Molajo\\User\\UserData';

        parent::__construct($options);
    }

    /**
     * Instantiate a new handler and inject it into the Adapter for the FactoryInterface
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = null)
    {
        parent::setDependencies(null);

        $options                        = array();
        $this->dependencies['Database'] = $options;
        $this->dependencies['Resource'] = $options;
        $this->dependencies['Query2']    = $options;

        return $this->dependencies;
    }

    /**
     * Set Dependencies for Instantiation
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onBeforeInstantiation(array $dependency_values = null)
    {
        parent::onBeforeInstantiation($dependency_values);

        $this->dependencies['model_registry']    =
            $this->dependencies['Resource']->get('xml:///Molajo//Model//Datasource//User.xml');

        $xml = $this->dependencies['model_registry']['children'];

        $children = array();
        if (is_array($xml) && count($xml) > 0) {
            foreach ($xml as $child) {
                $name                 = (string)$child['name'];
                $name                 = ucfirst(strtolower($name));
                $child_model_registry = 'xml:///Molajo//Model//Datasource//' . $name . '.xml';
                $children[$name]      = $this->dependencies['Resource']->get($child_model_registry);
            }
        }

        $this->dependencies['child_model_registries'] = $children;

        return $this->dependencies;
    }


    /**
     * Instantiate Class
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        $class = $this->product_namespace;

        try {
            $this->product_result = new $class (
                $this->dependencies['Database'],
                $this->dependencies['Query2'],
                $this->dependencies['model_registry'],
                $this->dependencies['child_model_registries']
            );
        } catch (Exception $e) {
            throw new RuntimeException
            ('Molajito: Could not instantiate Driver Class: ' . $class);
        }
    }


    /**
     * Process Authenticate: isGuest, login, isLoggedOn, changePassword,
     *   requestPasswordReset, logout, register, confirmRegistration
     *
     * @return  $this
     * @since   1.0
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

        $this->product_result->load($value, $key);

        return $this;
    }

    /**
     * Request for array of Factory Methods to be Scheduled
     *
     * @return  $this
     * @since   1.0
     */
    public function scheduleFactories()
    {
        $options = array();
        foreach ($this->options as $key => $value) {
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
