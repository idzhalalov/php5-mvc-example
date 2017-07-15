<?php
namespace TestApp\Lib\Model;

use TestApp\Lib\Application;

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
            $dsn = 'mysql:host=' . $this->app->config['host'] . ';dbname=' . $this->app->config['db_name'] . ';charset=utf8';
            $this->connection = new PDO($dsn, $this->app->config['user'], $this->app->config['password'], $options);
        } catch (PDOException $e) {
            throw new \Exception('Couldn\'t connect to DB: ' . $e->getMessage());
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