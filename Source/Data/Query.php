<?php
/**
 * Query Usage Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\User\Data;

use CommonApi\Query\QueryInterface;
use CommonApi\Fieldhandler\FieldhandlerInterface;

/**
 * Query Usage Class
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Query extends Base
{
    /**
     * Fieldhandler Usage Trait
     *
     * @var     object  CommonApi\Fieldhandler\FieldhandlerUsageTrait
     * @since   1.0.0
     */
    use \CommonApi\Fieldhandler\FieldhandlerUsageTrait;

    /**
     * Query Usage Trait
     *
     * @var     object  CommonApi\Query\QueryUsageTrait
     * @since   1.0.0
     */
    use \CommonApi\Query\QueryUsageTrait;

    /**
     * Construct
     *
     * @param  QueryInterface        $resource
     * @param  FieldhandlerInterface $fieldhandler
     * @param  array                 $runtime_data
     *
     * @since  1.0.0
     */
    public function __construct(
        QueryInterface $resource,
        FieldhandlerInterface $fieldhandler,
        array $runtime_data = array()
    ) {
        $this->resource     = $resource;
        $this->fieldhandler = $fieldhandler;
        $this->runtime_data = $runtime_data;
    }
}
