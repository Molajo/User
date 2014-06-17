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
use CommonApi\User\FlashMessageInterface;

require_once __DIR__ . '/Files/jsonRead.php';

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
        $flashmessage = new MockMessagesFlashmessage();
        $messages     = $this->setMessages();

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

        $flash_message = readJsonFile(__DIR__ . '/Files/testMessagesFlashMessage.json');

        $this->assertEquals($answer, $flash_message);
    }

    /**
     * System Messages for User Subsystem
     *
     * @return  array
     * @since   1.0
     */
    protected function setMessages()
    {
        //todo Translations
        $messages = array(
            100  => 'System error: Must provide username, id or email to the Authentication Class.',
            200  => 'System error: Must pass Session ID into the Authentication Class methods.',
            205  => 'System error: validateFormToken action {action} requires a REQUEST METHOD of POST or PUT',
            210  => 'System error: Login requires a form and token.',
            300  => 'System error: Must pass Session ID into the isLoggedon method.',
            400  => 'System error: Must provide username, id or email to the getUser Method.',
            150  => 'Site is offline.',
            500  => 'Invalid Username.',
            600  => 'Registration has not been activated.',
            700  => 'Session has timed out.',
            800  => 'Maximum log in attempts have been exceeded. User has been blocked.',
            1100 => 'User is Blocked.',
            1200 => 'Password has expired.',
            1300 => 'Username not provided.',
            1310 => 'Email address not provided.',
            1400 => 'Password not provided.',
            1500 => 'Invalid Reset Password Code.',
            1600 => 'Password is incorrect.',
            1700 => 'System error: User Update Failed.',
            1800 => 'System error: Invalid Session for Guest.',
            1805 => 'System error: Invalid Session for $action {action}.',
            1900 => 'System error: Invalid Session.',
            2000 => 'System error: Invalid or missing Session Token.',
            2100 => 'Password length must be from {from} to {to}.',
            2130 => 'New password was not provided for Change Password request.',
            2200 => 'Password must not match Username.',
            2300 => 'New password must not match old password.',
            2400 => 'At least one Alpha character is required in password.',
            2500 => 'At least one Numeric character is required in password.',
            2600 => 'At least one of the following Special Characters: !*@#$%  is required in password.',
            2700 => 'At least one Upper Case character is required in password.',
            2800 => 'At least one Lower Case character is required in password.',
            3000 => 'System error: EMail Failed during Render for Email Type: {type} User: {name} Username: {username}.',
            3020 => 'System error: User Encrypt createHashString Exception: Input not sent in.',
            3025 => 'System error: User Encrypt createHashString',
            3030 => 'System error: User Encrypt createHashString Exception: library failed to create a hash.',
            3035 => 'System error: User Encrypt verifyHashString Exception: Input not sent in.',
            3040 => 'System error: User Encrypt verifyHashString Exception: Hash value not sent in.',
            3045 => 'System error: User Encrypt createRandomString Exception',
            3050 => 'System error: User Encrypt createHashString Exception: library failed to respond with a true or false.',
            3055 => 'System error: User Encrypt getRandomToken Exception',
            3060 => 'System error: User Encrypt getRandomToken Exception: library failed to create a token.',
            3065 => 'System error: Authorisation verifyLogin Failed $action not provided',
            3070 => 'System error: Authorisation verifyLogin Failed $catalog_id not provided',
            3075 => 'System error: Authorisation verifyActionPermissions Failed ',
            3080 => 'System error: Authorisation verifyLogin Failed $action not provided',
            3085 => 'System error: Authorisation verifyLogin Failed $catalog_id not provided',
            3090 => 'System error: Authorisation verifyActionPermissions Failed',
            3092 => 'System error: Authorisation verifyActionPermissionsCatalogPermissions Failed $view_group_id not provided',
            3094 => 'System error: Authorisation verifyActionPermissionsCatalogPermissions Failed $action_id not provided',
            3096 => 'System error: Authorisation verifyActionPermissionsCatalogPermissions Failed $catalog_id not provided',
            3098 => 'System error: Authorisation verifyActionPermissionsCatalogPermissions Failed',
            3099 => 'System error: Authorisation isUserAuthorisedNoFiltering Failed',
            3100 => 'System error: EMail Failed during Send for Email Type: {type} User: {name} Username: {username}.',
            3200 => 'System error: Filter Failed for Key: {key} Filter: {filter}.',
            4000 => 'System error: Redirect Service Get: unknown key: {key}.',
            4100 => 'System error: Redirect Service Set: unknown key: {key}.',
            4200 => 'System error: Redirect: No Url provided for Redirect.',
            4300 => 'System error: Redirect: Invalid URL {url} for Redirect.',
            4400 => 'System error: Session: Invalid type {type] for setFlashmessage.',
            5000 => 'System error: Messages - Unknown Message ID: {message} requested in getMessage.',
            5010 => 'System error: Class get Method requesting unknown key: {key}.',
            5015 => 'System error: Class set Method requesting unknown key: {key}.',
            5020 => 'System error: User Data Class getUserParameters Method requesting unknown key: {key}.',
            5025 => 'System error: User Data Class setUserParameters Method requesting unknown key: {key}.',
            5030 => 'System error: User Data Class getUserMetadata Method requesting unknown key: {key}.',
            5035 => 'System error: User Data Class setUserMetadata Method requesting unknown key: {key}.',
            6000 => 'System error: Text Template Class get Method requesting unknown key: {key}.',
            6010 => 'System error: Text Template Class set Method requesting unknown key: {key}.',
        );

        return $messages;
    }
}

class MockMessagesFlashmessage implements FlashMessageInterface
{
    public function getFlashmessage($type = null)
    {

    }

    public function setFlashmessage($type, $message)
    {
        file_put_contents(
            __DIR__ . '/Files/testMessagesFlashMessage.json',
            json_encode('Type: ' . $type . ' ' . ' Message: ' . $message)
        );
    }

    public function deleteFlashmessage($type = null)
    {

    }
}
