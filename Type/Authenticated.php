<?php
/**
 * User Type2 Concrete Class
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   MIT
 */
namespace Molajo\User\Type;

use Molajo\User\Exception\UserException;

defined('MOLAJO') or die;

/**
 * User Type2 Concrete Class
 *
 * @package   Molajo
 * @license   MIT
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Class Authenticated extends Public
{
    /**
     * Construct
     *
     * @param string $action
     * @param string $user_type
     * @param array  $options
     *
     * @since   1.0
     * @throws UserException
     */
    public
    function __construct($action = '', $user_type, $options = array())
    {
        return parent::__construct($action, $user_type, $options);
    }

    /**
     * Initialise User
     *
     * @return  void
     * @since   1.0
     */
    public
    function initialise()
    {
        parent::initialise();

        return;
    }

    /**
     * Process User Data
     *
     * @return  void
     * @since   1.0
     */
    public
    function process()
    {
        parent::process();

        return;
    }

    /**
     * Finish processing
     *
     * @return  void
     * @since   1.0
     */
    public
    function close()
    {
        parent::close();

        return;
    }
}
