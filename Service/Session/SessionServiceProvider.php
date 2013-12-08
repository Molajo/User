<?php
/**
 * Session Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Service\Session;

use Molajo\IoC\AbstractServiceProvider;
use CommonApi\IoC\ServiceProviderInterface;

/**
 * Session Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class SessionServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
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
        $options['service_namespace']        = 'Molajo\\User\\Utilities\\Session';

        parent::__construct($options);

        $this->options['session_exception'] = 'Molajo\\User\Exception\\SessionException';
        $this->options['flash_types']       = $this->setFlashTypes();
    }

    /**
     * System Messages for User Subsystem
     *
     * @return  array
     * @since   1.0
     */
    protected function setFlashTypes()
    {
        $flash_types = array('Success', 'Notice', 'Warning', 'Error');
        return $flash_types;
    }
}
