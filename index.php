<?php
/**
 * Created by IntelliJ IDEA.
 * User: idzhalalov
 * Date: 15.07.17
 * Time: 11:19 AM
 */
require __DIR__ . '/vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();
$controller = new \Lib\Controller\Controller();
// Routes
$router->match('GET', '/', function() {
    echo 'main page';
});
$router->match('GET', '/ololo/', function() {
    echo 'not main page';
});
$router->run();