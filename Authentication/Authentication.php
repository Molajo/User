<?php
include __DIR__ . '/' . 'PasswordLib.phar';

/**
 * Authentication
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

defined('MOLAJO') or die;

use Molajo\User\Exception\AuthenticationException;

/**
 * Anonymous Authentication Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class Authentication implements AuthenticationInterface
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
    public function login(array $credentials)
    {
        $password = null;
        if (isset($parameters['password'])) {
            $password = $parameters['password'];
        }

        $username = null;
        if (isset($parameters['username'])) {
            $username = $parameters['username'];
        }

        $lib      = new PasswordLib / PasswordLib();
        $verified = $lib->verifyPasswordHash($password);

        if ($verified === true) {
        } else {
            throw new AuthenticationException
            ('Authentication Password is incorrect.', self::INVALID_CREDENTIAL);
        }

        $actual_password = null;
        if (isset($parameters['actual_password'])) {
            $actual_password = $parameters['actual_password'];
        }

        $results = $this->calculateHash($password, $actual_password);
        if ($results === true) {
        } else {
            throw new AuthenticationException
            ('The password is incorrect.', self::INVALID_CREDENTIAL);
        }

        return;
    }
}
