<?php

namespace app\storage;

use app\entities\Customer;

class CustomerStorage extends DatabaseStorage
{

    private $schema = 'customer';
    public function getAllCustomer()
    {
        $this->db->from($this->table);
        $total = $this->db->count();
        $rows = [];
        
        if ($total) {
            $this->db->from($this->table);
            $result = $this->db->get(true);

            if ($result) {
                $rows = $result;
            }
        }

        return ['total' => $total, 'rows' => $rows];
    }

    public function getCustomerById($id)
    {
        $this->db->where('id', $id);
        $this->db->from($this->schema);
        $result = $this->db->get();

        // if ($result) {
        //     $customerAddress = new CustomerAddress();
        //     $addresses = $customerAddress->getAllAddressByCustomerId($id);
        //     $result['addresses'] = $addresses ? $addresses : [];
        // }

        return $result;
    }
}
