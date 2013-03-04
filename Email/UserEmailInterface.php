<?php
/**
 * User Email Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Email;

defined('MOLAJO') or die;

/**
 * Email Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface UserEmailInterface
{
    /**
     * Set parameter Value
     *
     * @param   string  $key
     * @param   null    $value
     *
     * @return  mixed
     * @throws  AuthorisationException
     * @since   1.0
     */
    public function set($key, $value = null);

    /**
     * Get parameters value
     *
     * @param   string  $key
     * @param   null    $value
     *
     * @return  mixed
     * @throws  AuthorisationException
     * @since   1.0
     */
    public function get($key, $default = null);

    /**
     * Send email
     *
     * @return  mixed
     * @throws  AuthorisationException
     * @since   1.0
     */
    public function send();
}
