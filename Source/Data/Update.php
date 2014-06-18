<?php
/**
 * Update User Data
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Data;

use CommonApi\User\UserDataInterface;

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
     * Update User
     *
     * @param   array  $data
     *
     * @return  $this
     */
    public function updateUser(array $data =array())
    {

    }
}
