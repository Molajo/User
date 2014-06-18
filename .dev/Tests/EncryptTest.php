<?php
/**
 * Test User Encrypt
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Tests;

use Molajo\User\Encrypt;
use Molajo\User\Mocks\MockFlashmessage as Flashmessage;
use Molajo\User\Messages;

require_once __DIR__ . '/Files/jsonRead.php';
require_once __DIR__ . '/Mocks/FlashMessage.php';

/**
 * Test User Encrypt
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class EncryptTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $encrypt
     */
    protected $encrypt;

    /**
     * @covers  Molajo\User\Encrypt::__construct
     * @covers  Molajo\User\Encrypt::createHashString
     * @covers  Molajo\User\Encrypt::verifyHashString
     * @covers  Molajo\User\Encrypt::generateString
     * @covers  Molajo\User\Encrypt::generateStringOperation
     */
    public function setUp()
    {
        $flashmessage_instance = new Flashmessage();
        include __DIR__ . '/Files/messages.php'; // $messages variable
        $messages_instance = new Messages($flashmessage_instance, $messages);

        $templates = $this->getTemplates();

        $this->encrypt = new Encrypt($messages_instance);

        return;
    }

    /**
     * @covers  Molajo\User\Encrypt::__construct
     * @covers  Molajo\User\Encrypt::createHashString
     * @covers  Molajo\User\Encrypt::verifyHashString
     * @covers  Molajo\User\Encrypt::generateString
     * @covers  Molajo\User\Encrypt::generateStringOperation
     */
    public function testCreateHashString()
    {
        $input = 'abcdefghijklmnopqrstuvwxyz';
        $hash  = $this->encrypt->createHashString($input);

        $this->assertGreaterThan(14, strlen($hash));
    }

    /**
     * @covers  Molajo\User\Encrypt::__construct
     * @covers  Molajo\User\Encrypt::createHashString
     * @covers  Molajo\User\Encrypt::verifyHashString
     * @covers  Molajo\User\Encrypt::generateString
     * @covers  Molajo\User\Encrypt::generateStringOperation
     */
    public function testVerifyHashString()
    {
        $hash  = '$2y$10$xXDeh0L9eyBkK1Ee9dv.g.Ry.NPmqnI7QiVxTdVUZ6uHqqtPUBr9K';
        $input = 'abc';

        $this->assertEquals(true, $this->encrypt->verifyHashString($input, $hash));
    }

    /**
     * @covers  Molajo\User\Encrypt::__construct
     * @covers  Molajo\User\Encrypt::createHashString
     * @covers  Molajo\User\Encrypt::verifyHashString
     * @covers  Molajo\User\Encrypt::generateString
     * @covers  Molajo\User\Encrypt::generateStringOperation
     */
    public function testGenerateString()
    {
        $string = $this->encrypt->generateString();

        $this->assertGreaterThan(14, strlen($string));
    }

    /**
     * Retrieve requested template in the $options array or load all templates
     *
     * @return   array
     * @since    1.0
     * @throws   \CommonApi\Exception\RuntimeException
     */
    public function getTemplates()
    {
        include __DIR__ . '/Files/getTemplates.php';
    }
}
