<?php
/**
 * Insert User Data
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Data;

use CommonApi\User\UserDataInterface;

/**
 * Insert User Data
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Insert extends Update implements UserDataInterface
{
    /**
     * Insert User
     *
     * @param   array $data
     *
     * @return  $this
     */
    public function insertUser(array $data = array())
    {

    }
}
