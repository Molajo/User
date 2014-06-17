<?php
/**
 * Flashmessage Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Flashmessage;

use CommonApi\IoC\FactoryBatchInterface;
use CommonApi\IoC\FactoryInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;

/**
 * Flashmessage Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class FlashmessageFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
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
        $options['product_namespace']        = 'Molajo\\User\\Flashmessage';

        parent::__construct($options);
    }

    /**
     * Define Service Dependencies
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        // Intentionally not instantiating the class in this service provider
        // Will be created in Instantiateuser
        parent::setDependencies(array());

        $this->dependencies            = array();
        $this->dependencies['Session'] = array();

        return $this->dependencies;
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
            $session = $this->dependencies['Session'],
            $flash_types = $this->setFlashTypes(),
            $flash_message_exception = 'Molajo\\User\Exception\\FlashmessageException'
        );
    }

    /**
     * Types for Flash Messages
     *
     * @return  array
     * @since   1.0
     */
    protected function setFlashTypes()
    {
        //todo Translations
        $flash_types = array('Success', 'Notice', 'Warning', 'Error');
        return $flash_types;
    }
}
