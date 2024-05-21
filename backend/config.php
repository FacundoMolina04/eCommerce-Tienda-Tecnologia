<?php

class Database {
    private $host = "localhost";
    private $db_name = "tallerphp";
    private $username = "tecnologo";
    private $password = "tecnologo";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {

            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
           mysqli_select_db($this->conn, $this->db_name);
        } catch(Exception $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
