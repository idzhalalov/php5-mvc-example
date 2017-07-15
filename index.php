<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';
spl_autoload_register(function () {
    include_once __DIR__ . '/lib/Application.php';
    include_once __DIR__ . '/lib/Controller.php';
    include_once __DIR__ . '/lib/Model.php';
    include_once __DIR__ . '/lib/View.php';
});

// Instantiate application
$app = new TestApp\Lib\Application($config);

// Routing
$router = new \Bramus\Router\Router();

$router->get('/', function () use ($app) {
    $app->callController('MainPage', 'index');
});
$router->get('/admin', function () use ($app) {
    $app->callController('AdminPage', 'index');
});

$router->run();
