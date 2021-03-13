<?php

namespace app\interfaces;

interface IDatabase {
    public function select($columns);
    public function where($key, $value, $cmp=" = ");
    public function like($key, $value);
    public function from($table);
    public function get($fetchAll=false);
    public function count();
    public function insert();
    public function delete();
    public function update();
}