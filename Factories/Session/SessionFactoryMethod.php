<?php
/**
 * Session Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Session;

use CommonApi\IoC\FactoryBatchInterface;
use CommonApi\IoC\FactoryInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;

/**
 * Session Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class SessionFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
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
        $options['product_namespace']        = 'Molajo\\User\\Session';

        parent::__construct($options);
    }


    /**
     * Process Authenticate: isGuest, login, isLoggedOn, changePassword,
     *   requestPasswordReset, logout, register, confirmRegistration
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onAfterInstantiation()
    {
        $this->product_result->startSession();
    }
}
