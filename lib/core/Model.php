<?php
namespace TestApp\Lib;

use PDO;

/**
 * Class Model
 * @package TestApp\Lib
 */
abstract class Model
{
    protected $tableName;
    protected $app;
    private $pdo;

    public function __construct(Application $app, $tableName)
    {
        $this->app = $app;
        $this->tableName = $tableName;
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => true,
            PDO::MYSQL_ATTR_FOUND_ROWS => true
        );
        try {
            $dsn = 'mysql:host=' . $this->app->config['database']['host'] . ';dbname=' .
                $this->app->config['database']['db_name'] . ';charset=utf8';
            $this->pdo = new PDO($dsn, $this->app->config['database']['user'],
                $this->app->config['database']['password'], $options);
        } catch (\PDOException $e) {
            $this->app->logger->critical('Could not connect to DB: ' . $e->getMessage());
            $this->app->ApplicationError('Database Error');
        }
    }

//    public function save(array $data, array $where = [])
//    {
//        $insert = true;
//        if (in_array('id', $where, true)) {
//            $insert = false;
//        }
//    }


    /**
     * @param array $where
     * @param null $limit
     * @return array
     */
    public function get(array $where = [], $limit = null)
    {
        $whereClause = null;
        if ($limit !== null) {
            $limit = ' LIMIT ' . $limit;
        }
        if ($where) {
            $whereClause = ' WHERE ';
            foreach ($where as $filedName => $value) {
                $whereClause .= $filedName . '= :' . $filedName;
            }
        }
        $sql = 'SELECT * FROM ' . $this->tableName . $whereClause . $limit;
        $statement = $this->pdo->prepare($sql);
        $statement->execute($where);
        return $statement->fetchAll();
    }

//    public function delete(array $where = [])
//    {
//
//    }
//
//    protected function setTableName($name)
//    {
//
//    }
}