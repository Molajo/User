<?php
/**
 * User Fieldhandler Utility
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User;

use CommonApi\Model\FieldhandlerInterface as UserFieldhandlerInterface;
use CommonApi\User\MessagesInterface;
use CommonApi\Model\FieldhandlerInterface;

/**
 * User Fieldhandler Utility
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Fieldhandler implements UserFieldhandlerInterface
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
     * Validate Input
     *
     * @param   string      $key
     * @param   null|string $value
     * @param   string      $fieldhandler_type_chain
     * @param   array       $options
     *
     * @return  $this|mixed
     * @since   1.0
     */
    public function validate($key, $value = null, $fieldhandler_type_chain, $options = array())
    {
        return $this->fieldhandler->validate($key, $value, $fieldhandler_type_chain, $options);
    }

    /**
     * Filter Input
     *
     * @param   string      $key
     * @param   null|string $value
     * @param   string      $fieldhandler_type_chain
     * @param   array       $options
     *
     * @return  $this|mixed
     * @since   1.0
     */
    public function filter($key, $value = null, $fieldhandler_type_chain, $options = array())
    {
        return $this->fieldhandler->filter($key, $value, $fieldhandler_type_chain, $options);
    }

    /**
     * Escape Input
     *
     * @param   string      $key
     * @param   null|string $value
     * @param   string      $fieldhandler_type_chain
     * @param   array       $options
     *
     * @return  $this|mixed
     * @since   1.0
     */
    public function escape($key, $value = null, $fieldhandler_type_chain, $options = array())
    {
        return $this->fieldhandler->filter($key, $value, $fieldhandler_type_chain, $options);
    }
}
