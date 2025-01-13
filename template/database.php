<?php

class database {
    public $host = "localhost"; 
    public $user = "root";
    public $password = "";
    public $dbname = "db_dokumentasi";
    public $conn;

    public function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbname);
    }
}

?>
