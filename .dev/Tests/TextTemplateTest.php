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
use CommonApi\Model\FieldhandlerInterface;
use CommonApi\User\FlashMessageInterface;

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
        $flashmessage = new MockTextTemplateFlashmessage();
        $fieldhandler   = new MockTextTemplateFieldHandler();

        //$this->text_template = new TextTemplate($flashmessage, $fieldhandler);

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
    public function testStartTextTemplate()
    {
//        $this->assertEquals(text_template_id(), $this->text_template->getTextTemplate('text_template_id'));
    }
}

class MockTextTemplateFieldHandler implements FieldhandlerInterface
{
    public function validate($field_name, $field_value = null, $constraint, array $options = array())
    {

    }

    public function sanitize($field_name, $field_value = null, $constraint, array $options = array())
    {

    }

    public function format($field_name, $field_value = null, $constraint, array $options = array())
    {

    }
}

class MockTextTemplateFlashmessage implements FlashMessageInterface
{

    /**
     * Get Flash Messages for User, all or by Type
     *
     * @param   string $type (Success, Notice, Warning, Error)
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getFlashmessage($type = null)
    {

    }

    /**
     * Save a Flash Message (User Message)
     *
     * @param   string $type (Success, Notice, Warning, Error)
     * @param   string $message
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setFlashmessage($type, $message)
    {

    }

    /**
     * Delete Flash Messages, all or by type
     *
     * @param   null|string $type
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function deleteFlashmessage($type = null)
    {

    }
}
