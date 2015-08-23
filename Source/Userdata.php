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
     * Set User Data for id, username, email or Initialise User
     *
     * @param   null|string $key
     * @param   null|string $value
     *
     * @return  $this
     */
    public function load($key = 'username', $value = null)
    {
        $this->loadUser($key, $value);

        return $this;
    }

    /**
     * Create User
     *
     * @param   array $data
     *
     * @return  $this
     * @since   1.0.0
     */
    public function createUser(array $data = array())
    {
        $this->insertUser($data);

        return $this;
    }

    /**
     * Return data for current user
     *
     * @return  object
     * @since   1.0.0
     */
    public function readUser()
    {
        return $this->user;
    }

    /**
     * Update Current User
     *
     * @param   array $data
     *
     * @return  $this
     * @since   1.0.0
     */
    public function updateUser(array $data = array())
    {
        $this->updateUserData($data);

        $this->loadUser('id', $this->user->id);

        return $this;
    }

    /**
     * Delete Current User
     *
     * @return  object
     * @since   1.0.0
     */
    public function deleteUser()
    {
        $this->deleteUser();

        return $this;
    }
}
