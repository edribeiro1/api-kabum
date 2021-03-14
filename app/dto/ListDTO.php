<?php

namespace app\dto;

class ListDTO
{

    public $limit = null;
    public $offset = null;
    public $sortColumn = null;
    public $order = 'ASC';
    public $search = null;
    public $searchColumn = null;

    public function __construct($params = [])
    {
        if (isset($params['limit']) && is_numeric($params['limit']) && (int)$params['limit'] > 0) {
            $this->limit = (int)$params['limit'];
        }

        if (isset($params['offset']) && is_numeric($params['offset']) && (int)$params['offset'] >= 0) {
            $this->offset = (int)$params['offset'];
        }

        if (isset($params['sort']) && validateString($params['sort'])) {
            $this->sortColumn = trim($params['sort']);
        }

        if (isset($params['order']) && validateString($params['order']) && strtoupper($params['order']) === 'DESC') {
            $this->order = strtoupper(trim($params['order']));
        }

        if (isset($params['search']) && validateString($params['search'])) {
            $this->search = trim($params['search']);
        }

        if (isset($params['search_column']) && validateString($params['search_column'])) {
            $this->searchColumn = trim($params['search_column']);
        }
    }
}
