<?php
/**
 * Password Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Password;

defined('MOLAJO') or die;

/**
 * Password Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface PasswordInterface
{

    /**
     * Verify logged in status
     * getAuthenticated
     *
     * @param   array  $request
     *
     * @return  bool
     * @since   1.0
     * @throws  PasswordException
     */
    public function isLoggedIn();

    /**
     * Login User
     *
     * - verifyAccess
     *
     * setAuthenticated
     * setExpiration
     *
     * @param   int  $user_id
     *
     * @return  mixed
     * @since   1.0
     */
    public function login($credentials);

    /**
     * Determines if User Content must be filtered
     *
     * @param   bool  $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function logout();
}
