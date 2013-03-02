<?php
/**
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

defined('MOLAJO') or die;

/**
 * Authentication
 *
 * @package     Molajo
 * @subpackage  Services
 * @since       1.0
 */
Class Authentication implements AuthenticationInterface
{
    /** @var array */
    protected $credentials;

    /**
     * Constructor
     *
     * @param   array  $credentials
     *
     * @return  bool
     * @since   1.0
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Performs an authentication.
     * @return Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;
        $row = $this->database->table('users')->where('username', $username)->fetch();

        if (!$row) {
            throw new Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
        }

        if ($row->password !== $this->calculateHash($password, $row->password)) {
            throw new Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
        }

        unset($row->password);
        return new Security\Identity($row->id, $row->role, $row->toArray());
    }



    /**
     * Computes salted password hash.
     * @param  string
     * @return string
     */
    public static function calculateHash($password, $salt = NULL)
    {
        if ($password === Strings::upper($password)) { // perhaps caps lock is on
            $password = Strings::lower($password);
        }
        return crypt($password, $salt ?: '$2a$07$' . Strings::random(22));
    }


}
