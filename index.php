<?php
/**
 * Created by IntelliJ IDEA.
 * User: idzhalalov
 * Date: 15.07.17
 * Time: 11:19 AM
 */
require __DIR__ . '/vendor/autoload.php';
spl_autoload_register(function () {
    include __DIR__ . '/lib/Controller.php';
    include __DIR__ . '/lib/Model.php';
    include __DIR__ . '/lib/View.php';
});

function controllerExec($controller, $method, array $args = [])
{
    $classFilename = __DIR__ . "/controllers/$controller.php";
    spl_autoload_register(function () use ($classFilename) {
        if (file_exists($classFilename)) {
            include $classFilename;
        } else {
            throw new InvalidArgumentException("Class $classFilename did not found");
        }
    });
    $className = '\TestApp\Controllers\\' . $controller;
    if (class_exists($className)) {
        $class = new $className();
    }
    if (method_exists($className, $method)) {
        call_user_func_array([$class, $method], $args);
    }
}

// Create Router instance
$router = new \Bramus\Router\Router();

// Routes
$router->get('/', controllerExec('MainPage', 'index'));
$router->match('GET', '/ololo/', function () {
    echo 'not main page';
});
$router->run();