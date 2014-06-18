<?php
/**
 * Session Class
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User;

use CommonApi\User\SessionInterface;

/**
 * Session Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Session implements SessionInterface
{
    /**
     * Start the Session
     *
     * @return  string
     * @since   1.0
     */
    public function startSession()
    {
        if (session_id()) {
            return session_id();
        }

        session_start();

        return session_id();
    }

    /**
     * Gets the session value for the specified key
     *
     * @param   string $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function getSession($key)
    {
        $key = (string)$key;

        if ($key === 'session_id') {
            return session_id();
        }

        if (isset($_SESSION[$key])) {
            return unserialize($_SESSION[$key]);
        }

        return false;
    }

    /**
     * Sets the value for key
     *
     * @param   string $key
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0
     */
    public function setSession($key, $value)
    {
        $key   = (string)$key;
        $value = serialize($value);

        $_SESSION[$key] = $value;

        return $this;
    }

    /**
     * Delete a session key
     *
     * @param   string $key
     *
     * @return  Session
     * @since   1.0
     */
    public function deleteSession($key)
    {
        $key = (string)$key;

        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }

        return $this;
    }

    /**
     * Destroy Session, including all key values and session id
     *
     * @return  object
     * @since   1.0
     */
    public function destroySession()
    {
        if (session_id()) {
            session_unset();
            session_destroy();
            $_SESSION = null;
            session_write_close();
        }
    }
}
