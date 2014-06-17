<?php
/**
 * Test User Cookie
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Tests;

use Molajo\User\Cookie;
require_once __DIR__ . '/Files/jsonRead.php';

/**
 * Test User Cookie
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class CookieTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $cookie
     */
    protected $cookie;

    /**
     * @covers  Molajo\User\Cookie::__construct
     * @covers  Molajo\User\Cookie::getCookie
     * @covers  Molajo\User\Cookie::setCookie
     * @covers  Molajo\User\Cookie::setCookieTime
     * @covers  Molajo\User\Cookie::setCookiePath
     * @covers  Molajo\User\Cookie::setCookieDomain
     * @covers  Molajo\User\Cookie::setCookieSecure
     * @covers  Molajo\User\Cookie::setCookieHttpOnly
     * @covers  Molajo\User\Cookie::deleteCookie
     * @covers  Molajo\User\Cookie::destroyCookies
     * @covers  Molajo\User\Cookie::sendCookies
     * @covers  Molajo\User\Cookie::sendCookie
     * @covers  Molajo\User\Cookie::initializeCookies
     * @covers  Molajo\User\Cookie::initializeExpiration
     * @covers  Molajo\User\Cookie::initializePath
     * @covers  Molajo\User\Cookie::initializeDomain
     * @covers  Molajo\User\Cookie::initializeSecure
     * @covers  Molajo\User\Cookie::initializeHttpOnly
     */
    public function setUp()
    {
        $this->cookie = new Cookie();

        return;
    }

    /**
     * @covers  Molajo\User\Cookie::__construct
     * @covers  Molajo\User\Cookie::getCookie
     * @covers  Molajo\User\Cookie::setCookie
     * @covers  Molajo\User\Cookie::setCookieTime
     * @covers  Molajo\User\Cookie::setCookiePath
     * @covers  Molajo\User\Cookie::setCookieDomain
     * @covers  Molajo\User\Cookie::setCookieSecure
     * @covers  Molajo\User\Cookie::setCookieHttpOnly
     * @covers  Molajo\User\Cookie::deleteCookie
     * @covers  Molajo\User\Cookie::destroyCookies
     * @covers  Molajo\User\Cookie::sendCookies
     * @covers  Molajo\User\Cookie::sendCookie
     * @covers  Molajo\User\Cookie::initializeCookies
     * @covers  Molajo\User\Cookie::initializeExpiration
     * @covers  Molajo\User\Cookie::initializePath
     * @covers  Molajo\User\Cookie::initializeDomain
     * @covers  Molajo\User\Cookie::initializeSecure
     * @covers  Molajo\User\Cookie::initializeHttpOnly
     */
    public function testSetGetCookie()
    {
        $name = 'Cookie name';
        $value = '@covers  Molajo\User\Cookie::initializeHttpOnly';
        $minutes = 1;
        $minutes_test = time() + 1;
        $path = '/';
        $domain = '';
        $secure = false;
        $http_only = false;

        $this->cookie->setCookie($name, $value, $minutes, $path, $domain, $secure, $http_only);

        $cookie = $this->cookie->getCookie($name);

        $this->assertEquals($name, $cookie->name);
        $this->assertEquals($value, $cookie->value);
        $this->assertEquals($minutes_test, $cookie->expire);
        $this->assertEquals($path, $cookie->path);
        $this->assertEquals($domain, $cookie->domain);
        $this->assertEquals($secure, $cookie->secure);
        $this->assertEquals($http_only, $cookie->http_only);
    }

    /**
     * @covers  Molajo\User\Cookie::__construct
     * @covers  Molajo\User\Cookie::getCookie
     * @covers  Molajo\User\Cookie::setCookie
     * @covers  Molajo\User\Cookie::setCookieTime
     * @covers  Molajo\User\Cookie::setCookiePath
     * @covers  Molajo\User\Cookie::setCookieDomain
     * @covers  Molajo\User\Cookie::setCookieSecure
     * @covers  Molajo\User\Cookie::setCookieHttpOnly
     * @covers  Molajo\User\Cookie::deleteCookie
     * @covers  Molajo\User\Cookie::destroyCookies
     * @covers  Molajo\User\Cookie::sendCookies
     * @covers  Molajo\User\Cookie::sendCookie
     * @covers  Molajo\User\Cookie::initializeCookies
     * @covers  Molajo\User\Cookie::initializeExpiration
     * @covers  Molajo\User\Cookie::initializePath
     * @covers  Molajo\User\Cookie::initializeDomain
     * @covers  Molajo\User\Cookie::initializeSecure
     * @covers  Molajo\User\Cookie::initializeHttpOnly
     */
    public function testSetDeleteGetCookie()
    {
        $name = 'Cookie name';
        $value = '@covers  Molajo\User\Cookie::initializeHttpOnly';
        $minutes = 1;
        $minutes_test = time() + 1;
        $path = '/';
        $domain = '';
        $secure = false;
        $http_only = false;

        $this->cookie->setCookie($name, $value, $minutes, $path, $domain, $secure, $http_only);

        $cookie = $this->cookie->getCookie($name);

        $this->assertEquals($name, $cookie->name);
        $this->assertEquals($value, $cookie->value);
        $this->assertEquals($minutes_test, $cookie->expire);
        $this->assertEquals($path, $cookie->path);
        $this->assertEquals($domain, $cookie->domain);
        $this->assertEquals($secure, $cookie->secure);
        $this->assertEquals($http_only, $cookie->http_only);

        $this->cookie->deleteCookie($name);

        $this->assertEquals(false, $this->cookie->getCookie($name));
    }

    /**
     * @covers  Molajo\User\Cookie::__construct
     * @covers  Molajo\User\Cookie::getCookie
     * @covers  Molajo\User\Cookie::setCookie
     * @covers  Molajo\User\Cookie::setCookieTime
     * @covers  Molajo\User\Cookie::setCookiePath
     * @covers  Molajo\User\Cookie::setCookieDomain
     * @covers  Molajo\User\Cookie::setCookieSecure
     * @covers  Molajo\User\Cookie::setCookieHttpOnly
     * @covers  Molajo\User\Cookie::deleteCookie
     * @covers  Molajo\User\Cookie::destroyCookies
     * @covers  Molajo\User\Cookie::sendCookies
     * @covers  Molajo\User\Cookie::sendCookie
     * @covers  Molajo\User\Cookie::initializeCookies
     * @covers  Molajo\User\Cookie::initializeExpiration
     * @covers  Molajo\User\Cookie::initializePath
     * @covers  Molajo\User\Cookie::initializeDomain
     * @covers  Molajo\User\Cookie::initializeSecure
     * @covers  Molajo\User\Cookie::initializeHttpOnly
     */
    public function testSetDeleteNothingGetCookie()
    {
        $this->assertEquals(false, $this->cookie->deleteCookie('does not exist'));
    }

    /**
     * @covers  Molajo\User\Cookie::__construct
     * @covers  Molajo\User\Cookie::getCookie
     * @covers  Molajo\User\Cookie::setCookie
     * @covers  Molajo\User\Cookie::setCookieTime
     * @covers  Molajo\User\Cookie::setCookiePath
     * @covers  Molajo\User\Cookie::setCookieDomain
     * @covers  Molajo\User\Cookie::setCookieSecure
     * @covers  Molajo\User\Cookie::setCookieHttpOnly
     * @covers  Molajo\User\Cookie::deleteCookie
     * @covers  Molajo\User\Cookie::destroyCookies
     * @covers  Molajo\User\Cookie::sendCookies
     * @covers  Molajo\User\Cookie::sendCookie
     * @covers  Molajo\User\Cookie::initializeCookies
     * @covers  Molajo\User\Cookie::initializeExpiration
     * @covers  Molajo\User\Cookie::initializePath
     * @covers  Molajo\User\Cookie::initializeDomain
     * @covers  Molajo\User\Cookie::initializeSecure
     * @covers  Molajo\User\Cookie::initializeHttpOnly
     */
    public function testDestroyCookie()
    {
        $name = 'Cookie name';
        $value = '@covers  Molajo\User\Cookie::initializeHttpOnly';
        $minutes = 1;
        $minutes_test = time() + 1;
        $path = '/';
        $domain = '';
        $secure = false;
        $http_only = false;

        $this->cookie->setCookie($name, $value, $minutes, $path, $domain, $secure, $http_only);

        $this->cookie->destroyCookies();

        $this->assertEquals(false, $this->cookie->getCookie($name));
    }

    /**
     * @covers  Molajo\User\Cookie::__construct
     * @covers  Molajo\User\Cookie::getCookie
     * @covers  Molajo\User\Cookie::setCookie
     * @covers  Molajo\User\Cookie::setCookieTime
     * @covers  Molajo\User\Cookie::setCookiePath
     * @covers  Molajo\User\Cookie::setCookieDomain
     * @covers  Molajo\User\Cookie::setCookieSecure
     * @covers  Molajo\User\Cookie::setCookieHttpOnly
     * @covers  Molajo\User\Cookie::deleteCookie
     * @covers  Molajo\User\Cookie::destroyCookies
     * @covers  Molajo\User\Cookie::sendCookies
     * @covers  Molajo\User\Cookie::sendCookie
     * @covers  Molajo\User\Cookie::initializeCookies
     * @covers  Molajo\User\Cookie::initializeExpiration
     * @covers  Molajo\User\Cookie::initializePath
     * @covers  Molajo\User\Cookie::initializeDomain
     * @covers  Molajo\User\Cookie::initializeSecure
     * @covers  Molajo\User\Cookie::initializeHttpOnly
     */
    public function testSendCookies()
    {
        $name = 'Cookie';
        $value = '@covers  Molajo\User\Cookie::initializeHttpOnly';
        $minutes = 1;
        $path = '/';
        $domain = '';
        $secure = false;
        $http_only = false;

        setcookie($name, $value, $minutes, $path, $domain, $secure, $http_only);

//$this->cookie->sendCookies($name, $value, $minutes, $path, $domain, $secure, $http_only);
        $cookie =  readJsonFile(__DIR__ . '/Files/testcookie.json');

        $this->assertEquals($name, $cookie['name']);
        $this->assertEquals($value, $cookie['value']);
        $this->assertEquals($minutes, $cookie['expire']);
        $this->assertEquals($path, $cookie['path']);
        $this->assertEquals($domain, $cookie['domain']);
        $this->assertEquals($secure, $cookie['secure']);
        $this->assertEquals($http_only, $cookie['http_only']);
    }
}


function setcookie($name, $value, $expire, $path, $domain, $secure, $http_only)
{
    $cookie            = new \stdClass();
    $cookie->name      = $name;
    $cookie->value     = $value;
    $cookie->expire    = $expire;
    $cookie->path      = $path;
    $cookie->domain    = $domain;
    $cookie->secure    = $secure;
    $cookie->http_only = $http_only;

    file_put_contents(
        __DIR__ . '/Files/testcookie.json',
        json_encode($cookie)
    );
}
