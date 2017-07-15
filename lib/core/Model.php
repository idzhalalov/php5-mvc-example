<?php
namespace TestApp\Lib\Model;

use TestApp\Lib\Application;
use PDO;

abstract class Model
{
    private $connection;
    private $tableName;
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => true,
            PDO::MYSQL_ATTR_FOUND_ROWS => true
        );
        try {
            $dsn = 'mysql:host=' . $this->app->config['database']['host'] . ';dbname=' .
                $this->app->config['database']['db_name'] . ';charset=utf8';
            $this->connection = new PDO($dsn, $this->app->config['database']['user'],
                $this->app->config['database']['password'], $options);
        } catch (\PDOException $e) {
            $this->app->logger->critical('Could not connect to DB: ' . $e->getMessage());
            $this->app->ApplicationError('Database Error');
        }
    }

    public function save()
    {

    }

    public function get()
    {

    }

    public function delete()
    {

    }
}