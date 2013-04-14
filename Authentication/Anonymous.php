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

use Molajo\User\Exception\Authentication;

/**
 * Anonymous Authentication Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class Anonymous extends Authentication implements AuthenticationInterface
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
}
