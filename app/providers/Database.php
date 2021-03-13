<?php

namespace app\providers;

use app\interfaces\IDatabase;
use Exception;

class Database implements IDatabase
{

    private $columns = '*';
    private $where = "";
    private $stmtParams = [];
    private $stmtTypes = '';
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

    public function typeValue($value): string
    {
        $type = gettype($value);
        switch ($type) {
            case 'integer':
                return 'i';
                break;
            case 'double':
                return 'd';
                break;
            default:
                return 's';
                break;
        }
    }

    public function where($key, $value, $cmp = " = ")
    {
        $prefix = 'WHERE';
        if (strlen($this->where) > 1) {
            $prefix = ' AND';
        }
        if (
            validateString($key) &&
            (is_string($value) || is_integer($value) || is_double($value) || is_array($value))
        ) {
            if (is_array($value)) {
                if (count($value)) {
                    $stmtType = $this->typeValue($value[0]);
                    $mark = implode(',', array_fill(0, count($value), '?'));
                    $this->where .= "$prefix $key $cmp ($mark)";
                    $this->stmtTypes .= str_repeat($stmtType, count($value));
                    $this->stmtParams = array_merge($this->stmtParams, $value);
                }
            } else {
                $this->where .= "$prefix $key $cmp ?";
                $this->stmtTypes .= $this->typeValue($value);
                $this->stmtParams[] = $value;
            }
        } else {
            throw new Exception('Parameters in the method where are invalid', 500);
        }
    }

    public function like($key, $value)
    {
        $prefix = 'WHERE';
        if (strlen($this->where) > 1) {
            $prefix = ' AND';
        }

        if (validateString($key) && validateString($value)) {
            $this->where .= "$prefix $key LIKE ? ";
            $this->stmtTypes .= $this->typeValue($value);
            $this->stmtParams[] = "%$value%";
        } else {
            throw new Exception('Parameters in the method like are invalid', 500);
        }
    }

    public function from($table)
    {
        if (is_string($table) && strlen($table)) {
            $this->table = $table;
        }
    }

    public function get($fetchAll = false): array
    {
        $data = [];
        if ($this->table) {

            $stmtQuery = "SELECT $this->columns FROM $this->table $this->where";

            if ($statement = $this->connection->prepare($stmtQuery)) {

                if ($this->where) {
                    $statement->bind_param($this->stmtTypes, ...$this->stmtParams);
                }
                $statement->execute();
                $result = $statement->get_result();

                if ($result->num_rows) {

                    if ($fetchAll) {
                        $data = $result->fetch_all(MYSQLI_ASSOC);
                    } else {
                        $data = $result->fetch_assoc();
                    }
                }

                $statement->close();
            };

            $this->cleanAfterOperation();
        }

        return $data;
    }

    public function count()
    {
        if ($this->table) {
            $stmtQuery = "SELECT count(*) as total FROM $this->table $this->where";

            if ($statement = $this->connection->prepare($stmtQuery)) {
                if ($this->where) {
                    $statement->bind_param($this->stmtTypes, ...$this->stmtParams);
                }
                $statement->execute();
                $result = $statement->get_result();
                if ($result->num_rows) {
                    $data = $result->fetch_assoc();
                    return $data['total'];
                }
            }
        }

        return 0;
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
        $this->stmtParams = [];
        $this->stmtTypes = '';
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}
