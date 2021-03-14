<?php

namespace app\interfaces;

interface IDatabase
{
    public function select($columns);
    public function limit($limit);
    public function offset($offset);
    public function where($key, $value, $cmp = " = ");
    public function like($key, $value);
    public function orderBy($column, $order = "ASC");
    public function table($table);
    public function get($fetchAll = false);
    public function count();
    public function insert($dataInsert);
    public function delete();
    public function update();
}
