<?php
/**
 * Authentication Base
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use CommonApi\Model\FieldhandlerInterface;
use CommonApi\User\MessagesInterface;
use stdClass;

/**
 * Authentication Base
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Base
{
    /**
     * Messages Instance
     *
     * @var    object  CommonApi\User\MessagesInterface
     * @since  1.0
     */
    protected $messages;

    /**
     * Fieldhandler Instance
     *
     * @var    object  CommonApi\Model\FieldhandlerInterface
     * @since  1.0
     */
    protected $fieldhandler;

    /**
     * Configuration Settings
     *
     * @var    object
     * @since  1.0
     */
    protected $configuration;

    /**
     * $_SERVER OBJECT
     *
     * @var    object
     * @since  1.0
     */
    protected $server;

    /**
     * $_POST OBJECT
     *
     * @var    object
     * @since  1.0
     */
    protected $post;

    /**
     * Error
     *
     * @var    boolean
     * @since  1.0
     */
    protected $error = false;

    /**
     * Construct
     *
     * @param  MessagesInterface     $messages
     * @param  FieldhandlerInterface $fieldhandler
     * @param  stdClass              $configuration
     * @param  object                $server
     * @param  object                $post
     *
     * @since  1.0
     */
    public function __construct(
        MessagesInterface $messages,
        FieldhandlerInterface $fieldhandler,
        $configuration,
        $server,
        $post
    ) {
        $this->messages      = $messages;
        $this->fieldhandler  = $fieldhandler;
        $this->configuration = $configuration;
        $this->server        = $server;
        $this->post          = $post;
    }
}
