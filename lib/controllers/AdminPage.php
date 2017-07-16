<?php
namespace TestApp\Controllers;

use TestApp\Lib\Controller;

class AdminPage extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['admin'])) {
            $this->app->ApplicationError('You must login first');
        }
        $this->view->display('template_admin.twig');
    }

    public function login()
    {
        $username = $this->post('username');
        $password = $this->post('password');

        if ($username === null || $password === null) {
            $this->app->ApplicationError('Please, provide correct Username and Password');
        }

        if ($username === 'admin' && $password === '123') {
            $_SESSION['admin'] = 1;
            header("Location: {$_SERVER['HTTP_ORIGIN']}/admin");
            exit();
        }
    }
}