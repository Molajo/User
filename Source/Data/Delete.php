<?php
/**
 * Delete User Data
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Data;

use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\User\UserDataInterface;

/**
 * Delete User Data
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Delete extends Query implements UserDataInterface
{
    /**
     * Delete User Data
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function deleteUserdata()
    {
        try {

            $this->query->where('column', 'id', '=', 'integer', (int)$this->user->id);

            $this->query->execute($this->query->getSQL());

        } catch (Exception $e) {
            throw new RuntimeException(
                'Userdata::deleteUserdata Failed: ' . $e->getMessage()
            );
        }

        return $this;
    }
}
