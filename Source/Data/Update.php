<?php
/**
 * Update User Data
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Data;

/**
 * Update User Data
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Update extends Delete
{
    /**
     * Update User
     *
     * @param   array $data
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function updateUserData(array $data = array())
    {
        $this->setQueryController('Molajo//Model//Datasource//User.xml', 'Update');

        $this->setQueryControllerDefaults(
            $process_events = 1,
            $query_object = 'item',
            $get_customfields = 1,
            $use_special_joins = 0,
            $use_pagination = 0,
            $check_view_level_access = 1,
            $get_item_children = 0
        );

        $this->setModelRegistry();

        foreach ($data as $key => $value) {
            if (isset($this->model_registry['fields'][$key])) {
                $this->query->select($key, null, $value, $this->model_registry['fields'][$key]['type']);
            }
        }

        $this->query->where('column', 'id', '=', 'integer', (int)$this->user->id);

        $this->runQuery('updateData');

        return $this;
    }
}
