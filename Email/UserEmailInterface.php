<?php
/**
 * User Email Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Email;

defined('MOLAJO') or die;

/**
 * Email Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface UserEmailInterface
{
    /**
     * Send email
     *
     * @return mixed
     * @throws  UserEmailException
     * @since   1.0
     */
    public function send();
}
