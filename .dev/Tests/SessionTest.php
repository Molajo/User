<?php
/**
 * Test User Session
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
 * Test User Session
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class SessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $SessionClass
     */
    protected $SessionClass;

    /**
     * Set up
     */
    public function setUp()
    {
        $class               = 'Molajo\\User\\Session\\Session';
        $this->SessionClass = new $class;

        return;
    }

    /**
     * @covers Molajo\User\Session\Session::start
     */
    public function testStart()
    {
        $started = $this->SessionClass->start();

        $this->assertEquals(session_id(), $started);
    }

    /**
     * @covers Molajo\User\Session\Session::testGetSessionId
     */
    public function testGetSessionId()
    {
        $id = $this->SessionClass->getSessionId();

        $this->assertEquals(session_id(), $id);
    }

    /**
     * @covers Molajo\User\Session\Session::exists
     */
    public function testExists()
    {
        $key   = 'MolajoSession';
        $value = 'dogfood';

        $_SESSION[$key] = $value;

        $this->assertTrue($this->SessionClass->exists($key));
    }

    /**
     * @covers Molajo\User\Session\Session::exists
     */
    public function testExistsFalse()
    {
        $key = 'MolajoSession';

        $this->assertFalse($this->SessionClass->exists($key));
    }

    /**
     * @covers Molajo\User\Session\Session::set
     */
    public function testSet()
    {
        $key   = 'MolajoSession';
        $value = 'Toothpick';

        $this->SessionClass->set($key, $value);

        $value2 = htmlspecialchars_decode($_SESSION[$key]);
        $new    = @unserialize($value2);
        $this->assertEquals($value, $new);
    }

    /**
     * @covers Molajo\User\Session\Session::get
     */
    public function testGet()
    {
        $key   = 'MolajoSession';
        $value = 'Toothpick';

        $this->SessionClass->set($key, $value);

        $get = $this->SessionClass->get($key);

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
        $key = 'MolajoSessionDoesNotExist';

        $this->SessionClass->get($key);
    }

    /**
     * @covers Molajo\User\Session\Session::delete
     * @expectedException  Molajo\User\Exception\SessionException
     */
    public function testDelete()
    {
        $this->SessionClass->set('MolajoSession1', 'Toothpick 1');
        $this->SessionClass->set('MolajoSession2', 'Toothpick 2');
        $this->SessionClass->set('MolajoSession3', 'Toothpick 3');

        $this->SessionClass->delete('MolajoSession3');
        $this->SessionClass->get('MolajoSession3');
    }

    /**
     * @covers Molajo\User\Session\Session::destroy
     */
    public function testDestroy()
    {
        $this->SessionClass->destroy();

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
