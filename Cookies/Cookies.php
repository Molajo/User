<?php
/**
 * Cookies Class
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Cookies;

defined('MOLAJO') or die;

use Molajo\User\Exception\CookiesException;

/**
 * Cookies Class
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class Cookies implements CookiesInterface
{
    /**
     * Does cookie exist?
     *
     * @param   string  $key
     *
     * @return  bool
     * @since   1.0
     */
    public function exists($key)
    {
        if (isset($_COOKIE[$key])) {
        } else {
            return false;
        }

        return true;
    }

    /**
     * Set Cookie Parameters
     *
     * @param   int    $key
     * @param   mixed  $value
     * @param   array  $parameters
     *
     * @return  mixed
     * @since   1.0
     * @throws  CookiesException
     */
    public function setCookieParameters(array $parameters)
    {
        $parameters = session_get_cookie_params();

        $expire = 0;
        if (isset($parameters['expire'])) {
            $expire = $parameters['expire'];
        }
        if ($expire === 0) {
            $expire = 365 * 24 * 60 * 60;
        }
        $expire               = time() + $expire;
        $parameters['expire'] = $expire;

        $path = '';
        if (isset($parameters['path'])) {
            $path = $parameters['path'];
        }
        $path = (string)$path;
        if ($path == '/') {
            $path = '/';
        }
        $parameters['path'] = $path;

        $domain = null;
        if (isset($parameters['domain'])) {
            $domain = $parameters['domain'];
        }
        $domain               = (string)$domain;
        $parameters['domain'] = $domain;

        $secure = 0;
        if (isset($parameters['secure'])) {
            $secure = $parameters['secure'];
        }
        $secure               = (bool)$secure;
        $parameters['secure'] = $secure;

        $httponly = 0;
        if (isset($parameters['httponly'])) {
            $httponly = (bool)$parameters['httponly'];
        }
        $parameters['httponly'] = $httponly;

        try {

            session_set_cookie_params(
                $parameters['lifetime'],
                $parameters['path'],
                $parameters['domain'],
                $parameters['secure'],
                $parameters['httponly']
            );

        } catch (\Exception $e) {

            throw new CookiesException
            ('Cookie Set Error: ' . $e->getMessage());
        }

        return $this;
    }

    /**
     * Set cookie
     *
     * @param   int    $key
     * @param   mixed  $value
     * @param   array  $parameters
     *
     * @return  mixed
     * @since   1.0
     * @throws  CookiesException
     */
    public function set($key, $value)
    {
        $key   = (string)$key;
        $value = serialize($value);

        try {

            $key   = htmlspecialchars($key);
            $value = htmlspecialchars($value);

            $_COOKIE[$key] = $value;

        } catch (\Exception $e) {

            throw new CookiesException
            ('Cookie Set Error: ' . $e->getMessage());

        }

        return $this;
    }

    /**
     * Gets the value stored in a cookie
     *
     * @param   int  $key
     *
     * @return  mixed
     * @since   1.0
     * @throws  CookiesException
     */
    public function get($key)
    {
        $key = (string)$key;

        if ($this->exists($key) === true) {
        } else {
            throw new CookiesException
            ('Cookie could not be retrieved for ' . $key);
        }

        $decoded = htmlspecialchars_decode($_COOKIE[$key]);

        $value = @unserialize($decoded);

        if ($decoded === false && serialize(false) != $decoded) {
            throw new CookiesException
            ('Cookie could not be retrieved for ' . $key);
        }

        return $value;
    }

    /**
     * Delete a cookie
     *
     * @param   int  $key
     *
     * @return  mixed
     * @since   1.0
     * @throws  CookiesException
     */
    public function delete($key)
    {
        $key = (string)$key;

        if ($this->exists($key) === true) {
        } else {
            throw new CookiesException
            ('Cookie could not be deleted for ' . $key);
        }

        unset($_COOKIE[(string)$key]);

        return $this;
    }
}
