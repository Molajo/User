<?php
/**
 * User Authorisation Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authorisation;

defined('MOLAJO') or die;

/**
 * User Authorisation Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface AuthorisationInterface
{
    /**
     * Verify Logon
     *
     * @param   int  $user_id
     *
     * @return  mixed
     * @since   1.0
     */
    public function verifyLogin($user_id);

    /**
     * Verify Task
     *
     * @param   string  $action
     * @param   string  $catalog_id
     *
     * @return  mixed
     * @since   1.0
     */
    public function verifyTask($action, $catalog_id);

    /**
     * Verify Task List
     *
     * @param   string  $action
     * @param   string  $catalog_id
     *
     * @return  mixed
     * @since   1.0
     */
    public function verifyTaskList($actionlist = array(), $catalog_id = 0);

    /**
     * Verify Action
     *
     * @param   string  $view_group_id
     * @param   string  $request_action
     * @param   string  $catalog_id
     *
     * @return  mixed
     * @since   1.0
     */
    public function verifyAction($view_group_id, $request_action, $catalog_id);

    /**
     * Determines if User Content must be filtered
     *
     * @param   bool  $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function setHTMLFilter($key);
}
