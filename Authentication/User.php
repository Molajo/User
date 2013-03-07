<?php
/**
 * Authentication Anonymous
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

defined('MOLAJO') or die;

/**
 * Authentication Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 *
 * RememberMe
 * Http
 *
 */
class User extends Authentication implements AuthenticationInterface
{

    /** Exception error code */
    const AUTHENTICATE_STATUS_SUCCESS = 1,
        AUTHENTICATE_STATUS_CANCEL    = 2,
        AUTHENTICATE_STATUS_FAILURE   = 3;

    /**
     * Authenticate
     *
     * @param   array $credentials
     *
     * @return  bool
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function authenticate(array $credentials)
    {

    }


    /**
     * Destroy
     *
     * @return  bool
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function destroy()
    {

    }
}
