<?php
/**
 * User Data Load
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Data;

use Exception;
use stdClass;
use CommonApi\Exception\RuntimeException;
use CommonApi\User\UserDataInterface;

/**
 * User Data
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Load extends Insert implements UserDataInterface
{
    /**
     * Get user data using a value for id, username, email or initialise new user
     *
     * @param   null|string $value
     * @param   null|string $key
     *
     * @return  $this
     */
    public function loadUser($value = null, $key = 'username')
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

        } elseif ($key === 'id') {
            $column            = 'id';
            $data_type         = 'userid';
            $this->user->guest = 0;

        } elseif ($key === 'email') {
            $column            = 'email';
            $data_type         = 'email';
            $this->user->guest = 0;

        } elseif ($key === 'username') {
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
            (
                'Userdata::getUser Failed: ' . $e->getMessage()
            );
        }

        return $data;
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
                if ($field['name'] === $join) {
                } else {
                    $count++;
                    $hold_field = $field['name'];
                    $this->query->select($field['name']);
                }
            }
        }

        $this->query->from($model_registry['table_name']);
        $this->query->where('column', $join, '=', 'integer', $id);

        $results = $this->database->loadObjectList($this->query->getSQL());

        $value = array();
        if ($count === 1) {
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
}
