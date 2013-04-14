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

$classMap = array(

    'Molajo\\Foundation\\Permissions\\PermissionsInterface'                                   => BASE_FOLDER . '/.dev/Tests/Permissions/PermissionsInterface.php',
    'Molajo\\Foundation\\Permissions\\Permissions'                                            => BASE_FOLDER . '/.dev/Tests/Permissions/Permissions.php',
    'Molajo\\Foundation\\Permissions\\Permissions\\Exception\\PermissionsException'           => BASE_FOLDER . '/.dev/Tests/Permissions/Exception/PermissionsException.php',
    'Molajo\\Foundation\\Permissions\\Permissions\\Exception\\PermissionsException\Interface' => BASE_FOLDER . '/.dev/Tests/Permissions/Exception/PermissionsExceptionInterface.php',
    'Molajo\\User\\User'                                                                      => BASE_FOLDER . '/User.php',
    'Molajo\\User\\UserInterface'                                                             => BASE_FOLDER . '/UserInterface.php',
    'PasswordLib\\PasswordLib'                                                                => BASE_FOLDER . '/Authentication/PasswordLib.phar',
    'Molajo\\User\\Authentication\\Anonymous'                                                 => BASE_FOLDER . '/Authentication/Anonymous.php',
    'Molajo\\User\\Authentication\\Authentication'                                            => BASE_FOLDER . '/Authentication/Authentication.php',
    'Molajo\\User\\Authentication\\AuthenticationInterface'                                   => BASE_FOLDER . '/Authentication/AuthenticationInterface.php',
    'Molajo\\User\\Authentication\\Http'                                                      => BASE_FOLDER . '/Authentication/Http.php',
    'Molajo\\User\\Authentication\\Rememberme'                                                => BASE_FOLDER . '/Authentication/Rememberme.php',
    'Molajo\\User\\Authentication\\User'                                                      => BASE_FOLDER . '/Authentication/User.php',
    'Molajo\\User\\Authorisation\\UserAuthorisation'                                          => BASE_FOLDER . '/Authorisation/UserAuthorisation.php',
    'Molajo\\User\\Authorisation\\UserAuthorisationInterface'                                 => BASE_FOLDER . '/Authorisation/UserAuthorisationInterface.php',
    'Molajo\\User\\Email\\EmailInterface'                                                     => BASE_FOLDER . '/Email/EmailInterface.php',
    'Molajo\\User\\Email\\UserEmail'                                                          => BASE_FOLDER . '/Email/UserEmail.php',
    'Molajo\\User\\Exception\\AuthenticationException'                                        => BASE_FOLDER . '/Exception/AuthenticationException.php',
    'Molajo\\User\\Exception\\AuthorisationException'                                         => BASE_FOLDER . '/Exception/AuthorisationException.php',
    'Molajo\\User\\Exception\\PasswordException'                                              => BASE_FOLDER . '/Exception/PasswordException.php',
    'Molajo\\User\\Exception\\PermissionsException'                                           => BASE_FOLDER . '/Exception/PermissionsException.php',
    'Molajo\\User\\Exception\\SessionException'                                               => BASE_FOLDER . '/Exception/SessionException.php',
    'Molajo\\User\\Exception\\UserEmailException'                                             => BASE_FOLDER . '/Exception/UserEmailException.php',
    'Molajo\\User\\Exception\\UserException'                                                  => BASE_FOLDER . '/Exception/UserException.php',
    'Molajo\\User\\Exception\\UserExceptionInterface'                                         => BASE_FOLDER . '/Exception/UserExceptionInterface.php',
    'Molajo\\User\\Session\\SessionInterface'                                                 => BASE_FOLDER . '/Session/SessionInterface.php',
    'Molajo\\User\\Session\\Session'                                                          => BASE_FOLDER . '/Session/Session.php',
    'Molajo\\User\\Type\\Administrator'                                                       => BASE_FOLDER . '/Type/Administrator.php',
    'Molajo\\User\\Type\\Authenticated'                                                       => BASE_FOLDER . '/Type/Authenticated.php',
    'Molajo\\User\\Type\\Guest'                                                               => BASE_FOLDER . '/Type/Guest.php',
    'Molajo\\User\\Type\\Public'                                                              => BASE_FOLDER . '/Type/Public.php',
    'Molajo\\User\\Type\\UserType'                                                            => BASE_FOLDER . '/Type/UserType.php'
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
