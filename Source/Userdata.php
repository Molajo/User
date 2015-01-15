<?php
/**
 * User Data
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\User;

use CommonApi\User\UserDataInterface;
use Molajo\User\Data\Load;

/**
 * User Data
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Userdata extends Load implements UserDataInterface
{
    /**
     * Get user data using a value for id, username, email or initialise new user
     *
     * @param   null|string $value
     * @param   null|string $key
     *
     * @return  $this
     */
    public function load($value = null, $key = 'username')
    {
        return $this->loadUser($value, $key);
    }

    /**
     * Insert User
     *
     * @param   array $data
     *
     * @return  object
     * @since   1.0
     */
    public function insertUserData(array $data = array())
    {
        return $this->insertUser($data);
    }

    /**
     * Update User Data for loaded User
     *
     * @param   array $updates
     *
     * @return  object
     * @since   1.0
     */
    public function updateUserData(array $data = array())
    {
        return $this->updateUser($data);
    }

    /**
     * Delete User Data for loaded User
     *
     * @return  object
     * @since   1.0
     */
    public function deleteUserData()
    {
        return $this->deleteUser();
    }
}
