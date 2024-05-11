<?php

class UserAccounts extends Model
{
    public function __construct()
    {
        $this->tableName = 'user_accounts';
    }

    public function getUserAccounts(): array
    {
        $this->sql = "SELECT * FROM $this->tableName";

        return $this->getList();
    }
}
