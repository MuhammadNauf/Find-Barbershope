<?php

class Koneksi {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "db_barbershop";
    private $conn;

    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}
?>
