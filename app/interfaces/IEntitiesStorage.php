<?php

namespace app\interfaces;

interface IEntitiesStorage {
    public function count($filters);
    public function list($filter, $limit, $offset, $orderBy);
}