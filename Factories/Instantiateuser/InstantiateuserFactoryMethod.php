<?php
/**
 * User User Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Instantiateuser;

use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryMethodInterface;
use CommonApi\IoC\FactoryMethodBatchSchedulingInterface;
use Molajo\IoC\FactoryBase;

/**
 * User User Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class InstantiateuserFactoryMethod extends FactoryBase implements FactoryMethodInterface, FactoryMethodBatchSchedulingInterface
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
        $options['product_name']      = basename(__DIR__);
        $options['product_namespace'] = 'Molajo\\User\\User';

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

        $this->dependencies['Runtimedata'] = array();

        return $this->dependencies;
    }

    /**
     * Factory Method Controller requests any Products (other than the current product) to be saved
     *
     * @return  array
     * @since   1.0
     */
    public function setContainerEntries()
    {
        $this->dependencies['Runtimedata']->user
                                                     = $this->sortObject($this->product_result->getUserData('*'));
        $this->set_container_entries['Runtimedata']           = $this->dependencies['Runtimedata'];
        $this->set_container_entries['Molajo\Factories\User'] = $this->product_result;

        return $this->set_container_entries;
    }
}
