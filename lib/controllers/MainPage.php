<?php
namespace TestApp\Controllers;

use TestApp\Lib\Application;
use TestApp\Lib\Controller;
use TestApp\Models\Tasks;

class MainPage extends Controller
{
    private $model;
    private $recordsPerPage;
    private $isAdmin;

    protected $rowsCount;
    protected $pagesCount;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->model = new Tasks($app);
        $this->isAdmin = $this->app->isAdmin();
        $this->recordsPerPage = 3;
        $this->rowsCount = $this->model->rowsCount();
        $this->pagesCount = ceil($this->rowsCount / $this->recordsPerPage);
    }

    public function index()
    {
        $data = $this->model->get([], $this->recordsPerPage);

        $this->view->display('template.twig', [
            'tasks' => $data,
            'pagesCount' => $this->pagesCount,
            'isAdmin' => $this->isAdmin,
            'currentPage' => 1,
            'pictures_url' => $this->app->config['application']['url'] . $this->app->config['pictures']['path']
        ]);
    }

    public function tasks($pageNum)
    {
        // current, prev, next page
        $endRecord = $this->recordsPerPage * $pageNum;
        $startRecord = $endRecord - $this->recordsPerPage;
        $prevPage = ($pageNum > 1) ? $pageNum - 1 : 1;
        $nextPage = ($pageNum < $this->pagesCount) ? $pageNum + 1 : $this->pagesCount;
        $data = $this->model->get([], "$startRecord, {$this->recordsPerPage}");

        $this->view->display('template.twig', [
            'tasks' => $data,
            'pagesCount' => $this->pagesCount,
            'currentPage' => $pageNum,
            'prevPage' => $prevPage,
            'nextPage' => $nextPage,
            'isAdmin' => $this->isAdmin,
            'pictures_url' => $this->app->config['application']['url'] . $this->app->config['pictures']['path']
        ]);
    }
}