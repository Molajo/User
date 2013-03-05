<?php
/**
 * Password Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Password;

defined('MOLAJO') or die;

/**
 * Password Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface PasswordInterface
{
    /**
     * Verify Password
     *
     * @param   array  $request
     *
     * @return  bool
     * @since   1.0
     */
    public function verify(array $request);

    /**
     * Change Password
     *
     * @param   array  $request
     *
     * @return  string
     * @since   1.0
     */
    public function change(array $request);

    /**
     * Salt Password
     *
     * @param   array  $request
     *
     * @return  string
     * @since   1.0
     */
    function salt(array $request);
}
