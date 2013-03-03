<?php
/**
 * Test User Sessions
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Tests;

defined('MOLAJO') or die;

use RuntimeException;
use Molajo\User\Session\Session;

/**
 * Test User Sessions
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class UserSessionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $SessionsClass
     */
    protected $SessionsClass;

    /**
     * Set up
     */
    public function setUp()
    {
        $class               = 'Molajo\\User\\Session\\Session';
        $this->SessionsClass = new $class;

        return;
    }

    /**
     * @covers Molajo\User\Session\Session::start
     */
    public function testStart()
    {
        $started = $this->SessionsClass->start();

        $this->assertEquals(session_id(), $started);
    }

    /**
     * @covers Molajo\User\Session\Session::start
     */
    public function testGetSessionId()
    {
        $id = $this->SessionsClass->getSessionId();

        $this->assertEquals(session_id(), $id);
    }

    /**
     * @covers Molajo\User\Session\Session::exists
     */
    public function testExists()
    {
        $key   = 'MolajoSessions';
        $value = 'dogfood';

        $_SESSION[$key] = $value;

        $this->assertTrue($this->SessionsClass->exists($key));
    }

    /**
     * @covers Molajo\User\Session\Session::exists
     */
    public function testExistsFalse()
    {
        $key = 'MolajoSessions';

        $this->assertFalse($this->SessionsClass->exists($key));
    }

    /**
     * @covers Molajo\User\Session\Session::set
     */
    public function testSet()
    {
        $key   = 'MolajoSessions';
        $value = 'Toothpick';

        $this->SessionsClass->set($key, $value);

        $value2 = htmlspecialchars_decode($_SESSION[$key]);
        $new    = @unserialize($value2);
        $this->assertEquals($value, $new);
    }

    /**
     * @covers Molajo\User\Session\Session::get
     */
    public function testGet()
    {
        $key   = 'MolajoSessions';
        $value = 'Toothpick';

        $this->SessionsClass->set($key, $value);

        $get = $this->SessionsClass->get($key);

        $value2 = htmlspecialchars_decode($_SESSION[$key]);
        $new    = @unserialize($value2);
        $this->assertEquals($new, $get);
    }

    /**
     * @covers Molajo\User\Session\Session::get
     * @expectedException  Molajo\User\Exception\SessionException
     */
    public function testGetFail()
    {
        $key = 'MolajoSessionsDoesNotExist';

        $this->SessionsClass->get($key);
    }

    /**
     * @covers Molajo\User\Session\Session::delete
     * @expectedException  Molajo\User\Exception\SessionException
     */
    public function testDelete()
    {
        $this->SessionsClass->set('MolajoSessions1', 'Toothpick 1');
        $this->SessionsClass->set('MolajoSessions2', 'Toothpick 2');
        $this->SessionsClass->set('MolajoSessions3', 'Toothpick 3');

        $this->SessionsClass->delete('MolajoSessions3');
        $this->SessionsClass->get('MolajoSessions3');
    }

    /**
     * @covers Molajo\User\Session\Session::destroy
     */
    public function testDestroy()
    {
        $this->SessionsClass->destroy();

        $this->assertEquals('', session_id());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

}
