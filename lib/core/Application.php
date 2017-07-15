<?php
namespace TestApp\Lib;

use Phlib\Logger;

class Application
{
    public $config;
    public $logger;
    private $controller;
    private $controllerName;
    private $model;

    public function __construct(array $config)
    {
        $this->config = $config;
        $loggerPool = new Logger\Pool(
            new Logger\Config($this->config['logger']),
            new Logger\Factory()
        );
        $this->logger = $loggerPool->getLogger('default');
    }

    /**
     * Connects the controller and calls the desired method
     *
     * @param $controller controller's name
     * @param $method method's name
     * @param array $args method's arguments
     */
    public function callController($controller, $method, array $args = [__CLASS__])
    {
        $this->controllerName = $controller;

        // include controller file
        $classFilename = $this->config['path']['controllers_path'] . "/$this->controllerName.php";
        $this->connectScript($classFilename);

        // instantiate controller
        $className = '\TestApp\Controllers\\' . $this->controllerName;
        if ($this->isValidClass($className)) {
            $this->controller = new $className($this);
        } else {
            $this->ApplicationError();
        }

        // call controller's method and pass arguments
        if (!method_exists($className, $method)) {
            $this->logger->critical("Method '$method' of class '$className' did not found", [__CLASS__]);
            $this->ApplicationError();
        }
        call_user_func_array([$this->controller, $method], $args);
    }

    public function ApplicationError()
    {
        $this->logger->info('Sending code 500 to client');
        http_response_code(500);
        echo 'Application Error';
        exit;
    }

    public function getModel()
    {
        if ($this->model !== null) {
            return $this->model;
        }

        // include model file
        $classFilename = $this->config['path']['models_path'] . "/$this->controllerName.php";
        $this->connectScript($classFilename);

        // instantiate model
        $className = '\TestApp\Models\\' . $this->controllerName;
        if ($this->isValidClass($className)) {
            $this->controller = new $className($this);
        } else {
            $this->ApplicationError();
        }
    }

    private function connectScript($path)
    {
        if (file_exists($path)) {
            include_once $path;
        } else {
            $this->logger->critical("File '$path' did not found", [__CLASS__]);
            $this->ApplicationError();
        }
    }

    private function isValidClass($className)
    {
        if (class_exists($className)) {
            return true;
        }
        return false;
    }

}
