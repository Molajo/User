<?php
/**
 * User Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User;

defined('MOLAJO') or die;

use Molajo\User\Exception\UserException;

/**
 * User Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface UserInterface
{
    /**
     * Verify user is logged in
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function isLoggedIn();

    /**
     * Log in User
     *
     * @param   array   $credentials
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function login(array $credentials);

    /**
     * Log out User
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function logout();

    /**
     * Is Authorised passes thru the authorisation request
     * to a specialized Authorisation class
     *
     * @param   array  $request
     *
     * @return  mixed
     * @since   1.0
     * @throws  UserException
     */
    public function isAuthorised(array $request = array());
}
