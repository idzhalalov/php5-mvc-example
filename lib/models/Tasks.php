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
     * @param int $id
     *
     * @return int Id of brand new task
     * @throws InvalidArgumentException
     */
    public function saveTask(array $data, $id = 0)
    {
        $id = (int) $id;
        if (!$data) {
            throw new InvalidArgumentException(__METHOD__ . ' requires non empty array "$data"');
        }
        $dataValues = array_values($data);
        if ($id === 0) {
            $dataFields = implode(', ', array_keys($data));
            $placeholders = str_repeat('?, ', count($dataValues));
            $placeholders = substr($placeholders, 0, strlen($placeholders) - 2);

            $sql = "INSERT INTO $this->tableName ($dataFields) VALUES ($placeholders)";
            $statement = $this->pdo->prepare($sql);
            $statement->execute($dataValues);
        } else {
            $dataFields = implode(' = ?, ', array_keys($data)) . ' = ?';
            $dataValues[] = $id;

            $sql = "UPDATE $this->tableName SET $dataFields WHERE id = ?";
            $statement = $this->pdo->prepare($sql);
            $statement->execute($dataValues);
        }
        return $this->pdo->lastInsertId();
    }
}