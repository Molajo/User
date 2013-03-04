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

use Molajo\User\Exception\AuthenticationException;

/**
 * Anonymous Authentication Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Class Authentication implements AuthenticationInterface
{
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
     * Credentials
     *
     * @param   array $credentials
     *
     * @since   1.0
     */
    protected $credentials;

    /**
     * Constructor
     *
     * @param   array  $credentials
     *
     * @since   1.0
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Authenticate User
     *
     * @param   array   $credentials
     *
     * @return  object  UserInterface
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;
        $row = $this->database->table('users')->where('username', $username)->fetch();

        if (! $row) {
            throw new AuthenticationException
            ('The username is incorrect.', self::IDENTITY_NOT_FOUND);
        }

        if ($row->password !== $this->calculateHash($password, $row->password)) {
            throw new AuthenticationException
            ('The password is incorrect.', self::INVALID_CREDENTIAL);
        }

        unset($row->password);

        // return new Security\Identity

        ($row->id, $row->role, $row->toArray());
    }

    /**
     * Computes salted password hash.
     *
     * @param         $password
     * @param   null  $salt
     *
     * @return  string
     * @since   1.0
     */
    public function calculateHash($password, $salt = null)
    {
        if ($password === strtoupper($password)) {
            $password = strtolower($password);
        }

        //return crypt($password, $salt ? : '$2a$07$' . Strings::random(22));
    }
}
