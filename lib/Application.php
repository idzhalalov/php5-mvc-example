<?php
namespace TestApp\Lib;

use TestApp\Lib\Exceptions\AppplicationErrorException as ApplicationError;
use Phlib\Logger;

class Application
{
    public $config;
    private $logger;

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
        $classFilename = $this->config['abs_path'] . "/controllers/$controller.php";
        spl_autoload_register(function () use ($classFilename) {
            if (file_exists($classFilename)) {
                include_once $classFilename;
            } else {
                $this->logger->critical("File '$classFilename' did not found", [__CLASS__]);
                $this->ApplicationError();
            }
        });

        $className = '\TestApp\Controllers\\' . $controller;
        if (!class_exists($className)) {
            $this->logger->critical("Class '$className' did not found", [__CLASS__]);
            $this->ApplicationError();
        }
        $class = new $className($this);

        if (!method_exists($className, $method)) {
            $this->logger->critical("Method '$method' of class '$className' did not found", [__CLASS__]);
            $this->ApplicationError();
        }
        call_user_func_array([$class, $method], $args);
    }

    public function ApplicationError()
    {
        $this->logger->info('Sending code 500 to client');
        http_response_code(500);
        echo 'Application Error';
        exit;
    }
}
