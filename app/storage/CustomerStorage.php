<?php

namespace app\storage;

use app\entities\Customer;
use app\dto\ListDTO;
use Exception;

class CustomerStorage extends DatabaseStorage
{

    private $schema = 'customer';

    public function count(ListDTO $params)
    {

        if (!is_null($params['search_column']) && !is_null($params['search'])) {
            $this->db->like($params['search_column'], $params['search']);
        }

        $this->db->from($this->table);
        $total = $this->db->count();
        return $total;
    }

    public function list(ListDTO $params)
    {

        if (!is_null($params['search_column']) && !is_null($params['search'])) {
            $this->db->like($params['search_column'], $params['search']);
        }
        
        $this->db->from($this->table);
        $result = $this->db->get(true);
        return $result;
    }

    public function getCustomerById($id)
    {
        $this->db->where('id', $id);
        $this->db->from($this->schema);
        $result = $this->db->get();

        if (count($result)) {
            return new Customer(
                $result['name'],
                $result['birth_date'],
                $result['cpf'],
                $result['rg'],
                $result['phone_number'],
                $result['id']
            );
        }

        throw new Exception('Customer not found', 400);

        // if ($result) {
        //     $customerAddress = new CustomerAddress();
        //     $addresses = $customerAddress->getAllAddressByCustomerId($id);
        //     $result['addresses'] = $addresses ? $addresses : [];
        // }

    }
}
