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
        $username = $this->post('username', '');
        $password = $this->post('password', '');

        if ($username === 'admin' && $password === '123') {
            $_SESSION['admin'] = 1;
            header("Location: {$_SERVER['HTTP_ORIGIN']}/admin");
            return;
        }
        header("Location: {$_SERVER['HTTP_ORIGIN']}/");
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

    public function taskSave()
    {
        if (!$this->app->isAdmin()) {
            $this->app->ApplicationError('You must login first');
        }
        $errorMessage = '';

        // processing POST
        $taskId = $this->post('taskId');
        $userName = $this->post('user_name', '');
        $userEmail = $this->post('user_email');
        $text = $this->post('text', '');
        $is_done = $this->post('is_done', false) ? 1 : 0;
        $task = [
            'user_name' => $userName,
            'user_email' => $userEmail,
            'text' => $text,
            'is_done' => $is_done
        ];
        // required fields
        if (empty($userName) || empty($text)) {
            $errorMessage = 'Please, fill all of required fields';
        }
        // email validation
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = 'Please, provide correct email address';
        }
        if (!empty($errorMessage)) {
            $this->view->display('template_admin.twig', [
                'task' => $task,
                'error_message' => $errorMessage]);
            return;
        }

        // processing image


        if ($taskId !== null) {
            $taskId['id'] = $taskId;
        }
        $this->model->saveTask($task);
        $this->view->display('template_admin.twig', [
            'success_message' => 'The task was created!'
        ]);
    }

    public function logout()
    {
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }
        header("Location: {$_SERVER['HTTP_ORIGIN']}/");
    }
}