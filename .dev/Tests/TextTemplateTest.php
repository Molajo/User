<?php
/**
 * Test User TextTemplate
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Tests;

use Molajo\User\TextTemplate;
use Molajo\User\Mocks\MockFlashmessage as Flashmessage;
use Molajo\User\Mocks\MockFieldhandler as Fieldhandler;
use Molajo\User\Messages;

require_once __DIR__ . '/Files/jsonRead.php';
require_once __DIR__ . '/Mocks/FlashMessage.php';
require_once __DIR__ . '/Mocks/Fieldhandler.php';

/**
 * Test User TextTemplate
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class TextTemplateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $text_template
     */
    protected $text_template;

    /**
     * @var $data
     */
    protected $data;

    /**
     * @covers  Molajo\User\TextTemplate::__construct
     * @covers  Molajo\User\TextTemplate::get
     * @covers  Molajo\User\TextTemplate::set
     * @covers  Molajo\User\TextTemplate::render
     * @covers  Molajo\User\TextTemplate::renderLoop
     * @covers  Molajo\User\TextTemplate::parseTokens
     * @covers  Molajo\User\TextTemplate::replaceTokens
     */
    public function setUp()
    {
        $fieldhandler_instance = new Fieldhandler();

        $flashmessage_instance = new Flashmessage();
        include __DIR__ . '/Files/messages.php'; // $messages variable
        $messages_instance = new Messages($flashmessage_instance, $messages);

        $templates  = $this->getTemplates();

        $this->text_template = new TextTemplate(
            $fieldhandler_instance,
            $messages_instance,
            $templates
        );

        return;
    }

    /**
     * @covers  Molajo\User\TextTemplate::__construct
     * @covers  Molajo\User\TextTemplate::get
     * @covers  Molajo\User\TextTemplate::set
     * @covers  Molajo\User\TextTemplate::render
     * @covers  Molajo\User\TextTemplate::renderLoop
     * @covers  Molajo\User\TextTemplate::parseTokens
     * @covers  Molajo\User\TextTemplate::replaceTokens
     */
    public function testGet()
    {
        $row        = new \stdClass();
        $row->today = '12/31/2014';
        $row->name  = 'Jo Money';
        $row->link  = 'http://example.com/link';

        $this->text_template->set('data', $row);

        $this->assertEquals($row, $this->text_template->get('data'));
    }

    /**
     * @covers  Molajo\User\TextTemplate::__construct
     * @covers  Molajo\User\TextTemplate::get
     * @covers  Molajo\User\TextTemplate::set
     * @covers  Molajo\User\TextTemplate::render
     * @covers  Molajo\User\TextTemplate::renderLoop
     * @covers  Molajo\User\TextTemplate::parseTokens
     * @covers  Molajo\User\TextTemplate::replaceTokens
     */
    public function testSet()
    {
        $this->text_template->set('type', 'password_reset_request.template');

        $this->assertEquals('password_reset_request.template', $this->text_template->get('type'));
    }

    /**
     * @covers  Molajo\User\TextTemplate::__construct
     * @covers  Molajo\User\TextTemplate::get
     * @covers  Molajo\User\TextTemplate::set
     * @covers  Molajo\User\TextTemplate::render
     * @covers  Molajo\User\TextTemplate::renderLoop
     * @covers  Molajo\User\TextTemplate::parseTokens
     * @covers  Molajo\User\TextTemplate::replaceTokens
     */
    public function testRender()
    {
        $this->text_template->set('type', 'password_reset_request.template');

        $row        = new \stdClass();
        $row->today = '12/31/2014';
        $row->name  = 'Jo Money';
        $row->link  = 'http://example.com/link';

        $rendered = $this->text_template->render($row);

//        file_put_contents(
//            __DIR__ . '/Files/TextTemplateTextTestRender.json',
//            json_encode($rendered)
//        );

        $should_be = readJsonFile(__DIR__ . '/Files/TextTemplateTextTestRender.json');

        $this->assertEquals($should_be['name'], $rendered->name);
        $this->assertEquals($should_be['subject'], $rendered->subject);
        $this->assertEquals($should_be['body'], $rendered->body);
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
