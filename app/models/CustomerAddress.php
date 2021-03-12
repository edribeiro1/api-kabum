<?php

namespace app\models;

use app\core\Api;

class CustomerAddress extends Api
{

    private $table = 'customer_address';

    public function getAllAddressByCustomerId($id)
    {
        $this->db->where('customer_id', $id);
        $this->db->from($this->table);
        $result = $this->db->get(true);

        return $result;
    }
}
