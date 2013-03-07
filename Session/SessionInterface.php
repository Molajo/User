<?php
/**
 * Session Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Session;

defined('MOLAJO') or die;

/**
 * Session Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface SessionInterface
{
    /**
     * Start Session
     *
     * @return  object
     * @since   1.0
     */
    public function start();

    /**
     * Gets the value of Session Id
     *
     * @return  mixed
     * @since   1.0
     */
    public function getSessionId();

    /**
     * Gets the value of Session Name
     *
     * @return  mixed
     * @since   1.0
     */
    public function getSessionName();

    /**
     * Gets the value of Session Name
     *
     * @param   string  $name
     *
     * @return  mixed
     * @since   1.0
     */
    public function setSessionName($name);

    /**
     * Does session exist?
     *
     * @param   string  $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function exists($key);

    /**
     * Set session
     *
     * @param   int    $key
     * @param   mixed  $value
     *
     * @return  mixed
     * @since   1.0
     */
    public function set($key, $value);

    /**
     * Gets the value stored in a session
     *
     * @param   int  $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function get($key);

    /**
     * CSRF Token create and validate
     *
     * @param   int     $key
     * @param   string  $request_method
     * @param   string  $request_key
     *
     * @return  mixed
     * @since   1.0
     */
    public function token($key, $request_method, $request_key);

    /**
     * Delete a session
     *
     * @param   int  $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function delete($key);

    /**
     * Destroy Session
     *
     * @return  mixed
     * @since   1.0
     */
    public function destroy();
}
