<?php
/**
 * User Injector extends Injector implements InjectorInterface Exception
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Exception;

defined('MOLAJO') or die;

use RuntimeException;

/**
 * User Injector extends Injector implements InjectorInterface Exception
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class UserInjectionException extends Injector implements InjectorInterfaceException extends RuntimeException implements UserExceptionInterface
{
}
