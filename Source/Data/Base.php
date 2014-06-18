<?php
/**
 * User Data Load
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Data;

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
abstract class Base implements UserDataInterface
{
    /**
     * User Group Constants
     *
     * @since  1.0
     */
    const GROUP_ADMINISTRATOR = 1;
    const GROUP_PUBLIC = 2;
    const GROUP_GUEST = 3;
    const GROUP_REGISTERED = 4;

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
