<?php

class Model
{
    public string $tableName;
    protected string $sql;

    /**
     * Connecting to the database.
     * @return bool|mysqli_result
     */
    private function connection()
    {
        require_once "config/database.php";

        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        $string = $conn->query($this->sql);
        $conn->close();

        return $string;
    }

    /**
     * Returns data (entire table or part of data).
     * @param array $select
     * @param array $filter
     * @return array
     */
    public function getList(): array
    {
        $obj = $this->connection();
        $result = [];

        while ($elem = $obj->fetch_assoc()) {
            array_push($result, $elem);
        }
        return $result;
    }
}
