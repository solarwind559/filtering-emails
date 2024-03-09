<?php

class Database {
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function __construct() {
        $this->servername = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->dbname = 'subscribers';
    }

    public function connect() {
        return new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }

    public function executeQuery($sql) {
        $conn = $this->connect();
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    public function fetchData($sql) {
        $result = $this->executeQuery($sql);
        $data = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "Error executing query: " . $this->connect()->error;
        }

        return $data;
    }
}
