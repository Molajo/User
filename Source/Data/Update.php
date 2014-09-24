<?php
/**
 * Update User Data
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Data;

use CommonApi\Database\DatabaseInterface;
use CommonApi\Exception\RuntimeException;
use CommonApi\Query\QueryInterface;
use CommonApi\User\UserDataInterface;
use Exception;

/**
 * Update User Data
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Update extends Delete implements UserDataInterface
{

    /**
     * Fields
     *
     * @var    array()
     * @since  1.0
     */
    protected $fields = array();

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
        parent::__construct($database, $query, $model_registry, $child_model_registries);

        $this->fields = array();
        foreach ($this->model_registry['fields'] as $field) {
            $this->fields[$field['name']] = $field;
        }
    }

    /**
     * Update User
     *
     * @param   array $data
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function updateUser(array $data = array())
    {
        try {
            $this->query->clearQuery();

            $this->query->setType('update');
            $this->query->from('#__users');
            $this->query->where('column', 'id', '=', 'integer', $this->user->id);

            foreach ($data as $key => $value) {
                if (isset($this->fields[$key])) {
                    $this->query->select($key, null, $value, $this->fields[$key]['type']);
                }
            }

            $this->database->execute($this->query->getSQL());

        } catch (Exception $e) {
            throw new RuntimeException('Userdata::updateUser Failed: ' . $e->getMessage());
        }

        return $this;
    }
}
