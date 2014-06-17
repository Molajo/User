<?php
/**
 * User Data
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\User;

use Exception;
use stdClass;
use CommonApi\Database\DatabaseInterface;
use CommonApi\Exception\RuntimeException;
use CommonApi\Query\QueryInterface;
use CommonApi\User\UserDataInterface;

/**
 * User Data
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Userdata implements UserDataInterface
{
    /**
     * User Group Constants
     *
     * @since  1.0
     */
    const GROUP_ADMINISTRATOR = 1;
    const GROUP_PUBLIC        = 2;
    const GROUP_GUEST         = 3;
    const GROUP_REGISTERED    = 4;

    /**
     * Database Instance
     *
     * @var    object  CommonApi\Database\DatabaseInterface
     * @since  1.0
     */
    protected $database;

    /**
     * Query Instance
     *
     * @var    object  CommonApi\Query\QueryInterface
     * @since  1.0
     */
    protected $query;

    /**
     * Model Registry
     *
     * @var    array
     * @since  1.0
     */
    protected $model_registry;

    /**
     * Model Registries for Children
     *
     * @var    array
     * @since  1.0
     */
    protected $child_model_registries = array();

    /**
     * User Object
     *
     * @var    object
     * @since  1.0
     */
    protected $user;

    /**
     * Construct
     *
     * @param DatabaseInterface $database
     * @param QueryInterface    $query
     * @param                   $model_registry
     * @param                   $child_model_registries
     *
     * @since  1.0
     */
    public function __construct(
        DatabaseInterface $database,
        QueryInterface $query,
        $model_registry,
        $child_model_registries
    ) {
        $this->database               = $database;
        $this->query                  = $query;
        $this->model_registry         = $model_registry;
        $this->child_model_registries = $child_model_registries;
    }

    /**
     * Get user data using a value for id, username, email or initialize new user
     *
     * @param   null|string $value
     * @param   null|string $key
     *
     * @return  $this
     */
    public function load($value = null, $key = 'username')
    {
        $this->user           = new stdClass();
        $this->user->guest    = 1;
        $this->user->id       = null;
        $this->user->username = null;
        $this->user->email    = null;
        $column               = '';
        $data_type            = '';
        $data                 = new stdClass();

        if ($value === null) {

        } elseif ($key == 'id') {
            $column            = 'id';
            $data_type         = 'userid';
            $this->user->guest = 0;

        } elseif ($key == 'email') {
            $column            = 'email';
            $data_type         = 'email';
            $this->user->guest = 0;

        } elseif ($key == 'username') {
            $column            = 'username';
            $data_type         = 'username';
            $this->user->guest = 0;
        }

        if ($this->user->guest === 0) {
            $data = $this->getUser($column, $data_type, $value);
        }

        $this->setStandardFields($data);

        $this->setCustomFields();

        if (count($this->model_registry['children']) > 0) {

            foreach ($this->model_registry['children'] as $child) {

                $name = (string)$child['name'];
                $join = (string)$child['join'];

                if (isset($this->child_model_registries[$name])) {

                    $model_registry = $this->child_model_registries[$name];

                    if ($this->user->id === 0) {
                        $data = null;
                    } else {
                        $entry = substr((string)$model_registry['table_name'], 8, 9999);
                        $this->user->$entry
                               = $this->getChildData($this->user->id, $join, $model_registry);
                    }
                }
            }
        }

        $this->setPermissions();

        $this->user->today = $this->query->getDate();

        return $this;
    }

    /**
     * Get User Data
     *
     * @return  object
     * @since   1.0
     */
    public function getUserdata()
    {
        return $this->user;
    }

    /**
     * Insert User
     *
     * @param   array $data
     *
     * @return  object
     * @since   1.0
     */
    public function insertUserdata(array $data = array())
    {
        return $this->user;
    }

    /**
     * Update User Data for loaded User
     *
     * @param   array $updates
     *
     * @return  object
     * @since   1.0
     */
    public function updateUserdata(array $updates = array())
    {
        if (is_array($updates) && count($updates) > 0) {
        } else {
            return $this->user;
        }

        $column_values = array();

        $table = '#__users';

        foreach ($updates as $table_column => $value) {

            if (strpos($table_column, '.')) {
                $temp = explode('.', $table_column);

                if (count($temp) == 2) {
                } else {
                    throw new RuntimeException
                    ('Userdata-updateUserdata Method: Illegal Value for $table_column: ' . $table_column);
                }

                if (trim($table) == '' || $table == strtolower($temp[0])) {
                } else {
                    throw new RuntimeException
                    ('Userdata-updateUserdata Method: Attempting to update multiple tables simultaneously'
                    . ' Previous table: ' . $table
                    . ' Different table value: ' . strtolower($temp[0]));
                }

                $table                   = strtolower($temp[0]);
                $column_values[$temp[1]] = $value;

            } else {
                $column_values[$table_column] = $value;
            }
        }

        try {

            $this->query->clearQuery();

            $this->query->setType('update');
            $this->query->from($table);
            $this->query->where('column', 'id', '=', 'integer', $this->user->id);

            foreach ($column_values as $column => $value) {
                $this->query->select($column, null, $value, $this->getDatatype($table, $column));
            }

            $this->database->execute($this->query->getSQL());

            $this->load($value = $this->user->id, $key = 'id');

        } catch (Exception $e) {
            throw new RuntimeException
            ('Userdata::updateUserdata Failed: ' . $e->getMessage());
        }

        return $this->user;
    }

    /**
     * Get Data Type for Update or Insert
     *
     * @param   string $table
     * @param   string $column
     *
     * @return  string
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getDatatype($table, $column)
    {
        if ($table == '#__users') {
            return $this->getDatatypeStandard($column);
        }
        // need custom fields
        // need child objects

        throw new RuntimeException
        ('Userdata-getDatatype Method: Unidentified User Table: ' . $table);
    }

    /**
     * Get Data Type for Update or Insert
     *
     * @param   string $column
     *
     * @return  string
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getDatatypeStandard($column)
    {
        if (count($this->model_registry['fields']) > 0) {
        } else {
            throw new RuntimeException
            ('Userdata-getDatatypeStandard Method: Empty model_registry for Standard Fields.');
        }

        foreach ($this->model_registry['fields'] as $field) {
            $name = $field['name'];
            if ($name == $column) {
                return $field['type'];
            }
        }

        throw new RuntimeException
        ('Userdata-getDatatypeStandard Method: Standard Field does not exist: ' . $column);
    }

    /**
     * Get Data Type for Update or Insert
     *
     * @param   string $table
     * @param   string $column
     *
     * @return  object
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getDatatypeChild($table, $column)
    {
        throw new RuntimeException
        ('Userdata-getDatatypeChild Method: Child does not exist. Table: ' . $table . ' Column: ' . $column);
    }

    /**
     * Delete User Data
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function deleteUserdata()
    {
        try {

            $this->query->clearQuery();

            $this->query->setType('delete');
            $this->query->from('#__users');
            $this->query->where('column', 'id', '=', 'integer', (int)$this->user->id);

            $this->database->execute($this->query->getSQL());

        } catch (Exception $e) {
            throw new RuntimeException
            ('Userdata::deleteUserdata Failed: ' . $e->getMessage());
        }

        return $this;
    }

    /**
     * Query Database for User
     *
     * @param   string $column
     * @param   string $data_type
     * @param   string $value
     *
     * @return  object
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getUser($column, $data_type, $value)
    {
        try {

            $this->query->clearQuery();

            $this->query->select('*');
            $this->query->from('#__users');
            $this->query->where('column', $column, '=', $data_type, $value);

            $results = $this->database->loadObjectList($this->query->getSQL());

            if (is_array($results) && count($results) > 0) {
                $data = $results[0];
            } else {
                $data = new stdClass();
            }

        } catch (Exception $e) {
            throw new RuntimeException
            ('Userdata::getUser Failed: ' . $e->getMessage());
        }

        return $data;
    }

    /**
     * Set Standard Fields
     *
     * @param   object $data
     *
     * @return  $this
     * @since   1.0
     */
    protected function setStandardFields($data)
    {
        if (count($this->model_registry['fields']) > 0) {
            foreach ($this->model_registry['fields'] as $field) {
                $name              = $field['name'];
                $this->user->$name = $this->setFieldValue($field, $data);
            }
        }

        return $this;
    }

    /**
     * Set Custom Fields
     *
     * @return  $this
     * @since   1.0
     */
    protected function setCustomFields()
    {
        if (count($this->model_registry['customfieldgroups']) > 0) {

            foreach ($this->model_registry['customfieldgroups'] as $group) {

                if ($this->user->id === 0) {
                    $data = null;
                } else {
                    $data = json_decode($this->user->$group);
                }

                $this->user->$group = $this->loadCustomfields($data, $this->model_registry [$group]);
            }
        }

        return $this;
    }

    /**
     * Set Child Data
     *
     * @param   int    $id
     * @param   string $join
     * @param   object $model_registry
     *
     * @return  $this
     * @since   1.0
     */
    public function getChildData($id, $join, $model_registry)
    {
        $this->query->clearQuery();

        $count  = 0;
        $fields = $model_registry['fields'];

        if (count($fields) > 0) {
            foreach ($fields as $field) {
                if ($field['name'] == $join) {
                } else {
                    $count ++;
                    $hold_field = $field['name'];
                    $this->query->select($field['name']);
                }
            }
        }

        $this->query->from($model_registry['table_name']);
        $this->query->where('column', $join, '=', 'integer', $id);

        $results = $this->database->loadObjectList($this->query->getSQL());

        $value = array();
        if ($count == 1) {
            if (count($results) > 0) {
                foreach ($results as $result) {
                    $value[] = $result->$hold_field;
                }
            }
        } else {
            $value = $results;
        }

        return $value;
    }

    /**
     * Set Permission Data
     *
     * @return  $this
     * @since   1.0
     */
    protected function setPermissions()
    {
        if ($this->user->reset_password_code === null) {
            $this->user->reset_password_code = '';
        }

        $this->user->public = 1;

        if (in_array(self::GROUP_ADMINISTRATOR, $this->user->groups)) {
            $this->user->administrator = 1;
        } else {
            $this->user->administrator = 0;
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
     * Return object with custom fields loaded
     *
     * @param   object $data
     * @param   array  $fields
     *
     * @return  stdClass
     * @since   1.0
     */
    protected function loadCustomfields($data, $fields = array())
    {
        $typeObject = new stdClass();

        if (count($fields) > 0) {

            foreach ($fields as $field) {
                $name              = $field['name'];
                $typeObject->$name = $this->setFieldValue($field, $data);
            }
        }

        return $typeObject;
    }

    /**
     * Retrieve value (or default value) for field
     *
     * @param   object      $field
     * @param   null|object $data
     *
     * @return  null|mixed
     */
    protected function setFieldValue($field, $data)
    {
        $name = $field['name'];

        if (isset($data->$name)) {
            $value = $data->$name;

        } elseif (isset($field['default'])) {
            $value = $field['default'];

        } else {
            $value = null;
        }

        return $value;
    }
}
