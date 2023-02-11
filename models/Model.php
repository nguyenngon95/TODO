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

    public function select($columns = '*', $where = null)
    {
        try {
            $sql = "select $columns from $this->tableName";

            if ($where) {
                $sql .= " where $where";
            }
            
            $q = $this->database->prepare($sql);
            $q->execute();

            return $q->fetchAll();
        } catch (\PDOException $e) {
            $this->handlePDOException($e);
        }
    }

    public function insert($columns = [])
    {
        try {
            $sql = "insert into $this->tableName (";
            
            foreach (array_keys($columns) as $key) {
                $sql .= "$key, ";
            }

            $sql = rtrim($sql, ', ');
            $sql .= ") values (";

            foreach ($columns as $value) {
                $sql .= "'$value', ";
            }

            $sql = rtrim($sql, ', ');
            $sql .= ")";

            $q = $this->database->prepare($sql);
            $q->execute();

            return true;
        } catch (\PDOException $e) {
            $this->handlePDOException($e);
        }
    }

    public function update($columns = [], $where = null)
    {
        try {
            $sql = "update $this->tableName set ";

            foreach ($columns as $key => $value) {
                $sql .= "$key = '$value', ";
            }

            $sql = rtrim($sql, ', ');
            
            if ($where) {
                $sql .= " where $where";
            }
            
            $q = $this->database->prepare($sql);
            $q->execute();

            return true;
        } catch (\PDOException $e) {
            $this->handlePDOException($e);
        }
    }

    public function delete($where)
    {
        try {
            $sql = "delete from $this->tableName where $where";
            $q = $this->database->prepare($sql);
            $q->execute();

            return true;
        } catch (\PDOException $e) {
            $this->handlePDOException($e);
        }
    }

    protected function handlePDOException($e)
    {
        $error = 'DB error: ' . $e->getMessage();
        return view('error', compact('error'), 500);
    }
}