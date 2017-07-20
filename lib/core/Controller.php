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
        return $this->superGlobals($var, $_POST, $default);
    }

    public function get($var, $default = null)
    {
        return $this->superGlobals($var, $_GET, $default);
    }

    private function superGlobals($var, array &$superGlobal, $default = null)
    {
        $result = $default;
        if (isset($superGlobal[$var])) {
            $result = $this->sanitize($superGlobal[$var]);
        }
        if (!empty($result) && $result !== null) {
            return $result;
        } else {
            return $default;
        }

        return null;
    }

    protected function sanitize($var)
    {
        $var = strip_tags($var);
        $var = stripcslashes($var);

        return $var;
    }
}
