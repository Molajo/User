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
<define name="AUTHENTICATE_STATUS_SUCCESS" value="1"/>
<define name="AUTHENTICATE_STATUS_CANCEL" value="2"/>
<define name="AUTHENTICATE_STATUS_FAILURE" value="4"/>

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
     * Get User
     *
     * @return  object  UserInterface
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function getUser()
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
