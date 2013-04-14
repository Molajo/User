<?php
/**
 * User Authorisation Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authorisation;

defined('MOLAJO') or die;

use Molajo\User\Exception\UserAuthorisationException;

/**
 * User Authorisation Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface UserAuthorisationInterface
{
    /**
     * Is Authorised passes through the authorisation request
     * to a specialized Authorisation class
     *
     * @param array $request
     *
     * @return mixed
     * @since   1.0
     * @throws  UserAuthorisationException
     */
    public function isAuthorised(array $request = array());
}
