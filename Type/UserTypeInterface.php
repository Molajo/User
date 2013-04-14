<?php
/**
 * User Type Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Type;

defined('MOLAJO') or die;

use Molajo\User\Exception\UserTypeException;

/**
 * User Type Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface UserTypeInterface
{
    /**
     * Retrieve User Information (both authenticated and guest)
     *
     * @return void
     * @since   1.0
     */
    public function initialise();

    /**
     * Get the current value (or default) of the specified key
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     * @since   1.0
     * @throws  UserTypeException
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
     * @throws  UserTypeException
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
     * @throws  RuntimeException
     */
    public function getUserData($key, $value = null);
}
