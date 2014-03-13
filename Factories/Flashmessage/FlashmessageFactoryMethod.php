<?php
/**
 * User FlashMessage Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Flashmessage;

use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryMethodInterface;
use CommonApi\IoC\FactoryMethodBatchSchedulingInterface;
use Molajo\IoC\FactoryBase;

/**
 * FlashMessage Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class FlashmessageFactoryMethod extends FactoryBase implements FactoryMethodInterface, FactoryMethodBatchSchedulingInterface
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
        $options['product_namespace']        = 'Molajo\\User\\Utilities\\FlashMessage';

        parent::__construct($options);
    }

    /**
     * Factory Method Controller triggers the Factory Method to create the Class for the Service
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function instantiateClass()
    {
        $class = $this->product_namespace;

        $this->product_result = new $class(
            $session = $this->dependencies['Session'],
            $flash_types = $this->setFlashTypes(),
            $flash_message_exception = 'Molajo\\User\Exception\\FlashMessageException'
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
