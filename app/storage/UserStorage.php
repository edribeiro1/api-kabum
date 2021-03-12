<?php

namespace app\storage;
use app\entities\User;

class UserStorage extends DatabaseStorage
{
    private $schema = 'user';

    public function getUserByUsername($username="")
    {
        // $this->db->select('id, username, password');
        $this->db->where('username', $username);
        $this->db->from($this->schema);
        return $this->db->get();
    }
}
