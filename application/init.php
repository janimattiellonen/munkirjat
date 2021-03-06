<?php

define('ROOT', dirname(dirname(__FILE__) ) );

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__DIR__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/library'),
    //realpath(APPLICATION_PATH . '/models'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Loader/Autoloader.php';

$autoloader = Zend_Loader_Autoloader::getInstance();

$config = array_reduce(array(
	new Zend_Config_Ini(APPLICATION_PATH . '/configs/base.ini', APPLICATION_ENV, true),
	new Zend_Config_Ini(APPLICATION_PATH . '/configs/mail.ini', APPLICATION_ENV, true),
    new Zend_Config(require APPLICATION_PATH . '/configs/routes.php'),
    new Zend_Config(require APPLICATION_PATH . '/configs/navigation.php'),
    ), function($config, $additional) {
        return $config->merge($additional);
    }, new Zend_Config(array(), true));
$config->setReadOnly();

Zend_Registry::set("config", $config);

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    $config
);

$application->bootstrap();
