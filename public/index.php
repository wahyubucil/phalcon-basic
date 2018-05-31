<?php

use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Application;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers',
        APP_PATH . '/models'
    ]
);

$loader->register();

// Create a DI
$di = new FactoryDefault();

// Setup the view component
$di->set(
    'view',
    function() {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views');
        return $view;
    }
);

$di->set(
    'url',
    function() {
        $url = new UrlProvider();
        // $url->setBaseUri('/');
        $url->setBaseUri(''); // For development purposes in xampp
        return $url;
    }
);

// Setup the database service
$di->set(
    'db',
    function() {
        return new DbAdapter(
            [
                'host' => '127.0.0.1',
                'username' => 'root',
                'password' => '',
                'dbname' => 'phalcon_basic'
            ]
        );
    }
);

$application = new Application($di);
try {
    // Handle the request
    $response = $application->handle();
    
    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
?>