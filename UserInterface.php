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
     * Verify authorisation
     *
     * @param   array  $request
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function isAuthenticated(array $request = array());

    /**
     * Set Authenticated
     *
     * @param   int  $user
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function setAuthenticated($user = null);

    /**
     * Get Authenticated
     *
     * @param   int  $user
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function getAuthenticated($user = null);

    /**
     * Verify logged in status
     *
     * @param   array  $request
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function isLoggedIn(array $request = array());

    /**
     * Log User in
     *
     * @param   int  $user
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function login($id = null, $password = null);

    /**
     * Enables log out after inactivity.
     *
     * @param  string|int|DateTime number of seconds or timestamp
     * @param                      bool   log out when the browser is closed?
     * @param                      bool   clear the identity from persistent storage?
     *
     * @return User  provides a fluent interface
     */
    public function setExpiration($time, $whenBrowserIsClosed = true, $clearIdentity = false);

    /**
     * Log User out
     *
     * @param   int  $user
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function logout($user = null);

    /**
     * Get user data
     *
     * @param   int  $user
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function getUserData($user = null);

    /**
     * Set user data
     *
     * @param   int  $user
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function setUserData($user_id = 0);

    /**
     * Verify authorisation
     *
     * @param   array  $request
     *
     * @return  bool
     * @since   1.0
     * @throws  UserException
     */
    public function isAuthorised(array $request = array());

    /**
     * Set Applications
     *
     * @param   array  $applications
     *
     * @return  void
     * @since   1.0
     * @throws  UserException
     */
    public function setApplications(array $applications = array());

    /**
     * Set Extensions
     *
     * @param   array  $extensions
     *
     * @return  array
     * @since   1.0
     * @throws  UserException
     */
    public function setExtensions(array $extensions = array());

    /**
     * Set Groups
     *
     * @param   array  $groups
     *
     * @return  array
     * @since   1.0
     * @throws  UserException
     */
    public function setGroups(array $groups = array());
}
