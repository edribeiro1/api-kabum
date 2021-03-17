<?php

namespace app\storage;

class CustomerAddressStorage extends DatabaseStorage
{
    private $schema = 'customer_address';

    public function insert(array $addresses, int $id)
    {
        foreach ($addresses as $address) {
            $this->db->table($this->schema);
            $this->db->insert([
                'customer_id' => $id,
                'address' => $address
            ]);
        }
    }

    public function deleteAddressesByCustomerId(int $id)
    {
        $this->db->where('customer_id', $id);
        $this->db->table($this->schema);
        $status = $this->db->delete();
        return $status;
    }

    public function getAllAddressByCustomerId(int $id)
    {
        $this->db->where('customer_id', $id);
        $this->db->table($this->schema);
        $result = $this->db->get(true);

        return $result;
    }
}
