<?php

namespace app\interfaces;

interface IDatabase {
    public function select($columns);
    public function where($key, $value=false, $cmp=" = ");
    public function from($table);
    public function get($fetchAll=false);
    public function count();
    public function insert();
    public function delete();
    public function update();
}