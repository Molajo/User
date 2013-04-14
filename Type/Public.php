<?php
/**
 * Abstract User Type Class
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   MIT
 */
namespace Molajo\User\Type;

defined('MOLAJO') or die;

use Molajo\User\Api\UserInterface;
use Molajo\User\Exception\UserException;

/**
 * Abstract User Type Class
 *
 * @package   Molajo
 * @license   MIT
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class Public implements UserInterface
{
    /**
     * Action
     *
     * @var     string
     * @since   1.0
     */
    public
    $action;

    /**
     * User Type
     *
     * @var     string
     * @since   1.0
     */
    public
    $user_type;

    /**
     * Options
     *
     * @var     array
     * @since   1.0
     */
    public
    $options;

    /**
     * Construct
     *
     * @param string $action
     * @param string $user_type
     * @param array  $options
     *
     * @since   1.0
     * @throws  UserException
     */
    public
    public function __construct($action = '', $user_type, $options = array())
    {
        $this->setAction($action);
        $this->setUserType($user_type);
        $this->setOptions($options);

        return;
    }

    /**
     * Initialise User
     *
     * @return void
     * @since   1.0
     */
    public
    public function initialise()
    {
        return;
    }

    /**
     * Process User Data
     *
     * @return void
     * @since   1.0
     */
    public
    public function process()
    {
        return;
    }

    /**
     * Finish processing
     *
     * @return void
     * @since   1.0
     */
    public
    public function close()
    {
        return;
    }

    /**
     * Set Action
     *
     * @param string $action
     *
     * @return void
     * @since   1.0
     */
    public
    public function setAction($action)
    {
        $this->action = $action;

        return;
    }

    /**
     * Get Action
     *
     * @return string
     * @since   1.0
     */
    public
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set User Type
     *
     * @param string $user_type
     *
     * @return void
     * @since   1.0
     */
    public
    public function setUserType($user_type)
    {
        $this->user_type = $user_type;

        return;
    }

    /**
     * Get User Type
     *
     * @return string
     * @since   1.0
     */
    public
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * Set Options
     *
     * @param array $options
     *
     * @return void
     * @since   1.0
     */
    public
    public function setOptions($options)
    {
        $this->options = $options;

        return;
    }

    /**
     * Get Options
     *
     * @return array
     * @since   1.0
     */
    public
    public function getOptions()
    {
        return $this->options;
    }
}
