<?php
/**
 * Cookie
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\User;

use stdClass;
use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\User\CookieInterface;

/**
 * Cookie Class
 *
 * @see        setCookie()
 * @link       http://www.faqs.org/rfcs/rfc6265.html
 * @link       http://www.php.net//manual/en/function.setcookie.php
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Cookie implements CookieInterface
{
    /**
     * Cookies
     *
     * @var    array
     * @since  1.0
     */
    protected $cookies;

    /**
     * Expire
     *
     * @var    string
     * @since  1.0
     */
    protected $expire = 2628000;

    /**
     * Path
     *
     * @var    string
     * @since  1.0
     */
    protected $path = null;

    /**
     * Domain
     *
     * @var    string
     * @since  1.0
     */
    protected $domain = '';

    /**
     * Secure
     *
     * @var    bool
     * @since  1.0
     */
    protected $secure = false;

    /**
     * Http Only
     *
     * @var    bool
     * @since  1.0
     */
    protected $http_only = false;

    /**
     * Property Array
     *
     * @var    array
     * @since  1.0
     */
    protected $property_array
        = array(
            'expire',
            'path',
            'domain',
            'secure',
            'http_only'
        );

    /**
     * Construct
     *
     * @param   array   $cookies
     * @param   int     $expire
     * @param   null    $path
     * @param   null    $domain
     * @param   int     $secure
     * @param   boolean $http_only
     *
     * @since   1.0
     */
    public function __construct(
        array $cookies = array(),
        $expire = 2628000,
        $path = null,
        $domain = null,
        $secure = 0,
        $http_only = false
    ) {
        $this->initializeCookies($cookies);
        $this->initializeExpiration($expire);
        $this->initializePath($path);
        $this->initializeDomain($domain);
        $this->initializeSecure($secure);
        $this->initializeHttpOnly($http_only);
    }

    /**
     * Get an HTTP Cookie
     *
     * @param           $name
     *
     * @link    http://www.faqs.org/rfcs/rfc6265.html
     * @return  $this
     * @since   1.0
     */
    public function getCookie($name)
    {
        if (isset($this->cookies[$name])) {
            return $this->cookies[$name];
        }

        return false;
    }

    /**
     * Sets an HTTP Cookie to be sent with the HTTP response
     *
     * @param           $name
     * @param   null    $value
     * @param   int     $minutes
     * @param   string  $path
     * @param   string  $domain
     * @param   boolean $secure
     * @param   boolean $http_only
     *
     * @return  $this
     * @since   1.0
     */
    public function setCookie(
        $name,
        $value = null,
        $minutes = 0,
        $path = '/',
        $domain = '',
        $secure = false,
        $http_only = false
    ) {
        $cookie            = new stdClass();
        $cookie->name      = $name;
        $cookie->value     = $value;
        $cookie->expire    = $this->setCookieTime($minutes);
        $cookie->path      = $this->setCookiePath($path);
        $cookie->domain    = $this->setCookieDomain($domain);
        $cookie->secure    = $this->setCookieSecure($secure);
        $cookie->http_only = $this->setCookieHttpOnly($http_only);

        $this->cookies[$name] = $cookie;

        return $this;
    }

    /**
     * Set Cookie Time
     *
     * @param   integer $minutes
     *
     * @return  integer
     * @since   1.0
     */
    protected function setCookieTime($minutes)
    {
        if ($minutes == 0) {
            $minutes = $this->expire / 24;
        }

        $expire = time() + $minutes;

        return $expire;
    }

    /**
     * Set Cookie Path
     *
     * @param   string $path
     *
     * @return  string
     * @since   1.0
     */
    protected function setCookiePath($path)
    {
        if ($path == '') {
            $path = $this->path;
        }

        return $path;
    }

    /**
     * Set Cookie Domain
     *
     * @param   string $domain
     *
     * @return  string
     * @since   1.0
     */
    protected function setCookieDomain($domain)
    {
        if ($domain == '') {
            $domain = $this->domain;
        }

        return $domain;
    }

    /**
     * Set Cookie Secure
     *
     * @param   null|boolean $secure
     *
     * @return  boolean
     * @since   1.0
     */
    protected function setCookieSecure($secure = null)
    {
        if ($secure === null) {
            $secure = $this->secure;
        }

        return $secure;
    }

    /**
     * Set Cookie Http Only
     *
     * @param   null|boolean $http_only
     *
     * @return  boolean
     * @since   1.0
     */
    protected function setCookieHttpOnly($http_only = null)
    {
        if ($http_only === null) {
            $http_only = $this->http_only;
        }

        return $http_only;
    }

    /**
     * Delete a cookie
     *
     * @param   string $name
     *
     * @return  boolean
     * @since   1.0
     */
    public function deleteCookie($name)
    {
        $name = (string)$name;

        if (isset($this->cookies[$name])) {
            unset($this->cookies[$name]);
            return true;
        }

        return false;
    }

    /**
     * Destroy Cookies
     *
     * @return  $this
     * @since   1.0
     */
    public function destroyCookies()
    {
        $this->cookies = array();

        return $this;
    }

    /**
     * sendCookies
     *
     * @return  $this
     * @since   1.0
     * @throws  RuntimeException
     */
    public function sendCookies()
    {
        if (count($this->cookies) === 0) {
            return $this;
        }

        foreach ($this->cookies as $cookie) {
            $this->sendCookie($cookie);
        }

        return $this;
    }

    /**
     * sendCookie
     *
     * @param   object $cookie
     *
     * @return  $this
     * @since   1.0
     * @throws  RuntimeException
     */
    protected function sendCookie($cookie)
    {
        try {
            setcookie(
                $cookie->name,
                $cookie->value,
                $cookie->expire,
                $cookie->path,
                $cookie->domain,
                $cookie->secure,
                $cookie->http_only
            );
        } catch (Exception $e) {
            throw new RuntimeException(
                'Cookie Response: sendCookie failed for : ' . $cookie->name . ' ' . $e->getMessage()
            );
        }

        return $this;
    }

    /**
     * Initialize Request Cookies
     *
     * @param   array $cookies
     *
     * @return  $this
     * @since   1.0
     */
    protected function initializeCookies(array $cookies)
    {
        if (is_array($cookies)) {
            $this->cookies = $cookies;
        } else {
            $this->cookies = array();
        }

        return $this;
    }

    /**
     * Initialize Expiration Time for Cookies
     *
     * @param   integer $expire
     *
     * @return  $this
     * @since   1.0
     */
    protected function initializeExpiration($expire)
    {
        if ($expire === null) {
            $expire = 2628000;
        }

        $this->expire = $expire;

        return $this;
    }

    /**
     * Initialize Path for Cookies
     *
     * @param   string $path
     *
     * @return  $this
     * @since   1.0
     */
    protected function initializePath($path)
    {
        if ($path === null) {
            $path = '';
        }

        $this->path = $path;

        return $this;
    }

    /**
     * Initialize Domain for Cookies
     *
     * @param   string $domain
     *
     * @return  $this
     * @since   1.0
     */
    protected function initializeDomain($domain)
    {
        if ($domain === null) {
            $domain = '';
        }

        $this->domain = $domain;

        return $this;
    }

    /**
     * Initialize Security Protocol for Cookies
     *
     * @param   null|boolean $secure
     *
     * @return  $this
     * @since   1.0
     */
    protected function initializeSecure($secure = null)
    {
        if ($secure === null) {
            $secure = false;
        }

        $this->secure = $secure;

        return $this;
    }

    /**
     * Initialize Http Only Setting for Cookies
     *
     * @param   string $secure
     *
     * @return  $this
     * @since   1.0
     */
    protected function initializeHttpOnly($http_only)
    {
        if ($http_only === true) {
        } else {
            $this->http_only = false;
        }

        return $this;
    }
}
