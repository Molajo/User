<?php
/**
 * Authentication Anonymous
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Service\Api;

use Molajo\User\Authentication\Authentication;

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
class Http extends Authentication implements AuthenticationInterface
{
    /**
     * Authenticate
     *
     * @param array $credentials
     *
     * @return bool
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function authenticate(array $credentials)
    {

    }

    /**
     * Get User
     *
     * @return  object UserInterface
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function getUser()
    {

    }

    /**
     * Destroy
     *
     * @return bool
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function destroy()
    {

    }
}
