<?php

namespace Models;

class Model
{
    public string $tableName;

    public $database;
    
    public function __construct()
    {
        global $db;
        $this->database = $db;
    }

    public function select($columns = '*')
    {
        $sql = "select $columns from $this->tableName";
        $q = $this->database->prepare($sql);
        $q->execute();

        return $q->fetchAll();
    }

    public function insert($columns = [])
    {
        $sql = "insert into $this->tableName (";
        
        foreach (array_keys($columns) as $key) {
            $sql .= "$key, ";
        }

        $sql = rtrim($sql, ', ');
        $sql .= ") values (";

        foreach ($columns as $value) {
            $sql .= "$value, ";
        }

        $sql = rtrim($sql, ', ');
        $sql .= ")";

        $q = $this->database->prepare($sql);
        $q->execute();
    }

    public function update($columns = [], $where)
    {
        $sql = "update $this->tableName set ";

        foreach ($columns as $key => $value) {
            $sql .= "$key = $value, ";
        }

        $sql = rtrim($sql, ', ');
        $sql .= " where $where";
        $q = $this->database->prepare($sql);
        $q->execute();
    }

    public function delete($where)
    {
        $sql = "delete from $this->tableName where $where";
        $q = $this->database->prepare($sql);
        $q->execute();
    }
}