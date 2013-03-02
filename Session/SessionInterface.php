<?php
/**
 * Session Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Session;

defined('MOLAJO') or die;

/**
 * Session Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface SessionInterface
{
    /**
     * open
     *
     * @param   array $credentials
     *
     * @return  bool
     * @since   1.0
     * @throws  SessionException
     */
    public function open($savePath, $sessionName);

    /**
     * Get User
     *
     * @return  object  UserInterface
     * @since   1.0
     * @throws  SessionException
     */
    public function read($id);

    /**
     * Get User
     *
     * @return  object  UserInterface
     * @since   1.0
     * @throws  SessionException
     */
    public function write($id, $data);

    /**
     * Get User
     *
     * @return  object  UserInterface
     * @since   1.0
     * @throws  SessionException
     */
    public function remove($id);

    /**
     * Get User
     *
     * @return  object  UserInterface
     * @since   1.0
     * @throws  SessionException
     */
    public function clean($maxlifetime);

    /**
     * Close
     *
     * @return  bool
     * @since   1.0
     * @throws  SessionException
     */
    public function close();
}
