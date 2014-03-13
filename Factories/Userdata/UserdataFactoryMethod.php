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
use CommonApi\IoC\FactoryMethodInterface;
use CommonApi\IoC\FactoryMethodBatchSchedulingInterface;
use Molajo\IoC\FactoryBase;

/**
 * User Data Services
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class UserdataFactoryMethod extends FactoryBase implements FactoryMethodInterface, FactoryMethodBatchSchedulingInterface
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
     * Instantiate a new handler and inject it into the Adapter for the FactoryMethodInterface
     * Retrieve a list of Interface dependencies and return the data ot the controller.
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function setDependencies(array $reflection = null)
    {
        parent::setDependencies($reflection);

        $options                        = array();
        $this->dependencies['Resource'] = $options;

        return $this->dependencies;
    }

    /**
     * Set Dependencies for Instantiation
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function onBeforeInstantiation(array $dependency_values = null)
    {
        parent::onBeforeInstantiation($dependency_values);

        $this->dependencies['default_exception'] = 'Molajo\\User\\Exception\\RuntimeException';
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
        $this->dependencies['default_exception']      = 'Exception\\User\\RuntimeException';

        return $this->dependencies;
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
