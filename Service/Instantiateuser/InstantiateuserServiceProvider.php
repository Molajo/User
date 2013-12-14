<?php
/**
 * User User Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Service\Instantiateuser;

use Molajo\IoC\AbstractServiceProvider;
use CommonApi\IoC\ServiceProviderInterface;

/**
 * User User Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class InstantiateuserServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
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
        $options['service_name']      = basename(__DIR__);
        $options['service_namespace'] = 'Molajo\\User\\User';

        parent::__construct($options);
    }

    /**
     * Following Class creation, Service Provider requests the Service Provider Controller set Services in the Container
     *
     * @return  string
     * @since   1.0
     */
    public function setService()
    {
        $set         = array();
        $set['User'] = $this->service_instance;

        return $set;
    }

    /**
     * Schedule the Next Service
     *
     * @return  $this
     * @since   1.0
     */
    public function scheduleServices()
    {
        $options = array();

        $options['User']                         = $this->service_instance;

        $this->schedule_service['Language']      = $options;
        $this->schedule_service['Authorisation'] = $options;

        return $this->schedule_service;
    }
}
