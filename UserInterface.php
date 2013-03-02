<?php
/**
 * User Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   MIT
 */
namespace Molajo\User\Adapter;

defined('MOLAJO') or die;

/**
 * User Interface
 *
 * @package   Molajo
 * @license   MIT
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface UserInterface
{
    /**
     * Retrieve User Data
     *
     * @return  void
     * @since   1.0
     */
    public function getUser();

    /**
     * Registration
     *
     * @return  void
     * @since   1.0
     */
    public function register();

    /**
     * Authentication
     *
     * @return  void
     * @since   1.0
     */
    public function authenticate();

    /**
     * Authorisation
     *
     * @return  void
     * @since   1.0
     */
    public function authorise();

    /**
     * Get Session
     *
     * @return  void
     * @since   1.0
     */
    public function getSession();

    /**
     * Get Cookie
     *
     * @return  void
     * @since   1.0
     */
    public function getCookie();


    /**
     * Get Csrf Token
     *
     * @return  void
     * @since   1.0
     */
    public function getToken();

}
