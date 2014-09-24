<?php
/**
 * User Activity Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\User;

use CommonApi\Database\DatabaseInterface;
use CommonApi\User\MessagesInterface;
use CommonApi\User\ActivityInterface;
use CommonApi\Query\QueryInterface;
use CommonApi\Exception\RuntimeException;

/**
 * User Activity Class
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Activity implements ActivityInterface
{
    /**
     * Guest
     *
     * @var    boolean
     * @since  1.0
     */
    protected $guest;

    /**
     * Database Instance
     *
     * @var    object  CommonApi\Database\DatabaseInterface
     * @since  1.0
     */
    protected $database;

    /**
     * Query Instance
     *
     * @var    object  CommonApi\Query\QueryInterface
     * @since  1.0
     */
    protected $query;

    /**
     * Messages Instance
     *
     * @var    object  CommonApi\User\MessagesInterface
     * @since  1.0
     */
    protected $messages;

    /**
     * activity_id
     *
     * @var    int
     * @since  1.0
     */
    protected $activity_id;

    /**
     * ID for visitor
     *
     * @var    int
     * @since  1.0
     */
    protected $id;

    /**
     * User ID
     *
     * @var    int
     * @since  1.0
     */
    protected $user_id;

    /**
     * Action ID
     *
     * @var    int
     * @since  1.0
     */
    protected $action_id;

    /**
     * Catalog ID
     *
     * @var    int
     * @since  1.0
     */
    protected $catalog_id;

    /**
     * Session ID
     *
     * @var    int
     * @since  1.0
     */
    protected $session_id;

    /**
     * Activity Date Time
     *
     * @var    string
     * @since  1.0
     */
    protected $activity_datetime;

    /**
     * IP Address
     *
     * @var    string
     * @since  1.0
     */
    protected $ip_address;

    /**
     * Activity
     *
     * @var    array
     * @since  1.0
     */
    protected $activity;

    /**
     * Updates
     *
     * @var    array
     * @since  1.0
     */
    protected $updates;

    /**
     * List of Properties
     *
     * @var    object
     * @since  1.0
     */
    protected $property_array
        = array(
            'activity_id',
            'id',
            'user_id',
            'action_id',
            'catalog_id',
            'session_id',
            'activity_datetime',
            'ip_address',
            'activity'
        );

    /**
     * Construct
     *
     * @param  DatabaseInterface $database
     * @param  QueryInterface    $query
     * @param  MessagesInterface $messages
     * @param  int               $id
     *
     * @since  1.0
     */
    public function __construct(
        DatabaseInterface $database,
        QueryInterface $query,
        MessagesInterface $messages,
        $id = 0
    ) {
        $this->database = $database;
        $this->query    = $query;
        $this->messages = $messages;

        if ($id === 0) {
            $this->guest = true;
        } else {
            $this->guest = false;
        }

        $this->getUser($id);
    }

    /**
     * GetDate
     *
     * @return  object  DateTime
     * @since   1.0
     */
    public function getDate()
    {
        return $this->query->getDate();
    }

    /**
     * Get the current value (or default) of the specified key or all User Data for null key
     *
     * @param   null|string $key
     * @param   null|mixed  $default
     *
     * @return  mixed
     * @since   1.0
     */
    public function get($key = null, $default = null)
    {
        if ($this->$key === null) {
            $this->$key = $default;
        }

        return $this->$key;
    }

    /**
     * Set the value of a specified key
     *
     * @param   string $key
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0
     */
    public function set($key, $value = null)
    {
        $this->$key = $value;

        return $this;
    }

    /**
     * Lookup User using the Id, Username or email address
     * automatically executed during class instantiation
     *
     * @param  string $id
     *
     * @return  $this
     * @since   1.0
     */
    protected function getUser($id)
    {
        $this->getUserActivity($id);

        return $this;
    }

    /**
     * Retrieve User Activity
     *
     * @param   string $id
     *
     * @return  $this
     * @since   1.0
     */
    protected function getUserActivity($id)
    {
        if ($this->guest === false) {

            $this->query->clearQuery();

            $this->query->select('*');
            $this->query->from('#__user_activity');
            $this->query->where('column', 'user_id', '=', 'integer', $id);
            $this->query->orderBy('activity_datetime', 'DESC');

            $data = $this->database->loadObjectList($this->query->getSQL());

            if (is_array($data) && count($data) > 0) {
                $this->activity = $data;
            }
        }

        return $this;
    }

    /**
     * Update User Activity
     *
     * @param   array $updates
     *
     * @return  $this
     * @since   1.0
     */
    public function updateUserActivity(array $updates = array())
    {
        if (count($updates) > 0) {
            $this->updates = $updates;
        } else {
            return $this;
        }

        $this->query->clearQuery();

        $this->query->setType('update');

        foreach ($this->updates as $field => $value) {
            $this->query->select($field, null, $value);
        }
        $this->query->from('#__user_activity');
        $this->query->where('column', 'id', '=', 'integer', (int)$this->activity_id);

//echo $this->query->getSQL();

        $results = $this->database->execute($this->query->getSQL());

        if ($results === false) {
            $this->messages->throwException(1700, array(), 'CommonApi\\Exception\\RuntimeException');
        }

        $this->getUserActivity($this->id);

        $this->updates = array();

        return $this;
    }

    /**
     * Delete User Activity
     *
     * @return  $this
     * @since   1.0
     * @throws  RuntimeException
     */
    public function deleteUserActivity()
    {
        $this->query->clearQuery();

        $this->query->setType('delete');
        $this->query->from('#__user_activity');
        $this->query->where('column', 'id', '=', 'integer', (int)$this->activity_id);

        $results = $this->database->execute($this->query->getSQL());

        if ($results === false) {
            $this->messages->throwException(1800, array(), 'CommonApi\\Exception\\RuntimeException');
        }

        $this->getUser($this->id);

        $this->updates = array();

        return $this;
    }
}
