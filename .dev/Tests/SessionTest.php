<?php
/**
 * Test User Session
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Tests;

use Molajo\User\Persist\Session;

/**
 * Test User Session
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class SessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $session
     */
    protected $session;

    /**
     * @covers  Molajo\User\Session::startSession
     * @covers  Molajo\User\Session::getSession
     * @covers  Molajo\User\Session::setSession
     * @covers  Molajo\User\Session::deleteSession
     * @covers  Molajo\User\Session::destroySession
     */
    public function setUp()
    {
        $class         = 'Molajo\\User\\Session';
        $this->session = new $class();

        return;
    }

    /**
     * @covers  Molajo\User\Session::startSession
     * @covers  Molajo\User\Session::getSession
     * @covers  Molajo\User\Session::setSession
     * @covers  Molajo\User\Session::deleteSession
     * @covers  Molajo\User\Session::destroySession
     */
    public function testStartSession()
    {
        $this->assertEquals(session_id(), $this->session->getSession('session_id'));
    }

    /**
     * @covers  Molajo\User\Session::startSession
     * @covers  Molajo\User\Session::getSession
     * @covers  Molajo\User\Session::setSession
     * @covers  Molajo\User\Session::deleteSession
     * @covers  Molajo\User\Session::destroySession
     */
    public function testGetSessionId()
    {
        $id = $this->session->getSession('session_id');

        $this->assertEquals(session_id(), $id);
    }

    /**
     * @covers  Molajo\User\Session::startSession
     * @covers  Molajo\User\Session::getSession
     * @covers  Molajo\User\Session::setSession
     * @covers  Molajo\User\Session::deleteSession
     * @covers  Molajo\User\Session::destroySession
     */
    public function testSetGetSession()
    {
        $key   = 'toothpick';
        $value = 'Toothpick';

        $this->session->setSession($key, $value);

        $this->assertEquals($value, $this->session->getSession($key));
    }

    /**
     * @covers  Molajo\User\Session::startSession
     * @covers  Molajo\User\Session::getSession
     * @covers  Molajo\User\Session::setSession
     * @covers  Molajo\User\Session::deleteSession
     * @covers  Molajo\User\Session::destroySession
     */
    public function testSetDeleteGetSession()
    {
        $key   = 'toothpick';
        $value = 'Toothpick';

        $this->session->setSession($key, $value);
        $this->session->deleteSession($key);
        $this->assertEquals(false, $this->session->getSession($key));
    }

    /**
     * @covers  Molajo\User\Session::startSession
     * @covers  Molajo\User\Session::getSession
     * @covers  Molajo\User\Session::setSession
     * @covers  Molajo\User\Session::deleteSession
     * @covers  Molajo\User\Session::destroySession
     */
    public function testSetDeleteNothingGetSession()
    {
        $this->assertEquals(false, $this->session->getSession('doesnotexist'));
    }

    /**
     * @covers  Molajo\User\Session::startSession
     * @covers  Molajo\User\Session::getSession
     * @covers  Molajo\User\Session::setSession
     * @covers  Molajo\User\Session::deleteSession
     * @covers  Molajo\User\Session::destroySession
     */
    public function testDestroySession()
    {
        $this->session->destroySession();

        $this->assertEquals('', session_id());
    }
}
