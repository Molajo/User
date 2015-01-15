<?php
/**
 * Encryption for User Authentication
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Authentication;

use CommonApi\Model\FieldhandlerInterface;
use CommonApi\User\AuthenticationInterface;
use CommonApi\User\EncryptInterface;
use CommonApi\User\MessagesInterface;
use stdClass;

/**
 * Encryption for User Authentication
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Encrypt extends Base implements AuthenticationInterface
{
    /**
     * Encrypt Instance
     *
     * @var    object  CommonApi\User\EncryptInterface
     * @since  1.0
     */
    protected $encrypt;

    /**
     * Construct
     *
     * @param  EncryptInterface      $encrypt
     * @param  FieldhandlerInterface $fieldhandler
     * @param  stdClass              $configuration
     * @param  object                $server
     * @param  object                $post
     *
     * @since  1.0
     */
    public function __construct(
        EncryptInterface $encrypt,
        FieldhandlerInterface $fieldhandler,
        $configuration,
        $server,
        $post
    ) {
        $this->encrypt = $encrypt;

        parent::__construct(
            $fieldhandler,
            $configuration,
            $server,
            $post
        );
    }

    /**
     * Generate a Random String
     *
     * @return  $this
     * @since   1.0
     */
    protected function generateString()
    {
        return $this->encrypt->generateString();
    }

    /**
     * Create Hash String
     *
     * @param   string $value
     *
     * @return  $this
     * @since   1.0
     */
    protected function createHashString($value)
    {
        return $this->encrypt->createHashString($value);
    }

    /**
     * Verify Hash String
     *
     * @param   string $value
     *
     * @return  $this
     * @since   1.0
     */
    protected function verifyHashString($value, $existing)
    {
        return $this->encrypt->verifyHashString($value, $existing);
    }
}
