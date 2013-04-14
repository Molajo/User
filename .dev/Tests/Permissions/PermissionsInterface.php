<?php
/**
 * Permissions Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Foundation\Permissions;

defined('MOLAJO') or die;

use Molajo\Foundation\Permissions\Exception\PermissionsException;

/**
 * Permissions Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface PermissionsInterface
{
    /**
     * Get language property
     *
     * @param string $key
     * @param string $default
     *
     * @return array|mixed|string
     * @throws  PermissionsException
     * @since   1.0
     */
    public function get($key, $default = '');

    /**
     * Set the value of the specified key
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     * @since   1.0
     * @throws  PermissionsException
     */
    public function set($key, $value = null);

    /**
     * Verifies Permissions for a set of Actions for the specified Catalog ID
     *      Useful for question "What can the logged on User do with this set of Articles (or Article)?"
     *
     * Example usage:
     * $permissions = Services::Permissions()->verifyTaskList($actionsArray, $item->catalog_id);
     *
     * @param array $actionlist
     * @param int   $catalog_id
     *
     * @return array
     * @since   1.0
     * @throws  PermissionsException
     */
    public function verifyTaskList($actionlist = array(), $catalog_id = 0);

    /**
     * Verify User Permissions for the Action and Catalog ID
     *
     * Example usage:
     *  $permissions = Services::Permissions()->verifyAction($view_group_id, $request_action, $catalog_id);
     *
     * @param string $view_group_id
     * @param string $request_action
     * @param string $catalog_id
     *
     * @return bool
     * @since   1.0
     * @throws  PermissionsException
     */
    public function verifyAction($view_group_id, $request_action, $catalog_id);

    /**
     * Verifies permission for a user to perform a specific action on a specific catalog id
     *      Useful for question "Can the logged on User Edit this Article (or content in this Resource)?"
     *
     * Example usage:
     *  Services::Permissions()->verifyTask($action, $catalog_id);
     *
     * @param string $action
     * @param string $catalog_id
     *
     * @return boolean
     * @since   1.0
     * @throws  PermissionsException
     */
    public function verifyTask($action, $catalog_id);

    /**
     * Verifies permission for a user to login to a specific application
     *
     * Example usage:
     *  Services::Permissions()->verifyLogin($user_id);
     *
     * @param int $user_id
     *
     * @return bool
     * @since   1.0
     */
    public function verifyLogin($user_id);

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
     * @param array $query
     * @param array $db
     * @param array $parameters
     *
     * @return array
     * @since   1.0
     */
    public function setQueryViewAccess($query = array(), $db = array(), $parameters = array());

    /**
     * Determines if User Content must be filtered
     *
     * @param string $key
     *
     * Example usage:
     * $userHTMLFilter = Services::Permissions()->setHTMLFilter();
     *
     *  True => disable filter
     *
     *  False => Filter is not required
     *
     * @return bool
     * @since   1.0
     */
    public function setHTMLFilter($key);
}
