<?php
namespace TestApp\Models;

use TestApp\Lib;

class Tasks extends Lib\Model
{
    public function rowsCount()
    {
        $sql = 'SELECT count(id) as rows FROM ' . $this->tableName;
        return $this->pdo->query($sql)->fetch()['rows'];
    }
}