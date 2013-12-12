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
     * Service Provider Controller triggers the Service Provider to create the Class for the Service
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function instantiateService()
    {
        $class = $this->service_namespace;

        $this->service_instance = new $class(
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
