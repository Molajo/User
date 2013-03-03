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
Class Password extends User implements PasswordInterface
{

    /**
     * Verify a user by their email and password
     *
     * @param string $userSalt
     * @param string $configSalt
     * @param string $userEmail
     * @param string $password
     *
     * @return bool
     */
    public function verifyPassword($userSalt, $configSalt, $userEmail, $password)
    {

        $encPass = $this->saltPass($userSalt, $configSalt, $password);

        $row = $this->_conn->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.email = :email')
            ->andWhere('u.password = :password')
            ->setParameter(':email', $userEmail)
            ->setParameter(':password', $encPass)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;

    }

    /**
     * updatePassword
     *
     * @param $userID
     * @param $userSalt
     * @param $configSalt
     * @param $password
     */
    public function updatePassword($userID, $userSalt, $configSalt, $password)
    {
        $this->update(
            array('password' => $this->saltPass($userSalt, $configSalt, $password)),
            array('id' => $userID)
        );
    }

    /**
     * Salt the password
     *
     * @param string $userSalt
     * @param string $configSalt
     * @param string $pass
     *
     * @return string
     */
    function saltPass($userSalt, $configSalt, $pass)
    {
        return sha1($userSalt . $configSalt . $pass);
    }

}
