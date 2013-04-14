<?php
/**
 * User Data Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Data;

defined('MOLAJO') or die;

use Molajo\User\Exception\UserDataException;

/**
 * User Data Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface UserDataInterface
{
    /** Group Constants */
    const GROUP_PUBLIC      = 1,
        GROUP_GUEST         = 2,
        GROUP_REGISTERED    = 3,
        GROUP_ADMINISTRATOR = 6;

    /**
     * Get the current value (or default) of the specified key
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     * @since   1.0
     * @throws  UserDataException
     */
    public function get($key = null, $default = null);

    /**
     * Set the value of a specified key
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     * @since   1.0
     * @throws  UserDataException
     */
    public function set($key, $value = null);

    /**
     * Checks to see that the user is authorised to use this extension
     *
     * @param string $extension_instance_id
     *
     * @return bool
     * @since   1.0
     */
    public function checkAuthorised($extension_instance_id);

    /**
     * Get data for site visitor (user or guest)
     *
     * @returns  void
     * @since    1.0
     * @throws  UserDataException
     */
    public function getUserData();
}
