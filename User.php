<?php
/**
 * User Class
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   MIT
 */

namespace Molajo\User;

defined('MOLAJO') or die;

use Molajo\User\Exception\UserException;
use Molajo\User\Authentication\Authentication;
use Molajo\User\Authorisation\UserAuthorisation;

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
     * UserType Interface
     *
     * @var     object  UserTypeInterface
     * @since   1.0
     */
    public $user_type;

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
    public function __construct(UserTypeInterface $user_type,


        $action = '', $user_type, $options = array())
    {
        $options = $this->getTimeZone($options);


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
