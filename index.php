<?php
/**
 * Conventions:
 *
 * - controller name must be equivalent to controller's filename
 * - model name must be equivalent to model's filename and database table's name
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';
spl_autoload_register(function () {
    include_once __DIR__ . '/lib/core/Application.php';
    include_once __DIR__ . '/lib/core/Controller.php';
    include_once __DIR__ . '/lib/core/Model.php';
});
session_start();

// Instantiate application
$app = new TestApp\Lib\Application($config);

// Routing
$router = new \Bramus\Router\Router();
$router->get('/', function () use ($app) {
    $app->callController('MainPage', 'index');
});
// Tasks
$router->get('/tasks/(\d+)', function ($pageNum) use ($app) {
    $app->callController('MainPage', 'tasks', ['pageNum' => $pageNum]);
});
// Admin
$router->post('/login', function () use ($app) {
    $app->callController('TaskPage', 'login');
});
$router->post('/task/', function () use ($app) {
    $app->callController('TaskPage', 'task');
});
$router->post('/task/save', function () use ($app) {
    $app->callController('TaskPage', 'taskSave');
});
$router->get('/task', function () use ($app) {
    $app->callController('TaskPage', 'index');
});
$router->post('/logout', function () use ($app) {
    $app->callController('TaskPage', 'logout');
});

$router->run();
$app->clearTempData();
