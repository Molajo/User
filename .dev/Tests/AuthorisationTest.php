<?php
/**
 * Authorisation Test
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Tests;

use RuntimeException;

/**
 * Test User Authorisation
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class AuthorisationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $PermissionClass
     */
    protected $PermissionClass;

    /**
     * @var $AuthorisationClass
     */
    protected $AuthorisationClass;

    /**
     * Set up
     */
    public function setUp()
    {
        $class                    = 'Molajo\\Foundation\\Permissions\\Permissions';
        $this->PermissionClass    = new $class;

        $class                    = 'Molajo\\User\\Authorisation\\Authorisation';
        $this->AuthorisationClass = new $class($this->PermissionClass) ;

        return;
    }

    /**
     * @covers Molajo\User\Authorisation\Authorisation::verifyLogin
     */
    public function testVerifyLogin()
    {
        $id = 1;
        $login = $this->AuthorisationClass->verifyLogin($id);

        $this->assertEquals(true, $login);
    }

    /**
     * @covers Molajo\User\Authorisation\Authorisation::verifyTask
     */
    public function testVerifyTask()
    {
        $actionList = array();
        $actionList[] = 'read';
        $actionList[] = 'write';
        $actionList[] = 'update';

        $task = $this->AuthorisationClass->verifyTask('view', 1);

        $this->assertEquals(true, $task);
    }

    /**
     * @covers Molajo\User\Authorisation\Authorisation::verifyTask
     */
    public function testVerifyActionTest()
    {
        $view_group_id  = 1;
        $request_action = 'read';
        $catalog_id     = 1;

        $action = $this->AuthorisationClass->verifyAction($view_group_id, $request_action, $catalog_id);

        $this->assertEquals(true, $action);
    }

    /**
     * @covers Molajo\User\Authorisation\Authorisation::setHTMLFilter
     */
    public function testSetHTMLFilter()
    {
        $key = 'MolajoAuthorisation';

        $result = $this->AuthorisationClass->setHTMLFilter($key);

        $this->assertEquals(true, $result);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

}
