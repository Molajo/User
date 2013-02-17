<?php
/**
 * User
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   MIT
 */
define('MOLAJO', 'This is a Molajo Distribution');

if (substr($_SERVER['DOCUMENT_ROOT'], - 1) == '/') {
    define('ROOT_FOLDER', $_SERVER['DOCUMENT_ROOT']);
} else {
    define('ROOT_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/');
}

$base = substr(__DIR__, 0, strlen(__DIR__) - 5);
define('BASE_FOLDER', $base);

//include BASE_FOLDER . '/Tests/Testcase1/Data.php';

$classMap = array(
    'Molajo\\User\\Adapter'                                => BASE_FOLDER . '/Adapter.php',
    'Molajo\\User\\Adapter\\UserInterface'            => BASE_FOLDER . '/Adapter/UserInterface.php',

    'Molajo\\User\\Exception\\UserException'          => BASE_FOLDER . '/Exception/UserException.php',
    'Molajo\\User\\Exception\\UserExceptionInterface' => BASE_FOLDER . '/Exception/UserExceptionInterface.php',

    'Molajo\\User\\Type\\Public'                => BASE_FOLDER . '/Type/Public.php',
    'Molajo\\User\\Type\\Administrator'                   => BASE_FOLDER . '/Type/Administrator.php',
    'Molajo\\User\\Type\\Authenticated'                   => BASE_FOLDER . '/Type/Authenticated.php',
    'Molajo\\User\\Type\\Guest'                   => BASE_FOLDER . '/Type/Guest.php'
);

spl_autoload_register(
    function ($class) use ($classMap) {
        if (array_key_exists($class, $classMap)) {
            require_once $classMap[$class];
        }
    }
);

/*
include BASE_FOLDER . '/' . 'ClassLoader.php';
$loader = new ClassLoader();
$loader->add('Molajo', BASE_FOLDER . '/src/');
$loader->add('Testcase1', BASE_FOLDER . '/Tests/');
$loader->register();
*/
