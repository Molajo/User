<?php
/**
 * User Fieldhandler Utility
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User;

use CommonApi\Model\FieldhandlerInterface;
use CommonApi\User\MessagesInterface;

/**
 * User Fieldhandler Utility
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Fieldhandler implements FieldhandlerInterface
{
    /**
     * Fieldhandler Instance
     *
     * @var    object  CommonApi\Model\FieldhandlerInterface
     * @since  1.0
     */
    protected $fieldhandler;

    /**
     * Message Instance
     *
     * @var    object  CommonApi\Model\MessagesInterface
     * @since  1.0
     */
    protected $messages;

    /**
     * Construct
     *
     * @param FieldhandlerInterface $fieldhandler
     * @param MessagesInterface     $messages
     *
     * @since  1.0
     */
    public function __construct(
        FieldhandlerInterface $fieldhandler,
        MessagesInterface $messages
    ) {
        $this->fieldhandler = $fieldhandler;
        $this->messages     = $messages;
    }

    /**
     * Validate
     *
     * @param   string     $field_name
     * @param   null|mixed $field_value
     * @param   string     $constraint
     * @param   array      $options
     *
     * @return  \CommonApi\Model\ValidateResponseInterface
     * @since   1.0.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    public function validate($field_name, $field_value = null, $constraint, array $options = array())
    {
        return $this->fieldhandler->validate($field_name, $field_value, $constraint, $options);
    }

    /**
     * Sanitize
     *
     * @param   string     $field_name
     * @param   null|mixed $field_value
     * @param   string     $constraint
     * @param   array      $options
     *
     * @return  \CommonApi\Model\ValidateResponseInterface
     * @since   1.0.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    public function sanitize($field_name, $field_value = null, $constraint, array $options = array())
    {
        return $this->fieldhandler->filter($field_name, $field_value, $constraint, $options);
    }

    /**
     * Format
     *
     * @param   string     $field_name
     * @param   null|mixed $field_value
     * @param   string     $constraint
     * @param   array      $options
     *
     * @return  \CommonApi\Model\HandleResponseInterface
     * @since   1.0.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    public function format($field_name, $field_value = null, $constraint, array $options = array())
    {
        return $this->fieldhandler->filter($field_name, $field_value, $constraint, $options);
    }
}
