<?php
namespace Molajo\Tests;

use Molajo\User\Type\UserType1;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-17 at 11:54:00.
 */
class UserType1Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserType1
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $action         = '';
        $user_type = 'UserType1';
        $options        = array();

        $this->object = new UserType1($action, $user_type, $options);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Molajo\User\Type\UserType1::initialise
     * @todo   Implement testInitialise().
     */
    public function testInitialise()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Molajo\User\Type\UserType1::process
     * @todo   Implement testProcess().
     */
    public function testProcess()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Molajo\User\Type\UserType1::close
     * @todo   Implement testClose().
     */
    public function testClose()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
