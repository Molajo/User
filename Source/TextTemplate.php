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
     * Tokens
     *
     * @var    array
     * @since  1.0
     */
    protected $tokens;

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
            'tokens'
        );

    /**
     * Construct
     *
     * @param   FieldhandlerInterface $fieldhandler
     * @param   MessagesInterface     $messages
     * @param   array                 $templates
     * @param   array                 $data
     *
     * @since   1.0
     */
    public function __construct(
        FieldhandlerInterface $fieldhandler,
        MessagesInterface $messages,
        array $templates = array(),
        array $data = array()
    ) {
        $this->fieldhandler = $fieldhandler;
        $this->messages     = $messages;
        $this->templates    = $templates;
        $this->data         = $data;
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
        $type       = $data->type;

        $this->rendered_output = '';
        $rendered              = new stdClass();

        $rendered = $this->renderSection($rendered, $type, $data, 'Body');
        $rendered = $this->renderSection($rendered, $type, $data, 'Head');

        return $rendered;
    }

    /**
     * Render the Head or Body Sections
     *
     * @param   string   $rendered
     * @param   string   $type
     * @param   stdClass $data
     * @param   string   $key
     *
     * @return  stdClass
     * @since   1.0
     */
    public function renderSection($rendered, $type, $data, $key)
    {
        $this->renderTemplateType($data, $type, $key);

        $this->renderLoop();

        $rendered->$key = $this->fieldhandler
            ->filter($type . ' ' . $key, $this->rendered_output, 'Fullspecialchars');

        return $rendered;
    }

    /**
     * Render Template Type
     *
     * @param   stdClass $data
     * @param   string   $type
     * @param   string   $key
     *
     * @return  $this
     * @since   1.0
     */
    protected function renderTemplateType(stdClass $data, $type, $key = 'subject')
    {
        if (isset($this->templates[$type])) {
            $this->rendered_output = $this->templates[$type]->$key;

        } else {
            if (isset($this->data['$key'])) {
                $this->rendered_output = $data['$key'];
            }
        }

        return $this;
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
        if (count($this->tokens) == 0) {
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
