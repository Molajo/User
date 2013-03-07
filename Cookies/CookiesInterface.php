<?php
/**
 * Cookies Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Cookies;

defined('MOLAJO') or die;

/**
 * Cookies Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface CookiesInterface
{
    /**
     * Does cookie exist?
     *
     * @param   string  $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function exists($key);

    /**
     * Set Cookie Parameters
     *
     * @param   array  $parameters Configuration Values
     *
     * @return  mixed
     * @since   1.0
     */
    public function setCookieParameters(array $parameters);

    /**
     * Gets the value stored in a cookie
     *
     * @param   int  $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function get($key);

    /**
     * Set Cookie
     *
     * @param   int    $key
     * @param   mixed  $value
     * @param   array  $parameters
     *
     * @return  mixed
     * @since   1.0
     */
    public function set($key, $value);

    /**
     * Delete a cookie
     *
     * @param   int  $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function delete($key);
}
