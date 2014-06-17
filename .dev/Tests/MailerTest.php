<?php
/**
 * Test User Mailer
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Tests;

use Molajo\User\Mocks\MockEmail as Email;
use Molajo\User\Mocks\MockFieldhandler as Fieldhandler;
use Molajo\User\Mocks\MockFlashmessage as Flashmessage;
use Molajo\User\Mailer;
use Molajo\User\Messages;
use Molajo\User\TextTemplate;

require_once __DIR__ . '/Files/jsonRead.php';
require_once __DIR__ . '/Mocks/FlashMessage.php';
require_once __DIR__ . '/Mocks/Fieldhandler.php';
require_once __DIR__ . '/Mocks/Email.php';

/**
 * Test User Mailer
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class MailerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $mailer
     */
    protected $mailer;

    /**
     * @var $mailer
     */
    protected $email_instance;

    /**
     * @covers  Molajo\User\Mailer::__construct
     * @covers  Molajo\User\Mailer::send
     * @covers  Molajo\User\Mailer::processTemplate
     * @covers  Molajo\User\Mailer::processMail
     */
    public function setUp()
    {
        $fieldhandler_instance = new Fieldhandler();

        $flashmessage_instance = new Flashmessage();
        include __DIR__ . '/Files/messages.php'; // $messages variable
        $messages_instance = new Messages($flashmessage_instance, $messages);

        $templates  = $this->getTemplates();

        $template_instance = new TextTemplate($fieldhandler_instance, $messages_instance, $templates);

        $this->email_instance = new Email();

        $this->mailer = new Mailer($this->email_instance, $template_instance);

        return;
    }

    /**
     * @covers  Molajo\User\Mailer::__construct
     * @covers  Molajo\User\Mailer::send
     * @covers  Molajo\User\Mailer::processTemplate
     * @covers  Molajo\User\Mailer::processMail
     */
    public function testGet()
    {
        $row        = new \stdClass();
        $row->today = '12/31/2014';
        $row->name  = 'Jo Money';
        $row->link  = 'http://example.com/link';

        $row                      = new \stdClass();
        $row->today               = '12/31/2014';
        $row->name                = 'Jo Money';
        $row->link                = 'http://example.com/link';
        $row->to                  = 'person@example.com,Person Name';
        $row->from                = 'person@example.com,Person Name';
        $row->reply_to            = 'person@example.com,Person Name';
        $row->cc                  = 'person@example.com,Person Name';
        $row->bcc                 = 'person@example.com,Person Name';
        $row->subject             = 'Welcome to our Site';
        $row->body                = '<h2>Stuff goes here</h2>';
        $row->mailer_html_or_text = 'html';

        $expected_results = 'On 12/31/2014, Jo Money requested a password reset. The link expires when the password is changed or the next time the account is logged in. Please click http://example.com/link to change the password now.';

        $this->mailer->send('password_reset_request.template', $row);

        $this->assertEquals($this->email_instance->get('to'), 'person@example.com,Person Name');
        $this->assertEquals($this->email_instance->get('from'), 'person@example.com,Person Name');
        $this->assertEquals($this->email_instance->get('reply_to'), 'person@example.com,Person Name');
        $this->assertEquals($this->email_instance->get('cc'), 'person@example.com,Person Name');
        $this->assertEquals($this->email_instance->get('bcc'), 'person@example.com,Person Name');
        $this->assertEquals($this->email_instance->get('subject'), 'Password Reset Request');;
        $this->assertEquals($this->email_instance->get('body'), $expected_results);
        $this->assertEquals($this->email_instance->get('mailer_html_or_text'), 'html');
        $this->assertEquals($this->email_instance->get('attachment'), null);
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

        return $templates;
    }
}
