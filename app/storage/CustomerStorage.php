<?php

namespace app\storage;

use app\entities\Customer;
use app\dto\ListDTO;
use Exception;

class CustomerStorage extends DatabaseStorage
{

    private $schema = 'customer';

    public function update(array $customer)
    {
        $this->db->where('id', $customer['id']);
        $this->db->table($this->schema);
        unset($customer['id']);
        $this->db->setAll($customer);
        $this->db->update();
    }

    public function save(array $customer)
    {
        $this->db->table($this->schema);
        $this->db->insert($customer);
    }

    public function count(ListDTO $params)
    {
        if (!is_null($params->searchColumn) && !is_null($params->search)) {
            $this->db->like($params->searchColumn, $params->search);
        }

        $this->db->table($this->schema);
        $total = $this->db->count();

        return $total;
    }

    public function list(ListDTO $params)
    {
        if (!is_null($params->searchColumn) && !is_null($params->search)) {
            $this->db->like($params->searchColumn, $params->search);
        }

        if (!is_null($params->limit) && !is_null($params->offset)) {
            $this->db->limit($params->limit);
            $this->db->offset($params->offset);
        }

        if (!is_null($params->sortColumn)) {
            $this->db->orderBy($params->sortColumn, $params->order);
        }

        $this->db->table($this->schema);
        $result = $this->db->get(true);
        return $result;
    }

    public function getCustomerById(int $id)
    {
        $this->db->where('id', $id);
        $this->db->table($this->schema);
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

    public function delete(int $id)
    {
        $this->db->where('id', $id);
        $this->db->table($this->schema);
        $status = $this->db->delete();

        return $status;
    }
}
