<?php
/**
 * User Adapter
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   MIT
 */

namespace Molajo\User;

defined('MOLAJO') or die;

use Molajo\User\Exception\UserException;
use Molajo\User\Authentication\Authentication;
use Molajo\User\Authorisation\Authorisation;
/**
 * User Class
 *
 * @package   Molajo
 * @license   MIT
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Class User implements UserInterface
{
    /**
     * User Type
     *
     * @var     object
     * @since   1.0
     */
    public $ct;

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
    public function __construct($action = '', $user_type, $options = array())
    {
        $options = $this->getTimeZone($options);

        if ($user_type == '') {
            $user_type = 'UserType1';
        }

        $class = $this->getUserType($user_type);

        try {
            $this->ct = new $class($action, $user_type, $options);

        } catch (\Exception $e) {
            throw new UserException
            ('Caught this ' . $e->getMessage());
        }

        $this->process();

        $this->close();

        return $this->ct;
    }

    /**
     * Get the User Type (ex., Local, Ftp, Virtual, etc.)
     *
     * @param string $user_type
     *
     * @return string
     * @since   1.0
     * @throws UserException
     */
    protected function getUserType($user_type)
    {
        $class = 'Molajo\\User\\Type\\' . $user_type;

        if (class_exists($class)) {
        } else {
            throw new UserException
            ('User Type Class ' . $class . ' does not exist.');
        }

        return $class;
    }

    /**
     * Process the User
     *
     * @return void
     * @since   1.0
     */
    public function process()
    {
        $this->ct->process();

        return;
    }

    /**
     * Close the Connection
     *
     * @return null
     * @since   1.0
     */
    public function close()
    {
        $this->ct->close();

        return;
    }

    /**
     * Get timezone
     *
     * @param array $options
     *
     * @return array
     * @since   1.0
     */
    protected function getTimeZone($options)
    {
        $timezone = '';

        if (is_array($options)) {
        } else {
            $options = array();
        }

        if (isset($options['timezone'])) {
            $timezone = $options['timezone'];
        }

        if ($timezone === '') {
            if (ini_get('date.timezone')) {
                $timezone = ini_get('date.timezone');
            }
        }

        if ($timezone === '') {
            $timezone = 'UTC';
        }

        ini_set('date.timezone', $timezone);
        $options['timezone'] = $timezone;

        return $options;
    }
}
