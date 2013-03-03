<?php
/**
 * Permissions Exception
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Foundation\Permissions\Exception;

defined('MOLAJO') or die;

use RuntimeException;

/**
 * Permissions Exception
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class PermissionsException extends RuntimeException implements PermissionsExceptionInterface
{

}
