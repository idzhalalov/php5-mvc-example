<?php
namespace TestApp\Controllers;

use TestApp\Lib\Application;
use TestApp\Lib\Controller;

class MainPage extends Controller
{
    private $model;
    private $recordsPerPage;
    private $isAdmin;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->model = $app->getModel('Tasks');
        $this->recordsPerPage = 3;
        $this->isAdmin = $this->app->isAdmin();
    }

    public function index()
    {
        // pagination
        $rowsCount = $this->model->rowsCount();
        $pagesCount = ceil($rowsCount / $this->recordsPerPage);

        $data = $this->model->get([], $this->recordsPerPage);

        $this->view->display('template.twig', [
            'tasks' => $data,
            'pagesCount' => $pagesCount,
            'isAdmin' => $this->isAdmin,
            'currentPage' => 1
        ]);
    }

    public function tasks($pageNum)
    {
        // pagination
        $rowsCount = $this->model->rowsCount();
        $pagesCount = ceil($rowsCount / $this->recordsPerPage);

        // current, prev, next page
        $endRecord = $this->recordsPerPage * $pageNum;
        $startRecord = $endRecord - $this->recordsPerPage;
        $prevPage = ($pageNum > 1) ? $pageNum - 1 : 1;
        $nextPage = ($pageNum < $pagesCount) ? $pageNum + 1 : $pagesCount;
        $data = $this->model->get([], "$startRecord, {$this->recordsPerPage}");

        $this->view->display('template.twig', [
            'tasks' => $data,
            'pagesCount' => $pagesCount,
            'currentPage' => $pageNum,
            'prevPage' => $prevPage,
            'nextPage' => $nextPage,
            'isAdmin' => $this->isAdmin
        ]);
    }
}