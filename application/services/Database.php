<?php

class Database
{
    private $columns = '*';
    private $where = "";
    private $table = false;

    public function __construct()
    {
        $this->connection = mysqli_connect(
            $_ENV['MYSQL_HOST'],
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'],
            $_ENV['MYSQL_DATABASE'],
            $_ENV['MYSQL_PORT']
        );
    }

    public function select($columns)
    {
        if (is_array($columns) && count($columns) > 0) {
            $this->columns = implode(',', $columns);
        } elseif (is_string($columns) && strlen($columns) > 0) {
            $this->columns = $columns;
        }
    }

    public function from($table)
    {
        if (is_string($table) && strlen($table)) {
            $this->table = $table;
        }
    }

    public function get()
    {
        if ($this->table && $this->where) {
            $query = "SELECT $this->columns 
                      FROM $this->table 
                      $this->where";

            $result = mysqli_query($this->connection, $query);
            $this->cleanAfterOperation();
        }
    }

    public function insert()
    {
    }

    public function delete()
    {
    }

    public function update()
    {
    }

    private function cleanAfterOperation()
    {
        $this->columns = '*';
        $this->where = false;
        $this->table = false;
    }
}
