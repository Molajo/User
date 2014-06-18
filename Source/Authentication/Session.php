<?php
/**
 * Session Handling for User Authentication
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use CommonApi\Model\FieldhandlerInterface;
use CommonApi\User\AuthenticationInterface;
use CommonApi\User\CookieInterface;
use CommonApi\User\EncryptInterface;
use CommonApi\User\MailerInterface;
use CommonApi\User\MessagesInterface;
use CommonApi\User\SessionInterface;
use CommonApi\User\UserDataInterface;
use stdClass;

/**
 * Session Handling for User Authentication
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Session extends Cookie implements AuthenticationInterface
{
    /**
     * Session Instance
     *
     * @var    object  CommonApi\User\SessionInterface
     * @since  1.0
     */
    protected $session;

    /**
     * Session ID
     *
     * @var    string
     * @since  1.0
     */
    protected $session_id;

    /**
     * External Session ID
     *
     * @var    string
     * @since  1.0
     */
    protected $external_session_id;

    /**
     * Construct
     *
     * @param  UserDataInterface     $userdata
     * @param  SessionInterface      $session
     * @param  CookieInterface       $cookie
     * @param  MailerInterface       $mailer
     * @param  MessagesInterface     $messages
     * @param  EncryptInterface      $encrypt
     * @param  FieldhandlerInterface $fieldhandler
     * @param  stdClass              $configuration
     * @param  object                $server
     * @param  object                $post
     * @param  string                $external_session_id
     *
     * @since  1.0
     */
    public function __construct(
        UserDataInterface $userdata,
        SessionInterface $session,
        CookieInterface $cookie,
        MailerInterface $mailer,
        MessagesInterface $messages,
        EncryptInterface $encrypt,
        FieldhandlerInterface $fieldhandler,
        $configuration,
        $server,
        $post,
        $external_session_id
    ) {
        $this->session             = $session;
        $this->external_session_id = $external_session_id;

        parent::__construct(
            $userdata,
            $cookie,
            $mailer,
            $messages,
            $encrypt,
            $fieldhandler,
            $configuration,
            $server,
            $post
        );
    }

    /**
     * Verifies the session given the action
     *
     * @param   string $session_id
     * @param   string $action
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifySession($session_id, $action)
    {
        $this->verifySessionNotEmpty($session_id);

        if ($action === 'isGuest') {
            return $this->verifySessionGuest($session_id);
        }

        if ($action === 'login' || $action === 'changePassword' || $action === 'requestPasswordReset') {
            return $this->verifySessionCredentialAction($session_id, $action);
        }

        if ($this->verifySessionLoggedOn($session_id) === true) {
            return $this;
        };

        $this->throwExceptionMessage(1900, array(), 'CommonApi\\Exception\\RuntimeException');

        return $this;
    }

    /**
     * Verifies the session for a guest
     *
     * @param   string $session_id
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifySessionGuest($session_id)
    {
        if ($this->verifySessionIdToExternal($session_id) === true && $this->user->username === '') {
        } else {
            $this->session_id = $session_id;
        }

        $this->throwExceptionMessage(1800, array(), 'CommonApi\\Exception\\RuntimeException');

        return $this;
    }

    /**
     * Verifies the session for an action calling for credentials (login, password change, etc.)
     *
     * @param   string $session_id
     * @param   string $action
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifySessionCredentialAction($session_id, $action)
    {
        if ($this->verifySessionIdToExternal($session_id) === true) {
        } else {
            $this->session_id = $session_id;
        }

        $values           = array();
        $values['action'] = $action;
        $this->throwExceptionMessage(1805, $values, 'CommonApi\\Exception\\RuntimeException');

        return $this;
    }

    /**
     * Verifies the session for a user already logged on
     *
     * @param   string $session_id
     *
     * @return  boolean
     * @since   1.0
     */
    protected function verifySessionLoggedOn($session_id)
    {
        $logged_on = true;

        if ($this->verifySessionIdToExternal($session_id) === true) {
        } else {
            $logged_on = false;
        }

        if ($this->verifySessionIdToUser($session_id, 'username') === true) {
        } else {
            $logged_on = false;
        }

        if ($this->verifySessionIdToUser($this->user->username, 'session_id') === true) {
        } else {
            $logged_on = false;
        }

        if ($logged_on === true) {
            $this->session_id = $session_id;
        }

        return $logged_on;
    }

    /**
     * Verifies whether or not the Session has timed out
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifySessionNotTimedOut()
    {
        $last_activity_datetime = $this->getSessionValue('last_activity_datetime');

        $time_out = $last_activity_datetime + ($this->configuration->session_expires_minutes * 60);

        if ($time_out < time()) {
            $this->error = true;
            session_regenerate_id(true);

            //todo time out?

        } else {
            $this->setSessionValue('last_activity_datetime', time());
        }

        return $this;
    }

    /**
     * Verify Form Action
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function verifyFormAction()
    {
        if (in_array($this->server['REQUEST_METHOD'], array('POST', 'PUT', 'DELETE'))) {
            $this->verifySessionFormToken();
        }

        return $this;
    }

    /**
     * Verifies the token for the user
     *
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function verifySessionFormToken()
    {
        $key = $this->getSessionValue('form_token');

        if (isset($this->post[$key])) {
            return true;
        }

        $this->destroySession();
        $this->forgetCookie();
        $this->throwExceptionMessage(2000);

        return $this;
    }

    /**
     * Set the Form Token in the Session Object
     *
     * @return  $this
     * @since   1.0
     */
    protected function setSessionFormToken()
    {
        if ($this->getSessionValue('form_token') === false) {
            $token = $this->generateString();
            $this->setSessionValue('form_token', $token);
        }

        return $this;
    }

    /**
     * Sets the session for a successful login
     *
     * @return  $this
     * @since   1.0
     */
    protected function setSessionLogin()
    {
        $this->destroySession();

        $this->session_id = $this->getSessionValue('session_id');

        $this->setSessionValue($this->session_id, $this->user->username);
        $this->setSessionValue($this->user->username, $this->session_id);

        $this->setSessionValue('login_datetime', time());
        $this->setSessionValue('last_activity_datetime', time());

        $this->updateUserSessionId($this->session_id);

        return $this;
    }

    /**
     * Verifies the session between the user table and the session object
     *
     * @param   string $session_id
     *
     * @return  boolean
     * @since   1.0
     */
    protected function verifySessionIdToExternal($session_id)
    {
        if ($this->external_session_id === $session_id) {
            return true;
        }

        return false;
    }

    /**
     * Verifies the session between the user table and the session object
     *
     * @param   string $type
     *
     * @return  boolean
     * @since   1.0
     */
    protected function verifySessionIdToUser($key, $type)
    {
        if ($this->getSessionValue($key) === $this->user->$type) {
            return true;
        }

        return false;
    }

    /**
     * Verifies the session is not empty
     *
     * @param   string $session_id
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifySessionNotEmpty($session_id)
    {
        if (trim($session_id) === '') {
            $this->throwExceptionMessage(300);
        }
    }

    /**
     * Get the value for Session Key
     *
     * @param   string $key
     *
     * @return  $this
     * @since   1.0
     */
    protected function getSessionValue($key)
    {
        return $this->session->getSession($key);
    }

    /**
     * Set the value for Session Key
     *
     * @param   string $key
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0
     */
    protected function setSessionValue($key, $value)
    {
        $this->session->setSession($key, $value);

        return $this;
    }

    /**
     * Destroy the Session
     *
     *
     * @return  $this
     * @since   1.0
     */
    protected function destroySession()
    {
        return $this->session->destroySession();
    }
}
