<?php
/**
 * Session Class
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Session;

defined('MOLAJO') or die;

use Molajo\User\Exception\SessionException;

/**
 * Session Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class Session implements SessionInterface
{
    /**
     * Does session exist?
     *
     * @return  bool
     * @since   1.0
     */
    public function start()
    {
        if (session_id()) {
        } else {
            @session_start();
            return session_id();
        }

        return true;
    }

    /**
     * Returns Session ID
     *
     * @return  string
     * @since   1.0
     * @throws  SessionException
     */
    public function getSessionId()
    {
        if (session_id()) {
        } else {
            $this->start();
        }

        return session_id();
    }

    /**
     * Does session exist?
     *
     * @param   string  $key
     *
     * @return  bool
     * @since   1.0
     */
    public function exists($key)
    {
        if (session_id()) {
        } else {
            $this->getSessionId();
        }

        if (isset($_SESSION[$key])) {
        } else {
            return false;
        }

        return true;
    }

    /**
     * Set session
     *
     * @param   int    $key
     * @param   mixed  $value
     *
     * @return  mixed
     * @since   1.0
     * @throws  SessionException
     */
    public function set($key, $value)
    {
        if (session_id()) {
        } else {
            $this->start();
        }

        $key   = (string)$key;
        $value = serialize($value);

        try {

            // foreach ($parameters as $name => $value) {
            $key            = htmlspecialchars($key);
            $value          = htmlspecialchars($value);
            $_SESSION[$key] = $value;

        } catch (\Exception $e) {

            throw new SessionException
            ('Session Set Error: ' . $e->getMessage());
        }

        return $this;
    }

    /**
     * Gets the value stored in a session
     *
     * @param   int  $key
     *
     * @return  mixed
     * @since   1.0
     * @throws  SessionException
     */
    public function get($key)
    {
        if (session_id()) {
        } else {
            $this->start();
        }

        $key = (string)$key;

        if ($this->exists($key) === true) {
        } else {
            throw new SessionException
            ('Session could not be retrieved for ' . $key);
        }

        $decoded = htmlspecialchars_decode($_SESSION[$key]);

        $value = @unserialize($decoded);

        if ($decoded === false && serialize(false) != $decoded) {
            throw new SessionException
            ('Session could not be retrieved for ' . $key);
        }

        return $value;
    }

    /**
     * Delete a session
     *
     * @param   int  $key
     *
     * @return  mixed
     * @since   1.0
     * @throws  SessionException
     */
    public function delete($key)
    {
        if (session_id()) {
        } else {
            $this->start();
        }

        $key = (string)$key;

        if ($this->exists($key) === true) {
        } else {
            throw new SessionException
            ('Session could not be deleted for ' . $key);
        }

        unset($_SESSION[(string)$key]);

        return $this;
    }

    /**
     * Destroy Session
     *
     * @return  object
     * @since   1.0
     * @throws  SessionException
     */
    public function destroy()
    {
        if (session_id()) {
            session_unset();
            session_destroy();
            $_SESSION = array();
        }

        return $this;
    }
}
