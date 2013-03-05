<?php
/**
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Password;

use Molajo\Service\Type;
use Molajo\User\User;

defined('MOLAJO') or die;

/**
 * Password
 *
 * @package     Molajo
 * @subpackage  Services
 * @since       1.0
 */
Class Password implements PasswordInterface
{
    /**
     * Password Class Object
     *
     * @var     object  PermissionsInterface
     * @since   1.0
     */
    public $permissions_class;

    /**
     * Construct
     *
     * @param   object  $permissions_class
     *
     * @since   1.0
     * @throws  PasswordException
     */
    public function __construct(PermissionsInterface $permissions_class)
    {
        $this->permissions_class = $permissions_class;

        return $this;
    }

    /**
     * Determines if User is Authorised for specific action
     *
     * @param   array  $request
     *
     * @return  mixed
     * @since   1.0
     * @throws  PasswordException
     */
    public function isAuthorised(array $request = array())
    {
        if (is_array($request) && count($request) > 0) {
        } else {
            throw new PasswordException
            ('Password isAuthorised Failed. Input $request array is empty.');
        }

        if (isset($request['method'])) {
            $method = strtolower($request['method']);

        } else {
            throw new PasswordException
            ('Password isAuthorised Failed. Input $request array missing method entry.');
        }

        try {

            if ($method == 'verify') {
                return $this->verify($request);

            } elseif ($method == 'change') {
                return $this->change($request);

            } elseif ($method == 'salt') {
                return $this->salt($request);

            } else {
                throw new PasswordException
                ('Password Unknown Method: ' . $method);
            }

        } catch (Exception $e) {
            throw new PasswordException
            ('Password setHTMLFilter Failed ' . $e->getMessage());
        }
    }

    /**
     * Verify Password
     *
     * @param   array  $request
     *
     * @return  bool
     * @since   1.0
     */
    public function verify(array $request)
    {
        /*
        * @param   string  $user_password_salt
        * @param   string  $configuration_password_salt
        * @param   string  $email_address
        * @param   string  $password
         * $user_password_salt, $configuration_password_salt, $password
         *
         */

        $encPass = $this->salt($request);

        $row = $this->_conn->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.email = :email')
            ->andWhere('u.password = :password')
            ->setParameter(':email', $username)
            ->setParameter(':password', $encPass)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;

    }

    /**
     * Change Password
     *
     * @param   array  $request
     *
     * @return  string
     * @since   1.0
     */
    public function change(array $request)
    {
/*
 *
     * @param   string  $user_name
     * @param   string  $password
     * @param   string  $user_password_salt
     * @param   string  $configuration_password_salt
 */
        $this->update(
            array('password' => $this->salt_password($user_password_salt, $configuration_password_salt, $password)),
            array('id' => $user_id)
        );
    }

    /**
     * Salt Password
     *
     * @param   array  $request
     *
     * @return  string
     * @since   1.0
     */
    function salt(array $request)
    {
    /*
     * $user_password_salt, $configuration_password_salt, $password
        * @param   string  $password
        * @param   string  $user_password_salt
        * @param   string  $configuration_password_salt
    */
       / return sha1($user_password_salt . $configuration_password_salt . $password);
    }


// http://www.nathandavison.com/posts/view/13/php-bcrypt-hash-a-password-with-a-logical-salt
    /**
     * Generate Salt
     *
     * @param   array  $request
     *
     * @return  string
     * @since   1.0
     */
    function generateSaltarray ($request) {

        //$username
        $salt = '$2a$13$';
        $salt = $salt . md5(strtolower($username));
        return $salt;
    }

    function generateHash($salt, $password) {
        $hash = crypt($password, $salt);
        $hash = substr($hash, 29);
        return $hash;
    }
}
