<?php
namespace TestApp\Lib;

abstract class Controller
{
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