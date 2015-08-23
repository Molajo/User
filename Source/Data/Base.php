<?php
/**
 * Abstract Base Class for User Data
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Data;

/**
 * Abstract Base Class for User Data
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Base
{
    /**
     * User Group Constants
     *
     * @since  1.0.0
     */
    const GROUP_ADMINISTRATOR = 1;
    const GROUP_PUBLIC = 2;
    const GROUP_GUEST = 3;
    const GROUP_REGISTERED = 4;

    /**
     * User Object
     *
     * @var    object  CommonApi\Query\QueryInterface
     * @since  1.0.0
     */
    protected $user;

    /**
     * User Child Objects
     *
     * @var    array
     * @since  1.0.0
     */
    protected $child_objects = array();
}
