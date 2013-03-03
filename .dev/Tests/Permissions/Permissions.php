<?php
/**
 * Mock Permissions Class for Testing
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Foundation\Permissions;

defined('MOLAJO') or die;

use Molajo\Foundation\Permissions\Exception\PermissionsException;

/**
 * Mock Permissions Class for Testing
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Class Permissions implements PermissionsInterface
{
    /**
     * Actions used to establish permissions
     *
     *  [0]=> "none" [1]=> "login" [2]=> "create" [3]=> "read"
     *  [4]=> "update" [5]=> "publish" [6]=> "delete" [7]=> "administer"
     *
     * @var    bool
     * @since  1.0
     */
    protected $actions;

    /**
     * Action to Authorisation
     *
     * @var    bool
     * @since  1.0
     */
    protected $action_to_authorisation;

    /**
     * Action to Controller
     *
     * @var    bool
     * @since  1.0
     */
    protected $action_to_controller;

    /**
     * Tasks (Order up, Order down, Feature, etc.)
     *
     * @var    bool
     * @since  1.0
     */
    protected $task;

    /**
     * Action to Authorisation ID
     *
     * @var    bool
     * @since  1.0
     */
    protected $action_to_authorisation_id;

    /**
     * Filter Authorisation
     *
     * @var    bool
     * @since  1.0
     */
    protected $filters;

    /**
     * User View Groups
     *
     * @var    bool
     * @since  1.0
     */
    protected $user_view_groups;

    /**
     * User Groups
     *
     * @var    bool
     * @since  1.0
     */
    protected $user_groups;

    /**
     * Disable Filter for Groups
     *
     * @var    bool
     * @since  1.0
     */
    protected $disable_filter_for_groups;

    /**
     * List of Properties
     *
     * @var    object
     * @since  1.0
     */
    protected $property_array = array(
        'actions',
        'action_to_authorisation',
        'action_to_controller',
        'tasks',
        'action_to_authorisation_id',
        'filters',
        'site_application',
        'task_action',
        'user_view_groups',
        'user_groups',
        'disable_filter_for_groups'
    );

    /**
     * Get language property
     *
     * @param   string  $key
     * @param   string  $default
     *
     * @return  array|mixed|string
     * @throws  PermissionsException
     * @since   1.0
     */
    public function get($key, $default = '')
    {

    }

    /**
     * Set the value of the specified key
     *
     * @param   string  $key
     * @param   mixed   $value
     *
     * @return  mixed
     * @since   1.0
     * @throws  PermissionsException
     */
    public function set($key, $value = null)
    {

    }

    /**
     * Verifies Permissions for a set of Actions for the specified Catalog ID
     *      Useful for question "What can the logged on User do with this set of Articles (or Article)?"
     *
     * Example usage:
     * $permissions = Services::Permissions()->verifyTaskList($actionsArray, $item->catalog_id);
     *
     * @param   array  $actionlist
     * @param   int    $catalog_id
     *
     * @return  array
     * @since   1.0
     * @throws  \Exception
     */
    public function verifyTaskList($actionlist = array(), $catalog_id = 0)
    {
        if (count($actionlist) === 0) {
            throw new PermissionsException('Permissions: Empty Action List sent into verifyTasklist');
        }
        if ($catalog_id == 0) {
            throw new PermissionsException('Permissions: No Catalog ID sent into verifyTaskList');
        }

        if ($catalog_id == 1) {

        }
        $actionPermissions = array();

        if ($catalog_id == 1) {
            $actionPermissions['read']   = 1;
            $actionPermissions['write']  = 1;
            $actionPermissions['update'] = 1;
        }

        if ($catalog_id == 2) {
            $actionPermissions['read']   = 0;
            $actionPermissions['write']  = 0;
            $actionPermissions['update'] = 0;
        }

        return $actionPermissions;
    }

    /**
     * Verify User Permissions for the Action and Catalog ID
     *
     * Example usage:
     *  $permissions = Services::Permissions()->verifyAction($view_group_id, $request_action, $catalog_id);
     *
     * @param   string  $view_group_id
     * @param   string  $request_action
     * @param   string  $catalog_id
     *
     * @return  bool
     * @since   1.0
     * @throws  \Exception
     */
    public function verifyAction($view_group_id, $request_action, $catalog_id)
    {

        if ($catalog_id == 1) {
            return true;
        }

        return false;
    }

    /**
     * Verifies permission for a user to perform a specific action on a specific catalog id
     *      Useful for question "Can the logged on User Edit this Article (or content in this Resource)?"
     *
     * Example usage:
     *  Services::Permissions()->verifyTask($action, $catalog_id);
     *
     * @param   string  $action
     * @param   string  $catalog_id
     *
     * @return  boolean
     * @since   1.0
     * @throws  \Exception
     */
    public function verifyTask($action, $catalog_id)
    {
        if ($catalog_id == 1) {
            if (strtolower($action) == 'view') {
                return true;
            }
            if (strtolower($action) == 'update') {
                return true;
            }
            if (strtolower($action) == 'delete') {
                return true;
            }
        }

        if ($catalog_id == 2) {
            return false;
        }
    }

    /**
     * Verifies permission for a user to login to a specific application
     *
     * Example usage:
     *  Services::Permissions()->verifyLogin($user_id);
     *
     * @param   int  $user_id
     *
     * @return  bool
     * @since   1.0
     */
    public function verifyLogin($user_id)
    {
        if ($user_id == 1) {
            return true;
        }

        if ($user_id == 2) {
            return false;
        }
    }

    /**
     * Appends View Access criteria to Query when Model check_view_level_access is set to 1
     *
     * Example usage:
     *  Services::Permissions()->setQueryViewAccess(
     *     $this->query,
     *     $this->db,
     *     array('join_to_prefix' => $this->primary_prefix,
     *         'join_to_primary_key' => Services::Registry()->get($this->model_registry, 'primary_key'),
     *         'catalog_prefix' => $this->primary_prefix . '_catalog',
     *         'select' => true
     *     )
     * );
     *
     * @param   array  $query
     * @param   array  $db
     * @param   array  $parameters
     *
     * @return  array
     * @since   1.0
     */
    public function setQueryViewAccess($query = array(), $db = array(), $parameters = array())
    {

    }

    /**
     * Determines if User Content must be filtered
     *
     * Example usage:
     * $userHTMLFilter = Services::Permissions()->setHTMLFilter();
     *
     *  True => disable filter
     *
     *  False => Filter is not required
     *
     * @return  bool
     * @since   1.0
     */
    public function setHTMLFilter()
    {
        return true;
    }
}
