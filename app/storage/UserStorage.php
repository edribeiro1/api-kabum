<?php

namespace app\storage;
use app\entities\User;

class UserStorage extends DatabaseStorage
{
    private $schema = 'user';

    public function getUserByUsername($username="")
    {
        $this->db->where('username', $username);
        $this->db->from($this->schema);
        $result = $this->db->get();

        if ($result && count($result)) {
            return new User(
                $result['username'],
                $result['password'],
                $result['name'],
                $result['id']
            );
        }

        return null;
    }
}
