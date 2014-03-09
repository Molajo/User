<?php
/**
 * Encrypt Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Services\Encrypt;

use Exception;
use Molajo\IoC\AbstractServiceProvider;
use CommonApi\IoC\ServiceProviderInterface;
use CommonApi\Exception\RuntimeException;

/**
 * User Encrypt Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class EncryptServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
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
        $options['service_namespace']        = 'Molajo\\User\\Utilities\\Encrypt';

        parent::__construct($options);
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

        $this->dependencies['encrypt_exception'] = 'Exception\\User\\EncryptException';

        return $this;
    }
}
