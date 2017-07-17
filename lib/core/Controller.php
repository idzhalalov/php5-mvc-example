<?php
namespace TestApp\Lib;

use Twig_Environment;
use Twig_Loader_Filesystem;

abstract class Controller
{
    protected $app;
    protected $view;

    public function __construct(Application $app)
    {
        $this->app = $app;

        // views
        $loader = new Twig_Loader_Filesystem($this->app->config['application']['views']);
        $this->view = new Twig_Environment($loader, array(
            'cache' => $this->app->config['application']['views_cache'],
        ));
    }

    public function post($var, $default = null)
    {
        if (isset($_POST[$var])) {
            return $this->sanitize($_POST[$var]);
        } else {
            return $default;
        }
    }

    public function get($var, $default = null)
    {
        if (isset($_GET[$var])) {
            return $this->sanitize($_GET[$var]);
        } else {
            return $default;
        }
    }

    protected function sanitize($var)
    {
        $var = strip_tags($var);
        $var = stripcslashes($var);

        return $var;
    }

}