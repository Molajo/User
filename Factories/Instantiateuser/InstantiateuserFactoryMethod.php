<?php
/**
 * Instantiate User Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Instantiateuser;

use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;

/**
 * Instantiate User Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class InstantiateuserFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
    /**
     * Constructor
     *
     * @param  $options
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $options['product_name']             = 'User';
        $options['product_namespace']        = 'Molajo\\User\\Facade';

        parent::__construct($options);
    }

    /**
     * Instantiate a new handler and inject it into the Adapter for the FactoryInterface
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        parent::setDependencies(array());

        $this->dependencies = array();

        return $this->dependencies;

        $options                 = array();
        $options['id']           = $this->options['id'];
        $options['Userdata']     = $this->options['Userdata'];
        $options['Session']      = $this->options['Session'];
        $options['Flashmessage'] = $this->dependencies['Flashmessage'];
        $options['Cookie']       = $this->options['Cookie'];
        $options['Runtimedata']  = $this->dependencies['Runtimedata'];

        $this->schedule_factory_methods['Instantiateuser'] = $options;
    }


    /**
     * Factory Method Controller triggers the Factory Method to create the Class for the Service
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        $class = $this->product_namespace;

        $this->product_result = new $class(
            $userdata = $this->options['Userdata'],
            $session = $this->options['Session'],
            $flashmessage = $this->options['Flashmessage'],
            $cookie = $this->options['Cookie'],
            $activity = $this->options['Activity']
        );

        return $this;
    }

    /**
     * Factory Method Controller requests any Products (other than the current product) to be saved
     *
     * @return  array
     * @since   1.0
     */
    public function setContainerEntries()
    {
        $this->options['Runtimedata']->user = $this->sortObject($this->product_result->getUserdata());

        $this->set_container_entries['Runtimedata'] = $this->options['Runtimedata'];
        $this->set_container_entries['User']        = $this->product_result;

        return $this->set_container_entries;
    }

    /**
     * Request for array of Factory Methods to be Scheduled
     *
     * @return  $this
     * @since   1.0
     */
    public function scheduleFactories()
    {
        $options                                = array();
        $this->schedule_factory_methods['Date'] = $options;

        return $this->schedule_factory_methods;
    }
}
