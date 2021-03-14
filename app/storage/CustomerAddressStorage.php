<?php

namespace app\storage;

use app\entities\CustomerAddress;

class CustomerAddressStorage extends DatabaseStorage
{
    private $schema = 'customer_address';

    public function getAllAddressByCustomerId($id)
    {
        $this->db->where('customer_id', $id);
        $this->db->table($this->schema);
        $result = $this->db->get(true);

        return $result;
    }
}
