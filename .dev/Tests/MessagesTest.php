<?php
/**
 * Test User Messages
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Tests;

use Molajo\User\Messages;

require_once __DIR__ . '/Files/jsonRead.php';
require_once __DIR__ . '/Mocks/FlashMessage.php';

use Molajo\User\Mocks\MockFlashmessage;

/**
 * Test User Messages
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class MessagesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $messages
     */
    protected $messages;

    /**
     * @covers  Molajo\User\Messages::__construct
     * @covers  Molajo\User\Messages::setMessage
     * @covers  Molajo\User\Messages::getMessage
     * @covers  Molajo\User\Messages::setFlashmessage
     * @covers  Molajo\User\Messages::formatMessage
     * @covers  Molajo\User\Messages::throwException
     * @covers  Molajo\User\Messages::initializeMessages
     */
    public function setUp()
    {
        $flashmessage = new MockFlashmessage();

        include __DIR__ . '/Files/messages.php';  // $messages variable

        $this->messages = new Messages($flashmessage, $messages);

        return;
    }

    /**
     * @covers  Molajo\User\Messages::__construct
     * @covers  Molajo\User\Messages::setMessage
     * @covers  Molajo\User\Messages::getMessage
     * @covers  Molajo\User\Messages::setFlashmessage
     * @covers  Molajo\User\Messages::formatMessage
     * @covers  Molajo\User\Messages::throwException
     * @covers  Molajo\User\Messages::initializeMessages
     */
    public function testSetMessage()
    {
        $message_id = 111111111111;
        $message = 'This is a message';

        $this->messages->setMessage($message_id, $message);

        $this->assertEquals($message, $this->messages->getMessage($message_id));
    }

    /**
     * @covers  Molajo\User\Messages::__construct
     * @covers  Molajo\User\Messages::setMessage
     * @covers  Molajo\User\Messages::getMessage
     * @covers  Molajo\User\Messages::setFlashmessage
     * @covers  Molajo\User\Messages::formatMessage
     * @covers  Molajo\User\Messages::throwException
     * @covers  Molajo\User\Messages::initializeMessages
     */
    public function testFormatMessage()
    {
        $message_id = 9090909090;
        $message = 'This is a {name}.';
        $answer = 'This is a Test.';

        $this->messages->setMessage($message_id, $message);

        $results = $this->messages->getMessage($message_id, array('name' => 'Test'));

        $this->assertEquals($answer, $results);
    }

    /**
     * @covers  Molajo\User\Messages::__construct
     * @covers  Molajo\User\Messages::setMessage
     * @covers  Molajo\User\Messages::getMessage
     * @covers  Molajo\User\Messages::setFlashmessage
     * @covers  Molajo\User\Messages::formatMessage
     * @covers  Molajo\User\Messages::throwException
     * @covers  Molajo\User\Messages::initializeMessages
     */
    public function testSetFlashMessage()
    {
        $message_id = 9090909090;
        $message = 'This is a {name}.';
        $answer = 'Type: Error  Message: This is a Test.';

        $this->messages->setMessage($message_id, $message);

        $results = $this->messages->setFlashmessage($message_id, array('name' => 'Test'));

        $flash_message = readJsonFile(__DIR__ . '/Mocks/setFlashMessage.json');

        $this->assertEquals($answer, $flash_message);
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
