<?php
/**
 * UserEmailInterface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Service\Adapter;

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
     * Send the activation email
     *
     * @param \User\Entity\User $from
     * @param \User\Entity\User $to
     * @param string            $subject
     * @param string            $emailContent
     *
     * @return mixed
     */
    public function sendEmail();
}
