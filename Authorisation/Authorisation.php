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
Class Authorisation implements AuthorisationInterface
{
    /**
     * Authorisation Class Object
     *
     * @var     object
     * @since   1.0
     */
    public $authorisation_class;

    /**
     * Construct
     *
     * @param   object  $authorisation_class
     *
     * @since   1.0
     * @throws  AuthorisationException
     */
    public function __construct($authorisation_class)
    {
        $this->authorisation_class = $authorisation_class;

        if (class_exists($this->authorisation_class)) {
        } else {
            throw new AuthorisationException
            ('User Authorisation Class ' . $this->authorisation_class . ' does not exist.');
        }

        return $this;
    }

    /**
     * Verify Logon
     *
     * @param   int  $user_id
     *
     * @return  bool
     * @since   1.0
     * @throws  AuthorisationException
     */
    public function verifyLogin($user_id)
    {
        try {
            return $this->authorisation_class->verifyLogin($user_id);

        } catch (Exception $e) {
            throw new AuthorisationException
            ('Authorisation verifyLogin Failed ' . $e->getMessage());
        }
    }

    /**
     * Verify Task
     *
     * @param   string  $action
     * @param   string  $catalog_id
     *
     * @return  bool
     * @since   1.0
     * @throws  AuthorisationException
     */
    public function verifyTask($action, $catalog_id)
    {
        try {
            return $this->authorisation_class->verifyTask($action, $catalog_id);

        } catch (Exception $e) {
            throw new AuthorisationException
            ('Authorisation verifyTask Failed ' . $e->getMessage());
        }
    }

    /**
     * Verify Action
     *
     * @param   string  $view_group_id
     * @param   string  $request_action
     * @param   string  $catalog_id
     *
     * @return  bool
     * @since   1.0
     * @throws  AuthorisationException
     */
    public function verifyAction($view_group_id, $request_action, $catalog_id)
    {
        try {
            return $this->authorisation_class->verifyAction($view_group_id, $request_action, $catalog_id);

        } catch (Exception $e) {
            throw new AuthorisationException
            ('Authorisation verifyAction Failed ' . $e->getMessage());
        }
    }

    /**
     * Determines if User Content must be filtered
     *
     * @param   bool  $key
     *
     * @return  mixed
     * @since   1.0
     * @throws  AuthorisationException
     */
    public function setHTMLFilter($key)
    {
        try {
            return $this->authorisation_class->setHTMLFilter($key);

        } catch (Exception $e) {
            throw new AuthorisationException
            ('Authorisation setHTMLFilter Failed ' . $e->getMessage());
        }
    }

}
