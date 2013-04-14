<?php
/**
 * User Class
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   MIT
 */

namespace Molajo\User;

defined('MOLAJO') or die;

use Molajo\User\Exception\UserException;
use Molajo\User\Type;

/**
 * User Class
 *
 * @package   Molajo
 * @license   MIT
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class User implements UserInterface
{
    /**
     * UserType Interface
     *
     * @var     object  UserTypeInterface
     * @since   1.0
     */
    public $user_type;

    /**
     * Construct
     *
     * @param string $action
     * @param string $user_type
     * @param array  $options
     *
     * @since   1.0
     * @throws  UserException
     */
    public function __construct($action = '', $user_type, $options = array())
    {
        $options = $this->getTimeZone($options);

        $class = $this->getUserType($user_type);

        try {
            $this->ct = new $class($action, $user_type, $options);

        } catch (Exception $e) {

            throw new UserException
            ('Caught this ' . $e->getMessage());
        }

        $this->process();

        $this->close();

        return $this->ct;
    }

    /**
     * register
     *
     * @since   1.0
     * @throws  UserException
     */
    public function register()
    {
        //edit and filter
        // insert
        // activated code: $activationCode = sha1(openssl_random_pseudo_bytes(16));
        // Send the user's activation email
        // flash message 'Signup Succcessful
        // redirect to home
    }

    /**
     * Verify User Logged In Status
     *
     * getAuthenticated
     * checkExpiration
     * setCookies
     * Load Userdata from Session
     *
     * @return bool
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function isLoggedIn()
    {

    }

    /**
     * Login User
     *
     * - verifyAccess
     *
     * setAuthenticated
     * setExpiration
     * getUserData
     * Session
     *
     * @param int $user_id
     *
     * @return mixed
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function login($credentials)
    {

    }

    /**
     * Logout User
     *
     * @param bool $key
     *
     * @return mixed
     * @since   1.0
     * @throws  AuthenticationException
     */
    public function logout()
    {

    }

    /**
     * Log in User
     *
     * @param array $credentials
     *
     * @return bool
     * @since   1.0
     * @throws  UserException
     */
    public function login(array $credentials)
    {
        //edit and filter
        // authenticate
        // get user
        // is user activated?
        // populate session w user info
        // flash message 'Login Succcessful
        // redirect to home
    }

    /**
     * Remind Me Username
     *
     * @param string $type Password Userid Username
     *
     * @return array
     * @since   1.0
     * @throws  UserTypeException
     */
    public function remindMeUsername()
    {
        //edit and filter
        // $activationCode = sha1(openssl_random_pseudo_bytes(16));
        // redirect to home
    }

    /**
     * Remind Me Password
     *
     * @param string $type Password Userid Username
     *
     * @return array
     * @since   1.0
     * @throws  UserTypeException
     */
    public function remindMePassword($type)
    {
        //edit and filter
        // $activationCode = sha1(openssl_random_pseudo_bytes(16));
        // redirect to home
    }

    /**
     * Is Authorised passes through the authorisation request
     * to a specialized Authorisation class
     *
     * @param array $request
     *
     * @return mixed
     * @since   1.0
     * @throws  UserException
     */
    public function isAuthorised(array $request)
    {

    }

    /**
     * Log out User
     *
     * @return bool
     * @since   1.0
     * @throws  UserException
     */
    public function logout()
    {
        $this->getSession()->clear();
        $this->redirectToRoute('Homepage');
    }

    /**
     * Get timezone
     *
     * @param array $options
     *
     * @return array
     * @since   1.0
     */
    protected function getTimeZone($options)
    {
        $timezone = '';

        if (is_array($options)) {
        } else {
            $options = array();
        }

        if (isset($options['timezone'])) {
            $timezone = $options['timezone'];
        }

        if ($timezone === '') {
            if (ini_get('date.timezone')) {
                $timezone = ini_get('date.timezone');
            }
        }

        if ($timezone === '') {
            $timezone = 'UTC';
        }

        ini_set('date.timezone', $timezone);
        $options['timezone'] = $timezone;

        return $options;
    }
}
