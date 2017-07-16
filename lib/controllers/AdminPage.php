<?php
namespace TestApp\Controllers;

use TestApp\Lib\Application;
use TestApp\Lib\Controller;

class AdminPage extends Controller
{
    private $model;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->model = $app->getModel('Tasks');
    }


    public function index()
    {
        if (!$this->app->isAdmin()) {
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

    public function task()
    {
        if (!$this->app->isAdmin()) {
            $this->app->ApplicationError('You must login first');
        }

        $taskId = $this->post('taskId');
        $task = null;
        if ($taskId) {
            $task = $this->model->get(['id' => $taskId])[0];
        }
        $this->view->display('template_admin.twig', ['task' => $task]);
    }
}