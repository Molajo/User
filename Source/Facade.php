<?php
/**
 * User Facade to access to all user functions and data
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    MIT
 */
namespace Molajo\User;

use CommonApi\User\ActivityInterface;
use CommonApi\User\CookieInterface;
use CommonApi\User\FlashMessageInterface;
use CommonApi\User\SessionInterface;
use CommonApi\User\UserDataInterface;
use CommonApi\User\UserInterface;

/**
 * User Facade to access to all user functions and data
 *
 * @package    Molajo
 * @license    MIT
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Facade implements UserInterface
{
    /**
     * User Data
     *
     * @var     object  CommonApi\User\UserDataInterface
     * @since   1.0.0
     */
    protected $data;

    /**
     * Session
     *
     * @var     object  CommonApi\User\SessionInterface
     * @since   1.0.0
     */
    protected $session;

    /**
     * Flash Message
     *
     * @var     object  CommonApi\User\FlashMessageInterface
     * @since   1.0.0
     */
    protected $flashmessage;

    /**
     * Cookie
     *
     * @var     object  CommonApi\User\CookieInterface
     * @since   1.0.0
     */
    protected $cookie;

    /**
     * Constructor
     *
     * @param  UserDataInterface     $userdata
     * @param  SessionInterface      $session
     * @param  FlashMessageInterface $flashmessage
     * @param  CookieInterface       $cookie
     *
     * @since  1.0.0
     */
    public function __construct(
        UserDataInterface $userdata,
        SessionInterface $session,
        FlashMessageInterface $flashmessage,
        CookieInterface $cookie = null
    ) {
        $this->userdata     = $userdata;
        $this->session      = $session;
        $this->flashmessage = $flashmessage;
        $this->cookie       = $cookie;
    }

    /**
     * Get user data using a value for id, username, email or initialise new user
     *
     * @param   null|string $value
     * @param   null|string $key
     *
     * @return  $this
     */
    public function load($value = null, $key = 'username')
    {
        return $this->userdata->load($value, $key);
    }

    /**
     * Get User Data
     *
     * @return  object
     * @since   1.0.0
     */
    public function getUserdata()
    {
        return $this->userdata->readUser();
    }

    /**
     * Insert User
     *
     * @param   array $data
     *
     * @return  object
     * @since   1.0.0
     */
    public function insertUserdata(array $data = array())
    {
        return $this->userdata->createUser($data);
    }

    /**
     * Update User Data for loaded User
     *
     * @param   array $updates
     *
     * @return  object
     * @since   1.0.0
     */
    public function updateUserdata(array $updates = array())
    {
        return $this->userdata->updateUser($updates);
    }

    /**
     * Delete User Data
     *
     * @return  $this
     * @since   1.0.0
     */
    public function deleteUserdata()
    {
        return $this->userdata->deleteUser();
    }

    /**
     * Gets the value for a key
     *
     * @param   string $key
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function getSession($key)
    {
        return $this->session->getSession($key);
    }

    /**
     * Sets the value for key
     *
     * @param   string $key
     * @param   mixed  $value
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function setSession($key, $value)
    {
        return $this->session->setSession($key, $value);
    }

    /**
     * Delete a single or all session keys
     *
     * @param   null|string $key
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function deleteSession($key)
    {
        return $this->session->deleteSession($key);
    }

    /**
     * Get Flash Messages for User, all or by Type
     *
     * @param   null|string $type (Success, Notice, Warning, Error)
     *
     * @return  array
     * @since   1.0.0
     */
    public function getFlashmessage($type = null)
    {
        return $this->flashmessage->getFlashmessage($type);
    }

    /**
     * Save a Flash Message (User Message)
     *
     * @param   string $type (Success, Notice, Warning, Error)
     * @param   string $message
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setFlashmessage($type, $message)
    {
        return $this->flashmessage->setFlashmessage($type, $message);
    }

    /**
     * Delete Flash Messages, all or by type
     *
     * @param   null|string $type
     *
     * @return  $this
     * @since   1.0.0
     */
    public function deleteFlashmessage($type = null)
    {
        return $this->flashmessage->deleteFlashmessage($type);
    }

    /**
     * Get an HTTP Cookie
     *
     * @param           $name
     *
     * @link    http://www.faqs.org/rfcs/rfc6265.html
     * @return  $this
     * @since   1.0.0
     */
    public function getCookie($name)
    {
        return $this->cookie->getCookie($name);
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
     * @since   1.0.0
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
        return $this->cookie->setCookie(
            $name,
            $value,
            $minutes,
            $path,
            $domain,
            $secure,
            $http_only
        );
    }

    /**
     * Delete a cookie
     *
     * @param   string $name
     *
     * @return  $this
     * @since   1.0.0
     */
    public function deleteCookie($name)
    {
        return $this->cookie->deleteCookie($name);
    }

    /**
     * sendCookies
     *
     * @return  $this
     * @since   1.0.0
     */
    public function sendCookies()
    {
        return $this->cookie->sendCookies();
    }

    /**
     * sendCookie
     *
     * @param   object $cookie
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function sendCookie($cookie)
    {
        return $this->cookie->sendCookie($cookie);
    }
}
