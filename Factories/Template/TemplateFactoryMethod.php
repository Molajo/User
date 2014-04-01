<?php
/**
 * User Template Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Template;

use stdClass; // this is needed by required files in getTemplates() method below
use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethodBase;

/**
 * User Template Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class TemplateFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
    /**
     * Constructor
     *
     * @param  array $options
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $options['product_name']             = basename(__DIR__);
        $options['store_instance_indicator'] = true;
        $options['product_namespace']        = 'Molajo\\User\\TextTemplate';

        parent::__construct($options);
    }

    /**
     * Set Dependencies for Instantiation
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function onBeforeInstantiation(array $dependency_values = null)
    {
        parent::onBeforeInstantiation($dependency_values);

        $this->dependencies['templates']         = $this->getTemplates();
        $this->dependencies['default_exception'] = 'CommonApi\\Exception\\RuntimeException';
        $this->dependencies['data']              = array();

        return $this;
    }

    /**
     * Retrieve requested template in the $options array or load all templates
     *
     * @return   array
     * @since    1.0
     * @throws   \CommonApi\Exception\RuntimeException;
     */
    public function getTemplates()
    {
        $template = '';

        if (isset($this->options['language'])) {
            $language = $this->options['language'];
        } else {
            $language = 'en-GB';
        }

        $template_folder = __DIR__ . '/' . $language . '/';

        if ((is_dir($template_folder))) {
        } else {
            if ($language === 'en-GB') {
            } else {
                $template_folder = __DIR__ . '/' . 'en-GB' . '/';
            }
            if ((is_dir($template_folder))) {
            } else {

                throw new RuntimeException
                ('IoC Factory Method Adapter Instance Failed for Molajo\User\TextTemplate '
                . 'Template folder does not exist ' . $template_folder);
            }
        }

        $template_files = array();

        if (isset($this->options['template_name'])) {
            $template_files[] = $this->options['template_name'];
        } else {

            $temp = scandir($template_folder);

            foreach ($temp as $file) {
                if ($file === '.' || $file == '..') {
                } else {
                    $template_files[] = $file;
                }
            }
        }

        if (count($template_files) > 0) {
        } else {
            throw new RuntimeException
            ('IoC Factory Method Adapter Instance Failed for Molajo\User\TextTemplate '
            . 'Template folder does not contain templates: ' . $template_folder);
        }

        $templates = array();

        foreach ($template_files as $template_name) {

            if (file_exists($template_folder . $template_name)) {

                require $template_folder . $template_name;
                $templates[substr(
                    $template_name,
                    0,
                    strlen($template_name) - 4
                )] = $template; // $template is defined in the included file

            } else {
                throw new RuntimeException
                ('IoC Factory Method Adapter Instance Failed for Molajo\User\TextTemplate '
                . ' Template File does not exist. (This should never happen.');
            }
        }

        return $templates;
    }
}
