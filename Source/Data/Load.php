<?php
/**
 * User Data Load
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Data;

use stdClass;

/**
 * User Data
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Load extends Insert
{
    /**
     * User Type: id, username, or email
     *
     * @var    string
     * @since  1.0.0
     */
    protected $user_type = null;

    /**
     * User Type: id, username, or email
     *
     * @var    string
     * @since  1.0.0
     */
    protected $column_name = null;

    /**
     * Get user data using a value for id, username, email or initialise new user
     *
     * @param   null|string $key
     * @param   null|string $value
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function loadUser($key = 'username', $value = null)
    {
        $this->user = new stdClass();

        $this->setUserBase($key, $value);

        $this->setUserChildObjects();

        $this->setPermissions();

        $this->user->today = $this->query->getDate();

        return $this;
    }

    /**
     * Get User Data for Guest or Authorised User
     *
     * @param   string $key
     * @param   string $value
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function setUserBase($key, $value = null)
    {
        $this->setRequestType($key);

        $this->setQueryController('Molajo//Model//Datasource//User.xml', 'Read');

        $this->setModelRegistry();

        if ($value === null) {
            $data          = $this->setGuestObject();
            $this->user_id = 0;
        } else {

            $this->setQueryControllerDefaults(
                $process_events = 0,
                $query_object = 'item',
                $get_customfields = 0,
                $use_special_joins = 0,
                $use_pagination = 0,
                $check_view_level_access = 0,
                $get_item_children = 0
            );

            $data = $this->getUserQueryData($value);
        }

        $user = $this->setStandardFields($data, $this->model_registry);

        $this->user = $this->setCustomFields($user, $data, $this->model_registry);

        return $this;
    }

    /**
     * Set Empty User Data Object for Guest
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setGuestObject()
    {
        return new stdClass();
    }

    /**
     * Set Child Objects for User Object
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setUserChildObjects()
    {
        $this->child_objects = array();

        if (count($this->model_registry['children']) === 0) {
            return $this;
        }

        foreach ($this->model_registry['children'] as $child) {
            $name = ucfirst(strtolower((string)$child['name']));
            $data = $this->setUserChildObject($name);
            if (in_array($name, array('Userapplications', 'Usergroups', 'Usersites', 'Userviewgroups'))) {
                $data = $this->stripUserIdColumn($data);
            }
            $this->user->$name = $data;
        }

        return $this;
    }

    /**
     * Set Child Object for User Object
     *
     * @param   string $name
     *
     * @return  array
     * @since   1.0.0
     */
    protected function setUserChildObject($name)
    {
        $this->setQueryController('Molajo//Model//Datasource//' . $name . '.xml', 'Read');
        $this->setQueryControllerDefaults();
        $this->query->setModelRegistry('query_object', 'list');
        $this->column_name = 'user_id';
        $this->user_type   = 'integer';

        return $this->getUserQueryData($this->user->id);
    }

    /**
     * Strip out the User Id Column
     *
     * @param   array $data
     *
     * @return  array
     * @since   1.0.0
     */
    protected function stripUserIdColumn(array $data = array())
    {
        if (count($data) === 0) {
            return $data;
        }

        $new_data = array();

        foreach ($data as $row) {
            foreach ($row as $key => $value) {
                if ($key === 'user_id') {
                } else {
                    $new_data[] = $value;
                }
            }
        }

        return $new_data;
    }

    /**
     * Set Permission Data
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setPermissions()
    {
        if ($this->user->reset_password_code === null) {
            $this->user->reset_password_code = '';
        }

        $this->user->public = 1;

        if (in_array(self::GROUP_ADMINISTRATOR, $this->user->Usergroups)) {
            $this->user->administrator = 1;
        } else {
            $this->user->administrator = 0;
        }

        if ($this->user->id === null) {
            $this->user->guest = 1;
        } else {
            $this->user->guest = 0;
        }

        if ($this->user->guest === 1) {
            $this->user->registered = 0;
        } else {
            $this->user->registered = 1;
        }

        if ($this->user->administrator === 1) {
            $this->user->html_filtering_required       = 0;
            $this->user->authorised_for_offline_access = 1;
        } else {
            $this->user->html_filtering_required       = 1;
            $this->user->authorised_for_offline_access = 0;
        }

        return $this;
    }

    /**
     * Query Database for User Data
     *
     * @param   string $value
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getUserQueryData($value)
    {
        $this->query->where('column', $this->column_name, '=', $this->user_type, $value);

        return $this->runQuery();
    }

    /**
     * Set User Request Type: id, email, or username
     *
     * @param   string $key
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setRequestType($key)
    {
        if ($key === 'id') {
            return $this->setRequestTypeId();
        }

        $this->column_name = $key;
        $this->user_type   = $key;
        $this->user->guest = 0;

        return $this;
    }

    /**
     * Set User Request Type for Id Request
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setRequestTypeId()
    {
        $this->column_name = 'id';
        $this->user_type   = 'userid';
        $this->user->guest = 0;

        return $this;
    }
}
