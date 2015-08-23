<?php
/**
 * Fieldhandler Class
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\User\Mocks;

use CommonApi\Fieldhandler\FieldhandlerInterface;

class MockFieldHandler implements FieldhandlerInterface
{
    public function validate($field_name, $field_value = null, $constraint, array $options = array())
    {
        return true;
    }

    public function sanitize($field_name, $field_value = null, $constraint, array $options = array())
    {
        return $field_value;
    }

    public function format($field_name, $field_value = null, $constraint, array $options = array())
    {
        return $field_value;
    }
}
