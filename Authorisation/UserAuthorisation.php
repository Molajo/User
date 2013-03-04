<?php
/**
 * User Authorisation Class
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Authorisation;

defined('MOLAJO') or die;

use Molajo\Foundation\Permissions\PermissionsInterface;

use Exception;
use Molajo\User\Exception\AuthorisationException;

/**
 * User Authorisation Class
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Class Authorisation implements UserAuthorisationInterface
{
    /**
     * Authorisation Class Object
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
     * @throws  AuthorisationException
     */
    public function __construct(PermissionsInterface $permissions_class)
    {
        $this->permissions_class = $permissions_class;

        return $this;
    }

    /**
     * Verify Logon
     *
     * @param   int  $user_id
     *
     * @return  bool
     * @since   1.0
     * @throws  AuthorisationException
     */
    public function verifyLogin($user_id)
    {
        try {
            return $this->permissions_class->verifyLogin($user_id);

        } catch (Exception $e) {

            throw new AuthorisationException
            ('Authorisation verifyLogin Failed ' . $e->getMessage());
        }
    }

    /**
     * Verify Task
     *
     * @param   string  $action
     * @param   string  $catalog_id
     *
     * @return  bool
     * @since   1.0
     * @throws  AuthorisationException
     */
    public function verifyTask($action, $catalog_id)
    {
        try {
            return $this->permissions_class->verifyTask($action, $catalog_id);

        } catch (Exception $e) {

            throw new AuthorisationException
            ('Authorisation verifyTask Failed ' . $e->getMessage());
        }
    }

    /**
     * Verify Task List
     *
     * @param   array   $actionlist
     * @param   int     $catalog_id
     *
     * @return  mixed
     * @since   1.0
     */
    public function verifyTaskList($actionlist = array(), $catalog_id = 0)
    {
        try {
            return $this->permissions_class->verifyTaskList($actionlist, $catalog_id);

        } catch (Exception $e) {

            throw new AuthorisationException
            ('Authorisation verifyTask Failed ' . $e->getMessage());
        }
    }

    /**
     * Verify Action
     *
     * @param   string  $view_group_id
     * @param   string  $request_action
     * @param   string  $catalog_id
     *
     * @return  bool
     * @since   1.0
     * @throws  AuthorisationException
     */
    public function verifyAction($view_group_id, $request_action, $catalog_id)
    {
        try {
            return $this->permissions_class->verifyAction($view_group_id, $request_action, $catalog_id);

        } catch (Exception $e) {

            throw new AuthorisationException
            ('Authorisation verifyAction Failed ' . $e->getMessage());
        }
    }

    /**
     * Determines if User Content must be filtered
     *
     * @param   bool  $key
     *
     * @return  mixed
     * @since   1.0
     * @throws  AuthorisationException
     */
    public function setHTMLFilter($key)
    {
        try {
            return $this->permissions_class->setHTMLFilter($key);

        } catch (Exception $e) {
            throw new AuthorisationException
            ('Authorisation setHTMLFilter Failed ' . $e->getMessage());
        }
    }
}
