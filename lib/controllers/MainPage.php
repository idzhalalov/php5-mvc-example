<?php
namespace TestApp\Controllers;

use TestApp\Lib\Controller;
use TestApp\Lib\Application;

class MainPage extends Controller
{
    private $model;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->model = $app->getModel('Tasks');
    }

    public function index()
    {
        $data = $this->model->get(['user_name' => 'Max'], 1);
        print_r($data);
    }
}