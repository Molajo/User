<?php
/**
 * User FlashMessage Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Service\Flashmessage;

use Molajo\IoC\AbstractServiceProvider;
use CommonApi\IoC\ServiceProviderInterface;
use CommonApi\Exception\RuntimeException;

/**
 * FlashMessage Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class FlashmessageServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
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
        $options['service_name']             = basename(__DIR__);
        $options['store_instance_indicator'] = true;
        $options['service_namespace']        = 'Molajo\\User\\Utilities\\FlashMessage';

        parent::__construct($options);
    }

    /**
     * Define Dependencies for Service
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function setDependencies(array $reflection = null)
    {
        parent::setDependencies($reflection);

        $options                         = array();
        $this->dependencies['Resources'] = $options;
        return $this->dependencies;
    }

    /**
     * Set Dependencies for Instantiation
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function processFulfilledDependencies(array $dependency_instances = null)
    {
        parent::processFulfilledDependencies($dependency_instances);

        $this->dependencies['flash_message_exception'] = 'Molajo\\User\Exception\\FlashMessageException';
        $this->dependencies['flash_types']             = $this->setFlashTypes();

        return $this->dependencies;
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