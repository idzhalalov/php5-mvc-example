<?php
namespace TestApp\Lib;

use Phlib\Logger;

class Application
{
    public $config;
    public $logger;
    private $controller;
    private $controllerName;
    protected $models = [];

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
        $classFilename = $this->config['path']['controllers'] . "/$this->controllerName.php";
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

    public function ApplicationError($message = 'Application Error')
    {
        $this->logger->info('Sending code 500 to client');
        http_response_code(500);
        echo $message;
        exit;
    }

    public function getModel($name)
    {
        if (in_array($name, $this->models, true)) {
            return $this->models[$name];
        }

        // include model file
        $classFilename = $this->config['path']['models'] . "/$name.php";
        $this->connectScript($classFilename);

        // instantiate model
        $className = '\TestApp\Models\\' . $name;
        if ($this->isValidClass($className)) {
            $this->models[$name] = new $className($this, strtolower($name));
        } else {
            $this->ApplicationError();
        }
        return $this->models[$name];
    }

    private function connectScript($path)
    {
        if (file_exists($path)) {
            $this->logger->info('Including ' . $path);
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

