<?php
/**
 * Bootstrap for Testing
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
$base = substr(__DIR__, 0, strlen(__DIR__) - 5);
if (function_exists('CreateClassMap')) {
} else {
    include_once __DIR__ . '/CreateClassMap.php';
}
include_once $base . '/vendor/autoload.php';

$classmap                                 = array();
$classmap                                 = createClassMap(
    $base . '/Source/Authentication/',
    'Molajo\\User\\Authentication\\'
);
$classmap['Molajo\\User\\Activity']       = $base . '/Source/Activity.php';
$classmap['Molajo\\User\\Authentication'] = $base . '/Source/Authentication.php';
$classmap['Molajo\\User\\Cookie']         = $base . '/Source/Cookie.php';
$classmap['Molajo\\User\\Encrypt']        = $base . '/Source/Encrypt.php';
$classmap['Molajo\\User\\Facade']         = $base . '/Source/Facade.php';
$classmap['Molajo\\User\\Fieldhandler']   = $base . '/Source/Fieldhandler.php';
$classmap['Molajo\\User\\Flashmessage']   = $base . '/Source/Flashmessage.php';
$classmap['Molajo\\User\\Mailer']         = $base . '/Source/Mailer.php';
$classmap['Molajo\\User\\Messages']       = $base . '/Source/Messages.php';
$classmap['Molajo\\User\\Registration']   = $base . '/Source/Registration.php';
$classmap['Molajo\\User\\Session']        = $base . '/Source/Session.php';
$classmap['Molajo\\User\\TextTemplate']   = $base . '/Source/TextTemplate.php';
$classmap['Molajo\\User\\Userdata']       = $base . '/Source/Userdata.php';

ksort($classmap);

spl_autoload_register(
    function ($class) use ($classmap) {
        if (array_key_exists($class, $classmap)) {
            require_once $classmap[$class];
        }
    }
);
