<?php

class Transactions extends Model
{
    public function __construct()
    {
        $this->tableName = 'transactions';
    }

    public function getTransaction($userId): array
    {
        $this->sql = "SELECT * FROM $this->tableName WHERE account_from = $userId OR account_to = $userId";

        return $this->getList();
    }
}
