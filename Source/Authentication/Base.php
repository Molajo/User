<?php
/**
 * Authentication Base
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use CommonApi\Fieldhandler\FieldhandlerInterface;
use stdClass;

/**
 * Authentication Base
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Base
{
    /**
     * Fieldhandler Instance
     *
     * @var    object  CommonApi\Fieldhandler\FieldhandlerInterface
     * @since  1.0.0
     */
    protected $fieldhandler;

    /**
     * Configuration Settings
     *
     * @var    object
     * @since  1.0.0
     */
    protected $configuration;

    /**
     * $_SERVER OBJECT
     *
     * @var    object
     * @since  1.0.0
     */
    protected $server;

    /**
     * $_POST OBJECT
     *
     * @var    object
     * @since  1.0.0
     */
    protected $post;

    /**
     * Error
     *
     * @var    boolean
     * @since  1.0.0
     */
    protected $error = false;

    /**
     * Properties
     *
     * @var    array
     * @since  1.0.0
     */
    protected $base_properties
        = array(
            'fieldhandler',
            'configuration',
            'server',
            'post'
        );

    /**
     * Construct
     *
     * @param  FieldhandlerInterface $fieldhandler
     * @param  stdClass              $configuration
     * @param  object                $server
     * @param  object                $post
     *
     * @since  1.0.0
     */
    public function __construct(
        FieldhandlerInterface $fieldhandler,
        $configuration,
        $server,
        $post
    ) {
        $this->fieldhandler  = $fieldhandler;
        $this->configuration = $configuration;
        $this->server        = $server;
        $this->post          = $post;
    }
}
