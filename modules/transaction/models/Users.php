<?php

class Users extends Model
{
    public function __construct()
    {
        $this->tableName = 'users';
    }

    public function getUsers(): array
    {
        $this->sql = "SELECT * FROM $this->tableName";

        return $this->getList();
    }

    public function searchUsers($name)
    {
        $this->sql = "SELECT * FROM $this->tableName WHERE name LIKE '%$name%';";

        return $this->getList();
    }
}
