<?php
/**
 * Text Template Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\User;

use stdClass;
use CommonApi\User\MessagesInterface;
use CommonApi\User\TemplateInterface;
use CommonApi\Model\FieldhandlerInterface;

/**
 * Text Template Class
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class TextTemplate implements TemplateInterface
{
    /**
     * Fieldhandler Instance
     *
     * @var    object  CommonApi\Model\FieldhandlerInterface
     * @since  1.0
     */
    protected $fieldhandler;

    /**
     * Messages Instance
     *
     * @var    object  CommonApi\User\MessagesInterface
     * @since  1.0
     */
    protected $messages;

    /**
     * Templates
     *
     * @var    array
     * @since  1.0
     */
    protected $templates = array();

    /**
     * Data
     *
     * @var    array
     * @since  1.0
     */
    protected $data = array();

    /**
     * Rendered Output
     *
     * @var    string
     * @since  1.0
     */
    protected $rendered_output = null;

    /**
     * Rendered Output
     *
     * @var    stdClass
     * @since  1.0
     */
    protected $message = null;

    /**
     * Tokens
     *
     * @var    array
     * @since  1.0
     */
    protected $tokens;

    /**
     * Type
     *
     * @var    string
     * @since  1.0
     */
    protected $type;

    /**
     * List of Properties
     *
     * @var    array
     * @since  1.0
     */
    protected $property_array
        = array(
            'fieldhandler',
            'messages',
            'templates',
            'data',
            'rendered_output',
            'tokens',
            'type'
        );

    /**
     * Construct
     *
     * @param   FieldhandlerInterface $fieldhandler
     * @param   MessagesInterface     $messages
     * @param   array                 $templates
     *
     * @since   1.0
     */
    public function __construct(
        FieldhandlerInterface $fieldhandler,
        MessagesInterface $messages,
        array $templates = array()
    ) {
        $this->fieldhandler = $fieldhandler;
        $this->messages     = $messages;
        $this->templates    = $templates;
    }

    /**
     * Get the current value (or default) of the specified key
     *
     * @param   string $key
     * @param   mixed  $default
     *
     * @return  mixed
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function get($key, $default = null)
    {
        $key = strtolower($key);

        if (in_array($key, $this->property_array)) {
        } else {
            $this->messages->throwException(6000, array('key' => $key), 'CommonApi\Exception\RuntimeException');
        }

        if ($this->$key === null) {
            $this->$key = $default;
        }

        return $this->$key;
    }

    /**
     * Set the value of a specified key
     *
     * @param   string $key
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function set($key, $value = null)
    {
        $key = strtolower($key);

        if (in_array($key, $this->property_array)) {
        } else {
            $this->messages->throwException(6010, array('key' => $key), 'CommonApi\Exception\RuntimeException');
        }

        $this->$key = $value;

        return $this;
    }

    /**
     * Set the Option Values, Initiate Rendering, Send
     *
     * @param   stdClass $data
     *
     * @return  stdClass
     * @since   1.0
     */
    public function render(stdClass $data)
    {
        $this->data = $data;

        $this->renderTemplateType();

        $rendered          = new stdClass();
        $rendered->name    = $this->message->name;
        $rendered->subject = $this->renderSection($this->message->subject, 'Subject');
        $rendered->body    = $this->renderSection($this->message->body, 'Body');

        return $rendered;
    }

    /**
     * Render Template Type
     *
     * @return  $this
     * @since   1.0
     */
    protected function renderTemplateType()
    {
        if (isset($this->templates[$this->type])) {
            $this->message = $this->templates[$this->type];

        } else {
            if (isset($this->data[$this->type])) {
                $this->message = $this->data[$this->type];
            }
        }

        return $this;
    }

    /**
     * Render the Subject and Body Sections, one at a time
     *
     * @param   string $template
     * @param   string $key
     *
     * @return  string
     * @since   1.0
     */
    public function renderSection($template, $key)
    {
        $this->rendered_output = $template;

        $this->renderLoop();

        $this->fieldhandler
            ->sanitize($this->type . ' ' . $key, $this->rendered_output, 'Fullspecialchars');

        return $this->rendered_output;
    }

    /**
     * Iteratively process content, replacing tokens with data values
     *
     * @return  $this
     * @since   1.0
     */
    protected function renderLoop()
    {
        $complete = false;
        $loop     = 0;

        while ($complete === false) {

            $this->parseTokens();

            $this->replaceTokens();

            if ($loop++ > 100) {
                break;
            }
        }

        return $this;
    }

    /**
     * Parses the rendered output, looking for {tokens}
     *
     * @return  $this
     * @since   1.0
     */
    protected function parseTokens()
    {
        $this->tokens = array();

        preg_match_all('#{(.*)}#iU', $this->rendered_output, $this->tokens);

        return $this;
    }

    /**
     * Locate all tags and replace with data
     *
     * @return  $this
     * @since   1.0
     */
    protected function replaceTokens()
    {
        if (count($this->tokens) === 0) {
            return $this;
        }

        $replace_this = $this->setReplaceThisTokens();

        $replace_with = $this->setReplaceWithValues();

        $this->rendered_output = str_replace($replace_this, $replace_with, $this->rendered_output);

        return $this;
    }

    /**
     * Set Tokens to use for search and replacement
     *
     * @return  array
     * @since   1.0
     */
    protected function setReplaceThisTokens()
    {
        $replace_this = array();

        foreach ($this->tokens[0] as $token) {
            $replace_this[] = $token;
        }

        return $replace_this;
    }

    /**
     * Set Replace With Values
     *
     * @return  array
     * @since   1.0
     */
    protected function setReplaceWithValues()
    {
        $replace_with = array();

        foreach ($this->tokens[1] as $token) {
            if (isset($this->data->$token)) {
                $replace_with[] = $this->data->$token;
            } else {
                $replace_with[] = '';
            }
        }

        return $replace_with;
    }
}
