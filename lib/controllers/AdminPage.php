<?php
namespace TestApp\Controllers;

use TestApp\Lib\Application;
use TestApp\Lib\Controller;
use Upload\Exception\UploadException;

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

        // processing image
        if (isset($_FILES['picture']) && file_exists($_FILES['picture']['tmp_name'])) {
            try {
                $task['picture'] = $this->uploadPicture();
            } catch (UploadException $exception) {
                $errorMessage = $exception->getMessage();
            }
        }

        // finally check for errors
        if (!empty($errorMessage)) {
            $this->view->display('template_admin.twig', [
                'task' => $task,
                'error_message' => $errorMessage]);
            return;
        }

        $this->model->saveTask($task, $taskId);
        $this->view->display('template_admin.twig', [
            'success_message' => 'The task is saved!'
        ]);
    }


    /**
     * @throws UploadException On file upload error
     */
    private function uploadPicture()
    {
        try {
            $storage = new \Upload\Storage\FileSystem($this->app->config['pictures']['path']);
            $file = new \Upload\File('picture', $storage);
        } catch (\InvalidArgumentException $exception) {
            throw new UploadException($exception->getMessage());
        }
        $newFilename = uniqid('task_', time());
        $file->setName($newFilename);
        $file->addValidations([
            new \Upload\Validation\Mimetype(['image/png', 'image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg']),
            new \Upload\Validation\Extension(['jpg', 'png', 'gif']),
        ]);
        try {
            $pictureSize = $file->getDimensions();
            $pictureExt = $file->getExtension();
            $file->upload();
        } catch (\Exception $e) {
            $errorMessage = $file->getErrors();
            if (is_array($errorMessage)) {
                throw new UploadException('Picture error: ' . implode(', ', $errorMessage));
            }
        }
        if ($file->isOk()) {
            // resize image
            if ($pictureSize['width'] > $this->app->config['pictures']['max_width'] ||
                $pictureSize['width'] > $this->app->config['pictures']['max_height']
            ) {
                \Gregwar\Image\Image::open($this->app->config['pictures']['path'] . '/' . $newFilename . '.' . $pictureExt)
                    ->cropResize($this->app->config['pictures']['max_width'], $this->app->config['pictures']['max_height'])
                    ->save($this->app->config['pictures']['path'] . '/' . $newFilename . '.' . $pictureExt);
            }
        }
        return $newFilename . '.' . $pictureExt;
    }

    public function logout()
    {
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }
        header("Location: {$_SERVER['HTTP_ORIGIN']}/");
    }
}