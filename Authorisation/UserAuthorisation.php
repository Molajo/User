<?php
/**
 * User Authorisation Class
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Authorisation;

defined('MOLAJO') or die;

use Molajo\Foundation\Permissions\PermissionsInterface;

use Exception;
use Molajo\User\Exception\AuthorisationException;

/**
 * User Authorisation Class
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class UserAuthorisation implements UserAuthorisationInterface
{
    /**
     * Authorisation class Object
     *
     * @var     object  PermissionsInterface
     * @since   1.0
     */
    public $permissions_class;

    /**
     * Construct
     *
     * @param PermissionsInterface $permissions_class
     *
     * @since   1.0
     */
    public function __construct(PermissionsInterface $permissions_class)
    {
        $this->permissions_class = $permissions_class;

        return $this;
    }

    /**
     * Determines if User is Authorised for specific action
     *
     * @param array $request
     *
     * @return mixed
     * @since   1.0
     * @throws  AuthorisationException
     */
    public function isAuthorised(array $request = array())
    {
        if (is_array($request) && count($request) > 0) {
        } else {
            throw new AuthorisationException
            ('Authorisation isAuthorised Failed. Input $request array is empty.');
        }

        if (isset($request['method'])) {
            $method = strtolower($request['method']);

        } else {
            throw new AuthorisationException
            ('Authorisation isAuthorised Failed. Input $request array missing method entry.');
        }

        try {

            if ($method == 'login') {
                return $this->verifyLogin($request);

            } elseif ($method == 'task') {
                return $this->verifyTask($request);

            } elseif ($method == 'tasklist') {
                return $this->verifyTasklist($request);

            } elseif ($method == 'action') {
                return $this->verifyAction($request);

            } elseif ($method == 'htmlfilter') {
                return $this->setHTMLFilter($request);

            } else {
                throw new AuthorisationException
                ('Authorisation Unknown Method: ' . $method);
            }

        } catch (Exception $e) {
            throw new AuthorisationException
            ('Authorisation setHTMLFilter Failed ' . $e->getMessage());
        }
    }

    /**
     * Verify Logon
     *
     * @param array $request
     *
     * @return bool
     * @since   1.0
     * @throws  AuthorisationException
     */
    protected function verifyLogin(array $request = array())
    {
        if (isset($request['user_id'])) {
            $user_id = strtolower($request['user_id']);

        } else {

            throw new AuthorisationException
            ('Authorisation verifyLogin Failed $user_id not provided');
        }

        try {
            return $this->permissions_class->verifyLogin($user_id);

        } catch (Exception $e) {

            throw new AuthorisationException
            ('Authorisation verifyLogin Failed ' . $e->getMessage());
        }
    }

    /**
     * Verify Task
     *
     * @param array $request
     *
     * @return bool
     * @since   1.0
     * @throws  AuthorisationException
     */
    protected function verifyTask(array $request = array())
    {
        if (isset($request['action'])) {
            $action = strtolower($request['action']);

        } else {

            throw new AuthorisationException
            ('Authorisation verifyLogin Failed $action not provided');
        }

        if (isset($request['catalog_id'])) {
            $catalog_id = strtolower($request['catalog_id']);

        } else {

            throw new AuthorisationException
            ('Authorisation verifyLogin Failed $catalog_id not provided');
        }

        try {
            return $this->permissions_class->verifyTask($action, $catalog_id);

        } catch (Exception $e) {

            throw new AuthorisationException
            ('Authorisation verifyTask Failed ' . $e->getMessage());
        }
    }

    /**
     * Verify Task List
     *
     * @param array $request
     *
     * @return mixed
     * @since   1.0
     * @throws  AuthorisationException
     */
    protected function verifyTaskList(array $request = array())
    {
        if (isset($request['action'])) {
            $actionlist = strtolower($request['action']);

        } else {

            throw new AuthorisationException
            ('Authorisation verifyLogin Failed $action not provided');
        }

        if (isset($request['catalog_id'])) {
            $catalog_id = strtolower($request['catalog_id']);

        } else {

            throw new AuthorisationException
            ('Authorisation verifyLogin Failed $catalog_id not provided');
        }

        try {
            return $this->permissions_class->verifyTaskList($actionlist, $catalog_id);

        } catch (Exception $e) {

            throw new AuthorisationException
            ('Authorisation verifyTask Failed ' . $e->getMessage());
        }
    }

    /**
     * Verify Action
     *
     * @param array $request
     *
     * @return bool
     * @since   1.0
     * @throws  AuthorisationException
     */
    protected function verifyAction(array $request = array())
    {
        if (isset($request['view_group_id'])) {
            $view_group_id = strtolower($request['view_group_id']);

        } else {

            throw new AuthorisationException
            ('Authorisation verifyAction Failed $view_group_id not provided');
        }

        if (isset($request['request_action'])) {
            $request_action = strtolower($request['request_action']);

        } else {

            throw new AuthorisationException
            ('Authorisation verifyAction Failed $request_action not provided');
        }

        if (isset($request['catalog_id'])) {
            $catalog_id = strtolower($request['catalog_id']);

        } else {

            throw new AuthorisationException
            ('Authorisation verifyAction Failed $catalog_id not provided');
        }

        try {
            return $this->permissions_class->verifyAction($view_group_id, $request_action, $catalog_id);

        } catch (Exception $e) {

            throw new AuthorisationException
            ('Authorisation verifyAction Failed ' . $e->getMessage());
        }
    }

    /**
     * Determines if User Content must be filtered
     *
     * @param array $request
     *
     * @return mixed
     * @since   1.0
     * @throws  AuthorisationException
     */
    protected function setHTMLFilter(array $request = array())
    {
        if (isset($request['key'])) {
            $key = strtolower($request['key']);

        } else {

            throw new AuthorisationException
            ('Authorisation setHTMLFilter Failed $key not provided');
        }

        try {
            return $this->permissions_class->setHTMLFilter($key);

        } catch (Exception $e) {
            throw new AuthorisationException
            ('Authorisation setHTMLFilter Failed ' . $e->getMessage());
        }
    }
}
