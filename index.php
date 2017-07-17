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
$router->post('/admin', function () use ($app) {
    $app->callController('AdminPage', 'login');
});
$router->post('/admin/task/', function () use ($app) {
    $app->callController('AdminPage', 'task');
});
$router->post('/admin/task/save', function () use ($app) {
    $app->callController('AdminPage', 'taskSave');
});
$router->get('/admin', function () use ($app) {
    $app->callController('AdminPage', 'index');
});
$router->post('/admin/logout', function () use ($app) {
    $app->callController('AdminPage', 'logout');
});

$router->run();
$app->clearTempData();
