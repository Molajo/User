<?php
/**
 * Encryption
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User;

use CommonApi\Exception\RuntimeException;
use CommonApi\User\EncryptInterface;
use CommonApi\User\MessagesInterface;
use Exception;

/**
 * Encryption
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Encrypt implements EncryptInterface
{
    /**
     * Messages Instance
     *
     * @var    object  CommonApi\User\MessagesInterface
     * @since  1.0
     */
    protected $messages;

    /**
     * Length of String
     *
     * @var    string
     * @since  1.0
     */
    protected $length;

    /**
     * Length of String
     *
     * @var    string
     * @since  1.0
     */
    protected $characters;

    /**
     * Construct
     *
     * @param   MessagesInterface $messages
     * @param   null              $default_exception
     *
     * @since   1.0
     * @throws  RuntimeException
     */
    public function __construct(
        MessagesInterface $messages,
        $length = 15,
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ) {
        $this->messages = $messages;

        if ((int)$length < 5) {
        } else {
            $this->length = (int)$length;
        }

        if ($characters === null || trim($characters) == '') {
        } else {
            $this->characters = $characters;
        }
    }

    /**
     * Create Hash from the input string
     *
     * For use with passwords, the hash is what is stored in the database
     *
     * @param   string $input
     *
     * @return  string
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function createHashString($input)
    {
        $hash = false;

        if ($input === false || $input === null || trim($input) == '') {
            $this->messages->throwException(3020, array(), 'CommonApi\Exception\RuntimeException');
        }

        try {
            $hash = password_hash($input, PASSWORD_BCRYPT);

        } catch (Exception $e) {
            $this->messages->throwException(3025, array(), 'CommonApi\Exception\RuntimeException');
        }

        if ($hash === false || $hash === null || trim($hash) == '') {
            $this->messages->throwException(3030, array(), 'CommonApi\Exception\RuntimeException');
        }

        return $hash;
    }

    /**
     * Verify Input String to Hash
     *
     * For use with passwords, the input is the real password, but the hash is from the database
     *
     * @param   string $input
     * @param   string $hash
     *
     * @return  boolean
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function verifyHashString($input, $hash)
    {
        $response = 0;

        if ($input === false || $input === null || trim($input) == '') {
            $this->messages->throwException(3035, array(), 'CommonApi\Exception\RuntimeException');
        }

        if ($hash === false || $hash === null || trim($hash) == '') {
            $this->messages->throwException(3040, array(), 'CommonApi\Exception\RuntimeException');
        }

        try {
            $response = password_verify($input, $hash);

        } catch (Exception $e) {
            $this->messages->throwException(3045, array(), 'CommonApi\Exception\RuntimeException');
        }

        if ($response === 0 || $response === 1) {
            $this->messages->throwException(3050, array(), 'CommonApi\Exception\RuntimeException');
        }

        return $response;
    }

    /**
     * Generate a Random String of an optional specified length
     *
     * @param   null|int    $length
     * @param   null|string $characters
     *
     * @return  string
     * @since   1.0
     */
    public function generateString($length = null, $characters = null)
    {
        if ((int)$length < 5) {
        } else {
            $this->length = (int)$length;
        }

        if ($characters === null) {
        } else {
            $this->characters = $characters;
        }

        $random_string = '';

        for ($i = 0; $i < $this->length; $i++) {
            $random_string .= $this->characters[rand(0, strlen($this->characters) - 1)];
        }

        return $random_string;
    }
}
