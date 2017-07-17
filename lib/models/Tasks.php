<?php
namespace TestApp\Models;

use Psr\Log\InvalidArgumentException;
use TestApp\Lib;

class Tasks extends Lib\Model
{
    public function rowsCount()
    {
        $sql = 'SELECT count(id) as rows FROM ' . $this->tableName;
        return $this->pdo->query($sql)->fetch()['rows'];
    }

    /**
     * Saves task
     *
     * @param array $data
     * @param null $id
     *
     * @return int Id of brand new task
     * @throws InvalidArgumentException
     */
    public function saveTask(array $data, $id = null)
    {
        if (!$data) {
            throw new InvalidArgumentException(__METHOD__ . ' requires non empty array "$data"');
        }
        $dataValues = array_values($data);
        $dataFields = implode(', ', array_keys($data));
        $placeholders = str_repeat('?, ', count($dataValues));
        $placeholders = substr($placeholders, 0, strlen($placeholders) - 2);
        if ($id === null) {
            $sql = "INSERT INTO $this->tableName ($dataFields) VALUES ($placeholders)";
            $statement = $this->pdo->prepare($sql);
            $statement->execute($dataValues);
        }
        return $this->pdo->lastInsertId();
    }
}