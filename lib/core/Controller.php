<?php
namespace TestApp\Lib;
use Twig_Loader_Filesystem;
use Twig_Environment;

abstract class Controller
{
    protected $app;
    protected $view;
    protected $model;

    public function __construct(Application $app)
    {
        $this->app = $app;

        // model
        $this->model = $this->app->getModel();

        // views
        $loader = new Twig_Loader_Filesystem($this->app->config['path']['views']);
        $this->view = new Twig_Environment($loader, array(
            'cache' => $this->app->config['path']['views_cache'],
        ));
    }

    public function post($var, $default = null)
    {
        if (isset($_POST[$var])) {
            return $_POST[$var];
        } else {
            return $default;
        }
    }

    public function get($var, $default = null)
    {
        if (isset($_GET[$var])) {
            return $_GET[$var];
        } else {
            return $default;
        }
    }

}