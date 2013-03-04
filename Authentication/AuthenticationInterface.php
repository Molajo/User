<?php
/**
 * Authentication Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

defined('MOLAJO') or die;

use Molajo\User\Exception\AuthenticationException;

/**
 * Authentication Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface AuthenticationInterface
{
    /** Credential key */
    const USERNAME = 0,
        PASSWORD   = 1;

    /** Exception error code */
    const NOT_FOUND      = 1,
        INVALID_PASSWORD = 2,
        BLOCK            = 3,
        NOT_ACTIVATED    = 4;

    /**
     * Authenticate
     *
     * @param   array $credentials
     *
     * @return  bool
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function authenticate(array $credentials);

    /**
     * Verify User Logged In Status
     *
     * getAuthenticated
     * checkExpiration
     * setCookies
     * Load Userdata from Session
     *
     * @return  bool
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function isLoggedIn();

    /**
     * Login User
     *
     * - verifyAccess
     *
     * setAuthenticated
     * setExpiration
     * getUserData
     * Session
     *
     * @param   int  $user_id
     *
     * @return  mixed
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function login($credentials);

    /**
     * Get user data
     *
     * @param   int  $user
     *
     * @return  bool
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function getUserData($user = null);

    /**
     * Logout User
     *
     * @param   bool  $key
     *
     * @return  mixed
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function logout();
}
